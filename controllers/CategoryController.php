<?php

namespace mata\category\controllers;

use mata\category\models\Category;
use mata\category\models\CategorySearch;
use matacms\controllers\module\Controller;

class CategoryController extends Controller {

	public function getModel() {
		return new Category();
	}

	public function getSearchModel() {
		return new CategorySearch();
	}
}
