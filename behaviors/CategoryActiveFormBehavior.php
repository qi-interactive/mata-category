<?php

namespace mata\category\behaviors;

use Yii;
use mata\category\models\Category;
use mata\category\models\CategoryItem;
use matacms\helpers\Html;
use yii\helpers\ArrayHelper;

class CategoryActiveFormBehavior extends  \yii\base\Behavior {

	public function category($options = []) {

		$options = array_merge($this->owner->inputOptions, $options);

		$this->owner->adjustLabelFor($options);
		$this->owner->labelOptions["label"] = "Category"; 
		$this->owner->parts['{input}'] = Html::activeCategoryField($this->owner->model, $options);

		return $this->owner;
	}

}