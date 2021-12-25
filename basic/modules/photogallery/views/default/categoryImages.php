<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\bootstrap4\LinkPager;
use yii\helpers\Url;
use app\modules\photogallery\assets\BaguetteBox;
use app\modules\photogallery\assets\InfiniteScrollCategoryImagesAsset;

BaguetteBox::register($this);
InfiniteScrollCategoryImagesAsset::register($this);

$this->title = $category->title;
?>

<div class="photogallery-default-category-images">


    <h1 class="mb-4"><?= Html::encode($this->title) ?></h1>
    <?php
    echo LinkPager::widget([
        'pagination' => $pages,
    ]);
    ?>
    <div class="load-animation-container"> 
        <img class="load-animation" src="<?= Url::to('web/animations/Balls.gif', 'http') ?>" alt="animation"/>
    </div>

    <div class="image-grid">
        <?php if (isset($images)): ?>
            <?php foreach ($images as $image): ?>
                <a class="image-container" href="<?= Url::to($image['image'], 'http') ?>" data-caption="<?= $image->title ?>">
                    <img class="image-grid-element" src="<?= Url::to($image['image'], 'http') ?>"/>    
                </a>
            <?php endforeach; ?>
        <?php endif; ?>

    </div>
<!--    <div style="display: flex; justify-content: center;">
        <?= Html::button('Next', ['onclick' => "infiniteScroll('$category->slug')", 'style' => 'margin-top: 30px;']) ?>
    </div>-->
</div>
<?php
$this->registerJs("categorySlug = '$category->slug'; imagesLimit = '$pages->limit'");
?>

