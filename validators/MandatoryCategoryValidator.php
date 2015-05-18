<?php
 
/**
 * @link http://www.matacms.com/
 * @copyright Copyright (c) 2015 Qi Interactive Limited
 * @license http://www.matacms.com/license/
 */

namespace mata\category\validators;

use Yii;
use yii\validators\Validator;
use yii\web\JsExpression;
use yii\helpers\Json;
use yii\helpers\Inflector;
use mata\category\validators\MandatoryCategoryValidationAsset;
use mata\helpers\StringHelper;
use mata\category\models\CategoryItem;

class MandatoryCategoryValidator extends Validator
{

    public function init()
    {

        parent::init();
        $this->skipOnEmpty = false;
        if ($this->message === null)
            $this->message = Yii::t('yii', '{attribute} cannot be blank.');
        
    }

    public function validateAttribute($model, $attribute)
    {

        $categories = \Yii::$app->request->post(CategoryItem::REQ_PARAM_CATEGORY_ID);

        if(empty($categories)) {
            $model->addError($attribute, \Yii::t('yii', '{attribute} cannot be blank.', ['attribute' => Inflector::camel2words($attribute)]));
        }

    }

    public function clientValidateAttribute($model, $attribute, $view) {

        $options = [
            'attribute' => $attribute,
            'name' => CategoryItem::REQ_PARAM_CATEGORY_ID, 
            'message' => Yii::$app->getI18n()->format($this->message, [
                'attribute' => Inflector::camel2words($attribute),
            ], Yii::$app->language),
        ];

        MandatoryCategoryValidationAsset::register($view);
        return 'matacategory.validation.mandatory($form, value, messages, ' . Json::encode($options) . ');';
    }
}
