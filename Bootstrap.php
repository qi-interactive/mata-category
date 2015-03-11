<?php 

namespace mata\category;

use Yii;
use mata\category\behaviors\CategoryActiveFormBehavior;
use yii\base\Event;
use matacms\widgets\ActiveField;
use mata\base\MessageEvent;
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

	}

	private function processSave($model) {

		if (empty($categoryId = Yii::$app->request->post(CategoryItem::REQ_PARAM_CATEGORY_ID)))
			return;

		$documentId = $model->getDocumentId();

		CategoryItem::deleteAll([
			"DocumentId" => $documentId
			]);

		$categoryItem = new CategoryItem();
		$categoryItem->attributes = [
		"CategoryId" => $categoryId,
		"DocumentId" => $documentId
		];

		try {
			if ($categoryItem->save() == false)
				throw new \yii\web\ServerErrorHttpException($categoryItem->getTopError());

		} catch(yii\db\IntegrityException $e) {

		// Create the missing category

			$categoryItem->save();

		// echo $e;
		// exit;
		}

	}
}
