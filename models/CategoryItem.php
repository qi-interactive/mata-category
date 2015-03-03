<?php

namespace mata\category\models;

use Yii;
use mata\category\models\Category;
/**
 * This is the model class for table "{{%mata_categoryitem}}".
 *
 * @property integer $CategoryId
 * @property string $DocumentId
 * @property integer $Order
 *
 * @property MataCategory $category
 */
class CategoryItem extends \matacms\db\ActiveRecord {

    public function behaviors() {
       return [
       [
           'class' => IncrementalBehavior::className(),
           'findBy' => "CategoryId",
           'incrementField' => "Order"
       ]
       ];
   }
    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%mata_categoryitem}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        [['CategoryId', 'DocumentId', 'Order'], 'required'],
        [['CategoryId', 'Order'], 'integer'],
        [['DocumentId'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
        'CategoryId' => 'Category ID',
        'DocumentId' => 'Document ID',
        'Order' => 'Order',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory() {
        return $this->hasOne(Category::className(), ['Id' => 'CategoryId']);
    }
}