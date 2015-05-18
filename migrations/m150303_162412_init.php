<?php
 
/**
 * @link http://www.matacms.com/
 * @copyright Copyright (c) 2015 Qi Interactive Limited
 * @license http://www.matacms.com/license/
 */

use yii\db\Schema;
use yii\db\Migration;

class m150303_162412_init extends Migration {

	public function safeUp() {
		$this->createTable('{{%mata_category}}', [
			'Id'                   => Schema::TYPE_PK,
			'Name'             => Schema::TYPE_STRING . '(255) NOT NULL',
			'URI'	=> Schema::TYPE_STRING . '(255) NOT NULL',
			'Grouping' => Schema::TYPE_STRING . '(128) NOT NULL'
			]);

		$this->createTable('{{%mata_categoryitem}}', [
			'CategoryId'      => Schema::TYPE_INTEGER . ' NOT NULL',
			'DocumentId'   => Schema::TYPE_STRING . '(64) NOT NULL',
			'Order' =>  Schema::TYPE_INTEGER . ' NOT NULL'
			]);

		$this->addForeignKey('fk_matacategoryitem', '{{%mata_categoryitem}}', 'CategoryId', '{{%mata_category}}', 'Id', 'CASCADE', 'RESTRICT');

	}

	public function safeDown() {
		$this->dropTable('{{%mata_categoryitem}}');
		$this->dropTable('{{%mata_category}}');
	}
	
}