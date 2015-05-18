<?php
 
/**
 * @link http://www.matacms.com/
 * @copyright Copyright (c) 2015 Qi Interactive Limited
 * @license http://www.matacms.com/license/
 */

namespace mata\category\models;

use Yii;
use mata\category\models\Category;
use mata\behaviors\IncrementalBehavior;
use yii\db\ActiveQuery;

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

    const REQ_PARAM_CATEGORY_GROUPING = "category-item-category-grouping";
    const REQ_PARAM_CATEGORY_ID = "category-item-category-id";

    public function behaviors() {
       return [
       [
       'class' => IncrementalBehavior::className(),
       'findBy' => "CategoryId",
       'incrementField' => "Order"
       ]
       ];
   }


   public static function find() {
     return new CategoryItemQuery(get_called_class());
 }

    public static function tableName() {
        return '{{%mata_categoryitem}}';
    }

    public function rules()
    {
        return [
        [['CategoryId', 'DocumentId', 'Order'], 'required'],
        [['Order'], 'integer']
        ];
    }

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

class CategoryItemQuery extends ActiveQuery {

    public function forItem($item) {

        if (is_object($item))
            $item = $item->getDocumentId()->getId();

        $this->andWhere(['DocumentId' => $item]);
        return $this;
    }

}
