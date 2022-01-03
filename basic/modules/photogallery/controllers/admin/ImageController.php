<?php

namespace app\modules\photogallery\controllers\admin;

use app\modules\photogallery\models\Image;
use app\modules\photogallery\models\admin\ImageSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\photogallery\models\admin\ImageCreateForm;
use yii\web\UploadedFile;
use yii\helpers\Url;
use Yii;
use yii\web\HttpException;

/**
 * ImageController implements the CRUD actions for Image model.
 */
class ImageController extends Controller {

    public $layout = 'admin';

    /**
     * @inheritDoc
     */
    public function behaviors() {
        return array_merge(
                parent::behaviors(),
                [
                    'verbs' => [
                        'class' => VerbFilter::className(),
                        'actions' => [
                            'delete' => ['POST'],
                        ],
                    ],
                ]
        );
    }

    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);
        $username = Yii::$app->user->isGuest ? "guest" : Yii::$app->user->identity->username;
        if ($username !== "admin") {
            throw new HttpException(403, 'Oops. You not admin');
        }
    }

    /**
     * Lists all Image models.
     * @return mixed
     */
    public function actionIndex($slug) {
        $searchModel = new ImageSearch();
        $dataProvider = $searchModel->search($this->request->queryParams, $slug);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Image model.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Image model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new ImageCreateForm();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
                if ($model->save()) {
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        }/* else {
          $model->loadDefaultValues();
          } */

        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing Image model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Image model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        $image = $this->findModel($id);
        unlink(Url::to("@app".Yii::getAlias($image->image)));
        $image->delete();

        $imageCategory = \app\modules\photogallery\models\Category::findOne(['slug' => $image->category]);
        $imageCategory->count = $imageCategory->count - 1;
        $imageCategory->save();

        return $this->redirect(Url::toRoute(['admin/image/index', 'slug' => $image->category]));
    }

    /**
     * Finds the Image model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Image the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Image::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
