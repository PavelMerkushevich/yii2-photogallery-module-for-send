<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\photogallery\models\Category;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\modules\photogallery\models\Image */

$this->title = 'Create Image';
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => Url::toRoute(['admin/category/index'])];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="image-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="image-form">

        <?php $form = ActiveForm::begin(['id' => 'image', 'options' => ['enctype' => 'multipart/form-data']]) ?>

        <?= $form->field($model, 'title', ['inputOptions' => ['id' => 'image-title', 'class' => 'form-control']])->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'author', ['inputOptions' => ['id' => 'image-author', 'class' => 'form-control']])->textInput(['maxlength' => true]) ?>

        <?=
        $form->field($model, 'category', ['inputOptions' => ['id' => 'image-category', 'class' => 'form-control']])->dropDownList(ArrayHelper::map(Category::find()->all(), 'slug', 'title'), [
            'prompt' => 'Select category...'
        ])
        ?>

        <?= $form->field($model, 'status', ['inputOptions' => ['id' => 'image-status', 'class' => 'form-control']])->dropDownList(['guest' => 'guest', 'user' => 'user', 'admin' => 'admin', 'link' => 'link']) ?>

        <?= $form->field($model, 'watermark', ['inputOptions' => ['id' => 'image-watermark', 'class' => 'form-control']])->dropDownList(['none' => 'do not use', 'lt' => 'left top', 'rt' => 'right top', 'lb' => 'left bottom', 'rb' => 'right bottom']) ?>

        <?= $form->field($model, 'imageFile', ['inputOptions' => ['id' => 'image-file', 'class' => 'form-control']])->fileInput() ?>
        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
