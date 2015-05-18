<?php
 
/**
 * @link http://www.matacms.com/
 * @copyright Copyright (c) 2015 Qi Interactive Limited
 * @license http://www.matacms.com/license/
 */

use yii\db\Schema;
use mata\user\migrations\Migration;

class m150428_141312_addIndexes extends Migration
{
    public function safeUp() {
        $this->createIndex("UQ_Name_Grouping", "{{%mata_category}}", ["Grouping", "Name"], true);
        $this->createIndex("UQ_URI", "{{%mata_category}}", "URI", true);
    }
}