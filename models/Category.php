<?php

namespace mata\category\models;

use Yii;
use mata\category\models\CategoryItem;

/**
 * This is the model class for table "{{%mata_category}}".
 *
 * @property integer $Id
 * @property string $Name
 * @property string $URI
 *
 * @property MataCategoryitem[] $mataCategoryitems
 */
class Category extends \matacms\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%mata_category}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        [['Name', 'URI'], 'required'],
        [['Name'], 'string'],
        [['URI'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
        'Id' => 'ID',
        'Name' => 'Name',
        'URI' => 'Uri',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMataCategoryitems() {
        return $this->hasMany(MataCategoryItem::className(), ['CategoryId' => 'Id']);
    }
}