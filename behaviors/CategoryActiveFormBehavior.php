<?php

namespace mata\category\behaviors;

use Yii;
use mata\category\models\Category;
use mata\category\models\CategoryItem;
use yii\helpers\Html;

class CategoryActiveFormBehavior extends  \yii\base\Behavior {

	public function category($options = []) {

		$options = array_merge($this->owner->inputOptions, $options);

		$this->owner->adjustLabelFor($options);
		$this->owner->labelOptions["label"] = "Category"; 

		// $this->owner->parts['{input}'] = Html::activeTextInput($this->owner->model, $this->owner->attribute, array_merge([
		// 	"name" => CategoryItem::REQ_PARAM_CATEGORY_ID,
		// 	"value" => 1,
		// 	], $options));


print_r($options);

$options["value"] = 1;
		$this->owner->selectize($options);

		$grouping = isset($options["grouping"]) ?: Category::generateGroupingFromObject($this->owner->model);

		$this->owner->parts['{input}'] .= Html::activeHiddenInput($this->owner->model, $this->owner->attribute, [
			"name" => CategoryItem::REQ_PARAM_CATEGORY_GROUPING,
			"value" => $grouping
			]);



		return $this->owner;
	}

}