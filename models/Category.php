<?php
 
/**
 * @link http://www.matacms.com/
 * @copyright Copyright (c) 2015 Qi Interactive Limited
 * @license http://www.matacms.com/license/
 */

namespace mata\category\models;

use Yii;
use mata\category\models\CategoryItem;
use matacms\db\ActiveQuery;

/**
 * This is the model class for table "{{%mata_category}}".
 *
 * @property integer $Id
 * @property string $Name
 * @property string $URI
 *
 * @property MataCategoryitem[] $mataCategoryitems
 */
class Category extends \matacms\db\ActiveRecord {

    public static function tableName()
    {
        return '{{%mata_category}}';
    }

    public function behaviors() {
      return [
     
      ];
    }

    public static function find() {
      return new CategoryQuery(get_called_class());
  }

    public function rules()
    {
        return [
        [['Name', 'URI', 'Grouping'], 'required'],
        [['Name'], 'string'],
        [['URI', 'Name'], 'string', 'max' => 255],
        [['Grouping'], 'string', 'max' => 128]
        ];
    }

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
    public function getItems() {
        return $this->hasMany(CategoryItem::className(), ['CategoryId' => 'Id']);
    }

    public static function generateGroupingFromObject($obj) {
        return get_class($obj);
    }
}

class CategoryQuery extends ActiveQuery {
    
    /**
     *  Categories for various models / groups will be stored in one table. 
     * The grouping allows to differentiate between categories belonging to one, but not another.
     * For instance, ->grouping("books") or ->grouping($postModel) will return different results. 
     */ 
    public function grouping($grouping) {

        if (is_object($grouping))
            $grouping = Category::generateGroupingFromObject($grouping);

        $this->andWhere(['Grouping' => $grouping]);
        $this->orderBy('Name ASC');
        return $this;
    }

    public function forWorkProjects() {
        $this->join('INNER JOIN', 'mata_categoryitem', 'mata_categoryitem.CategoryId = mata_category.Id');
        $this->orderBy('Name ASC');
        return $this;
    }

    public function forItem($item) {
        
        if (is_object($item))
            $item = $item->getDocumentId()->getId();

        $this->join('INNER JOIN', 'mata_categoryitem', 'mata_categoryitem.CategoryId = mata_category.Id');
        $this->andWhere(['DocumentId' => $item]);
        return $this;
    }
}
