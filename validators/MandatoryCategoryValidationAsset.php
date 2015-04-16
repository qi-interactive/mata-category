<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace mata\category\validators;

use yii\web\AssetBundle;

/**
 * This asset bundle provides the javascript files for client validation.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
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
