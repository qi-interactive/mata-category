<?php

/**
 * @link http://www.matacms.com/
 * @copyright Copyright (c) 2015 Qi Interactive Limited
 * @license http://www.matacms.com/license/
 */

namespace mata\category;

use Yii;
use mata\category\behaviors\CategoryActiveFormBehavior;
use yii\base\Event;
use yii\base\Model;
use matacms\widgets\ActiveField;
use mata\base\MessageEvent;
use mata\category\models\Category;
use mata\category\models\CategoryItem;

//TODO Dependency on matacms
use matacms\controllers\module\Controller;

class Bootstrap extends \mata\base\Bootstrap {

	public function bootstrap($app) {

		Event::on(ActiveField::className(), ActiveField::EVENT_INIT_DONE, function(MessageEvent $event) {
			$event->getMessage()->attachBehavior('category', new CategoryActiveFormBehavior());
		});

		Event::on(Controller::class, Controller::EVENT_MODEL_UPDATED, function(\matacms\base\MessageEvent $event) {
			$this->processSave($event->getMessage());
		});

		Event::on(Controller::class, Controller::EVENT_MODEL_CREATED, function(\matacms\base\MessageEvent $event) {
			$this->processSave($event->getMessage());
		});

        Event::on(Controller::class, Controller::EVENT_MODEL_DELETED, function(\matacms\base\MessageEvent $event) {
			$this->processDelete($event->getMessage());
		});

		Event::on(Model::class, Model::EVENT_BEFORE_VALIDATE, function(\yii\base\ModelEvent $event) {
			if($event->sender instanceof \mata\db\ActiveRecord) {
				$activeValidators = $event->sender->getActiveValidators();

				foreach($activeValidators as $validator) {
					if(get_class($validator) != 'mata\category\validators\MandatoryCategoryValidator')
						continue;

					$event->sender->addAdditionalAttribute(CategoryItem::REQ_PARAM_CATEGORY_ID);
				}
			}

		});
	}

	private function processSave($model) {

		if (empty($categories = Yii::$app->request->post(CategoryItem::REQ_PARAM_CATEGORY_ID)))
			return;

		$documentId = $model->getDocumentId()->getId();

		CategoryItem::deleteAll([
			"DocumentId" => $documentId
			]);

		if(is_array($categories)) {
			foreach ($categories as $category) {
				$this->saveCategory($category, $model, $documentId);
			}
		} elseif(is_string($categories)) {
			$this->saveCategory($categories, $model, $documentId);
		}
	}

	private function saveCategory($category, $model, $documentId)
	{
		$categoryModel = Category::find()->where(["Name" => $category, 'Grouping' => Category::generateGroupingFromObject($model)])->one();

		if ($categoryModel == null) {
			$categoryModel = new Category();
			$categoryModel->attributes = [
			"Name" => Yii::$app->request->post(CategoryItem::REQ_PARAM_CATEGORY_ID),
			"URI" => Yii::$app->request->post(CategoryItem::REQ_PARAM_CATEGORY_ID),
			"Grouping" => Category::generateGroupingFromObject($model)
			];

			if (!$categoryModel->save())
				throw new \yii\web\ServerErrorHttpException($categoryModel->getTopError());

		}

		$categoryItem = new CategoryItem();
		$categoryItem->attributes = [
		"CategoryId" => $categoryModel->Id,
		"DocumentId" => $documentId
		];

		if ($categoryItem->save() == false)
			throw new \yii\web\ServerErrorHttpException($categoryItem->getTopError());
	}

    private function processDelete($model) {

		$documentId = $model->getDocumentId()->getId();

		CategoryItem::deleteAll([
			"DocumentId" => $documentId
			]);
	}
}
