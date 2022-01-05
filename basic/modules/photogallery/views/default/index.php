
<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\bootstrap4\LinkPager;
use yii\helpers\Url;
use app\modules\photogallery\assets\InfiniteScrollCategoriesAsset;

InfiniteScrollCategoriesAsset::register($this);

$this->title = 'Images categories';
?>

<div class="photogallery-default-index">

    <h1 class="mb-4"><?= Html::encode($this->title) ?></h1>
    <?php
    echo LinkPager::widget([
        'pagination' => $pages,
    ]);
    ?>
    <div class="load-animation-container"> 
        <img class="load-animation" src="<?= Url::to('web/animations/Balls.gif', 'http') ?>" alt="animation"/>
    </div>
    <div class="category-grid">
        <?php foreach ($categories as $category): ?>
            <?php
            $username = Yii::$app->user->isGuest ? "guest" : Yii::$app->user->identity->username;
            if ($username === "demo") {
                $queryStatus = "status!='link' AND status!='admin' AND category='$category->slug' AND image!=''";
            } elseif ($username === "admin") {
                $queryStatus = "category='$category->slug' AND image!=''";
            } else {
                $queryStatus = "status='guest' AND category='$category->slug' AND image!=''";
            }
            $image = (new \yii\db\Query())
                    ->select(['image', 'title', 'id'])
                    ->from('image')
                    ->where($queryStatus)
                    ->orderBy(['id' => SORT_DESC])
                    ->one();
            ?>
            <?php if ($image != ""): ?>
                <a class="gallery-item" href="<?= Url::to(['default/category-images', 'slug' => $category->slug]) ?>", style="text-decoration: none;">      
                    <div class="category-info-container">
                        <div class="small-image" style='background: url("<?= Url::to($image['image'], 'http') ?>"); background-size: cover;'>
                            <div style="display: flex; align-items: center; justify-content: center; background-color: rgba(0,0,0,.60); width:100%; height: 25%;">
                                <span style="color: whitesmoke;"> <span class="category-title"><?= $category->title ?></span> <span class="badge bg-secondary category-count" style="opacity: 0.8; border-radius: 6px;"><?= $category->count ?></span></span>
                            </div>
                        </div>
                    </div>
                </a>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>

</div>
<?php
$this->registerJs("categoriesLimit = '$pages->limit'");
?>