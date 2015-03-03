<?php 

namespace matacms\settings;

use yii\base\BootstrapInterface;
use yii\base\Event;
use yii\db\BaseActiveRecord;
use mata\keyvalue\models\KeyValue;
use matacms\settings\models\Setting;
use matacms\widgets\ActiveField;

class Bootstrap implements BootstrapInterface {

	public function bootstrap($app) {

		Event::on(ActiveField::className(), ActiveField::EVENT_INIT_DONE, function($event) {
			echo "CAUGHT";
		});

	}

}


// $this->attachBehavior('category', new CategoryActiveFormBehavior());