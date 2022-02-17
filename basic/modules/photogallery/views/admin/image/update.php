<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\photogallery\models\Category;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\modules\photogallery\models\Image */

$this->title = 'Update Image: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url'=> ['admin/category/index']];
$this->params['breadcrumbs'][] = ['label' => 'Category images', 'url' => ['admin/image/index', 'slug' => $model->category]];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';

?>
<div class="image-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="image-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

        <?=
        $form->field($model, 'category')->dropDownList(ArrayHelper::map(Category::find()->all(), 'slug', 'title'))
        ?>

        <?= $form->field($model, 'status')->dropDownList(['guest' => 'guest', 'user' => 'user', 'admin' => 'admin', 'link' => 'link']) ?>

        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
