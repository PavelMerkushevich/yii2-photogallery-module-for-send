<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\modules\photogallery\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class InfiniteScrollCategoryImagesAsset extends AssetBundle {


    public function init() {
        
        $this->sourcePath = '@app/modules/photogallery/assets';
        parent::init();
    }

    public $js = [
      'js/infiniteScrollCategoryImages.js',
    ];
    public $css = [];

    public $depends = [
        'yii\web\JqueryAsset',
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapAsset',
    ];

}

