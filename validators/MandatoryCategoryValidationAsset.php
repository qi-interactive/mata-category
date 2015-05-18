<?php
 
/**
 * @link http://www.matacms.com/
 * @copyright Copyright (c) 2015 Qi Interactive Limited
 * @license http://www.matacms.com/license/
 */

namespace mata\category\validators;

use yii\web\AssetBundle;

class MandatoryCategoryValidationAsset extends AssetBundle
{
    public $sourcePath = '@vendor/mata/mata-category/assets';
    public $js = [
        'js/matacategory.validation.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
