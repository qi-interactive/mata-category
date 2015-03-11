<?php

namespace mata\category\behaviors;

use Yii;
use mata\category\models\Category;
use mata\category\models\CategoryItem;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

class CategoryActiveFormBehavior extends  \yii\base\Behavior {

	public function category($options = []) {

		$options = array_merge($this->owner->inputOptions, $options);

		$this->owner->adjustLabelFor($options);
		$this->owner->labelOptions["label"] = "Category"; 

		$items = ArrayHelper::map(Category::find()->grouping($this->owner->model)->all(), 'Id', 'Name');
		$value = CategoryItem::find()->forItem($this->owner->model)->one();

		if ($value != null)
			$options["value"] = $value->CategoryId;

		$this->owner->autocomplete($items, $options);

		$grouping = isset($options["grouping"]) ?: Category::generateGroupingFromObject($this->owner->model);

		$this->owner->parts['{input}'] .= Html::activeHiddenInput($this->owner->model, $this->owner->attribute, [
			"name" => CategoryItem::REQ_PARAM_CATEGORY_GROUPING,
			"value" => $grouping
			]);

		return $this->owner;
	}

}