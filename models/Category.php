<?php

namespace mata\category\models;

use Yii;
use mata\category\models\CategoryItem;
use yii\db\ActiveQuery;

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

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%mata_category}}';
    }

    public static function find() {
      return new CategoryQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        [['Name', 'URI', 'Grouping'], 'required'],
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
        return $this;
    }

}
