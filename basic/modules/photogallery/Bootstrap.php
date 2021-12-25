<?php

namespace app\modules\photogallery;

use yii\base\BootstrapInterface;

class Bootstrap implements BootstrapInterface {

    /**
     * @inheritdoc
     */
    public function bootstrap($app) {

        $app->getUrlManager()->addRules(
                [
                    '/<page>' => 'photogallery/default/index',
                    '/' => 'photogallery/default/index',
                    ////////////////////////////////////////////////////////
                    '/page/category/<slug>/<page>' => 'photogallery/default/category-images',
                    '/page/category/<slug>' => 'photogallery/default/category-images',                 
                    ////////////////////////////////////////////////////////
                    '/photo/admin/images/<slug>' => 'photogallery/admin/image/index',
                    '/photo/admin/image/create' => 'photogallery/admin/image/create',
                    '/photo/admin/image/update' => 'photogallery/admin/image/update',
                    '/photo/admin/image/delete' => 'photogallery/admin/image/delete',
                    '/photo/admin/image/view' => 'photogallery/admin/image/view',
                    ////////////////////////////////////////////////////////
                    '/photo/admin' => 'photogallery/admin/category/index',
                    '/photo/admin/category/create' => 'photogallery/admin/category/create',
                    '/photo/admin/category/update' => 'photogallery/admin/category/update',
                    '/photo/admin/category/delete' => 'photogallery/admin/category/delete',
                    '/photo/admin/category/view' => 'photogallery/admin/category/view',
                ]
        );
    }

}
