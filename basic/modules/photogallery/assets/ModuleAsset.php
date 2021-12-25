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
class ModuleAsset extends AssetBundle {


    public function init() {
        
        $this->sourcePath = '@app/modules/photogallery/assets';
        parent::init();
    }

    public $js = [
//        'https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js',
        'masonry/masonry.pkgd.min.js',
        'js/gridScript.js'
    ];
    
    public $css = [
        'css/photogallery.css',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapAsset',
    ];

}
