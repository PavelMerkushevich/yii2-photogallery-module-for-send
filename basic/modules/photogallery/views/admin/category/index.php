<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\photogallery\models\admin\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Categories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php
        $categoriesCount = Yii::$app->db->createCommand("SELECT COUNT(*) FROM category")->queryOne();
        ?>
        <?= Html::a('Create Category', ['create'], ['class' => 'btn btn-success']) ?>
        <?php if ($categoriesCount['COUNT(*)'] > 0): ?>
            <?= Html::a('Create Image', ['admin/image/create'], ['class' => 'btn btn-success']) ?>
        <?php endif; ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            [
                'attribute' => 'title',
                'label' => 'Title',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a($model->title, $model->getUrlToCategoryImages());
                },
            ],
            'slug',
            'status',
            'count',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);
    ?>


</div>
