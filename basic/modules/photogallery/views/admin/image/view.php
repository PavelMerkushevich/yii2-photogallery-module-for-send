<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\modules\photogallery\models\Image */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url'=> ['admin/category/index']];
$this->params['breadcrumbs'][] = ['label' => 'Category images', 'url' => ['admin/image/index', 'slug' => $model->category]];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

?>
<div class="image-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'author',
            'category',
            'title',
            'date',
            'status',
            'extension',
            'image',
        ],
    ]) ?>

</div>
