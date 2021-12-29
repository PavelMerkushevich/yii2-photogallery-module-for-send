<?php

namespace app\modules\photogallery\controllers;

use yii\web\Controller;
use app\modules\photogallery\models\Category;
use app\modules\photogallery\models\Image;
use yii\data\Pagination;
use Yii;
use yii\web\HttpException;

/**
 * Default controller for the `photogallery` module
 */
class DefaultController extends Controller
{

    public $layout = 'default';

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {

        $username = Yii::$app->user->isGuest ? "guest" : Yii::$app->user->identity->username;

        if ($username === "demo") {
            $queryStatus = "status!='link' AND status!='admin'";
        } elseif ($username === "admin") {
            $queryStatus = "";
        } else {
            $queryStatus = "status='guest'";
        }

        $query = Category::find()->where($queryStatus)->orderBy(['id' => SORT_DESC]);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 12]);
        $categories = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        if (Yii::$app->request->isAjax) {
            $pageNumber = (int)Yii::$app->request->post("pageNumber");
            $categoriesLimit = (int)$pages->limit;
            $allCategories = (new \yii\db\Query())
                ->select(['slug', 'count', 'title', 'id'])
                ->from('category')
                ->where($queryStatus)
                ->orderBy(['id' => SORT_DESC])
                ->all();
            $categoriesCount = $countQuery->count();
            $maxPage = ceil($categoriesCount / $categoriesLimit);
            $categoriesStart = $categoriesLimit * $pageNumber;
            $nextPage = $pageNumber + 1;
            $categoriesEnd = $categoriesLimit * $nextPage;

            $lastIndex = 0;
            if ($pageNumber < $maxPage) {
                for ($i = $categoriesStart; $i < $categoriesEnd; $i++) {
                    if (isset($allCategories[$i])) {
                        $NextCategories[] = $allCategories[$i];
                        $CategorySlug = $NextCategories[$lastIndex]['slug'];
                        if ($username === "demo") {
                            $queryStatusForImagePath = "status!='link' AND status!='admin' AND category='$CategorySlug'";
                        } elseif ($username === "admin") {
                            $queryStatusForImagePath = "category='$CategorySlug'";
                        } else {
                            $queryStatusForImagePath = "status='guest' AND category='$CategorySlug'";
                        }
                        $imagePath = (new \yii\db\Query())
                            ->select(['image', 'title', 'id'])
                            ->from('image')
                            ->where($queryStatusForImagePath)
                            ->orderBy(['id' => SORT_DESC])
                            ->one();
                        if ($imagePath) {
                            $NextCategories[$lastIndex]['imagePath'] = $imagePath['image'];
                        }
                    } else {
                        break;
                    }
                    $lastIndex++;
                }
            } else {
                for ($i = 0; $i < $categoriesLimit; $i++) {
                    if (isset($allCategories[$i])) {
                        $NextCategories[] = $allCategories[$i];
                        $CategorySlug = $NextCategories[$lastIndex]['slug'];
                        if ($username === "demo") {
                            $queryStatusForImagePath = "status!='link' AND status!='admin' AND category='$CategorySlug'";
                        } elseif ($username === "admin") {
                            $queryStatusForImagePath = "category='$CategorySlug'";
                        } else {
                            $queryStatusForImagePath = "status='guest' AND category='$CategorySlug'";
                        }
                        $imagePath = (new \yii\db\Query())
                            ->select(['image', 'title', 'id'])
                            ->from('image')
                            ->where($queryStatusForImagePath)
                            ->orderBy(['id' => SORT_DESC])
                            ->one();
                        if ($imagePath) {
                            $NextCategories[$lastIndex]['imagePath'] = $imagePath['image'];
                        }
                    } else {
                        break;
                    }
                    $lastIndex++;
                }
                $nextPage = 1;
            }
            return json_encode(["NextCategories" => $NextCategories, "nextPage" => $nextPage]);
        }

        return $this->render('index', compact('pages', 'categories'));
    }

    public function actionCategoryImages($slug)
    {

        $category = Category::findOne(['slug' => $slug]);
        if (!$category) {
            throw new HttpException(404, "Page not found.");
        }

        $username = Yii::$app->user->isGuest ? "guest" : Yii::$app->user->identity->username;

        if ($category->status === "admin") {
            if (Yii::$app->user->isGuest || $username === "demo") {
                throw new HttpException(403, "Oops. You can't look this page!");
            }
        } elseif ($category->status === "user" && Yii::$app->user->isGuest) {
            throw new HttpException(403, "Oops. You can't look this page!");
        }
        if (!isset($_SERVER['HTTP_REFERER'])) {

            if ($username === "demo") {
                $queryStatus = "status!='admin' AND category='$slug'";
            } elseif ($username === "admin") {
                $queryStatus = "category='$slug'";
            } else {
                $queryStatus = "status!='user' AND status!='admin' AND category='$slug'";
            }
        } else {

            if ($username === "demo") {
                $queryStatus = "status!='link' AND status!='admin' AND category='$slug'";
            } elseif ($username === "admin") {
                $queryStatus = "category='$slug'";
            } else {
                $queryStatus = "status='guest' AND category='$slug'";
            }
        }

        $query = Image::find()->where($queryStatus)->orderBy(['id' => SORT_DESC]);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 12]);
        $images = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        if (Yii::$app->request->isAjax) {
            $pageNumber = (int)Yii::$app->request->post("pageNumber");
            $imagesLimit = (int)$pages->limit;
            $allImages = (new \yii\db\Query())
                ->select(['image', 'title', 'id'])
                ->from('image')
                ->where($queryStatus)
                ->orderBy(['id' => SORT_DESC])
                ->all();
            $imagesCount = $countQuery->count();
            $maxPage = ceil($imagesCount / $imagesLimit);
            $imagesStart = $imagesLimit * $pageNumber;
            $nextPage = $pageNumber + 1;
            $imagesEnd = $imagesLimit * $nextPage;
            if ($pageNumber < $maxPage) {
                for ($i = $imagesStart; $i < $imagesEnd; $i++) {
                    if (isset($allImages[$i])) {
                        $NextImages[] = $allImages[$i];
                    } else {
                        break;
                    }
                }
            } else {
                for ($i = 0; $i < $imagesLimit; $i++) {
                    if (isset($allImages[$i])) {
                        $NextImages[] = $allImages[$i];
                    } else {
                        break;
                    }
                }
                $nextPage = 1;
            }
            return json_encode(["NextImages" => $NextImages, "nextPage" => $nextPage]);
        }
        return $this->render('categoryImages', compact('pages', 'images', 'category'));
    }

}
