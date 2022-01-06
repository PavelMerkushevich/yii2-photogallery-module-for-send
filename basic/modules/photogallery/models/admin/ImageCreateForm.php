<?php

namespace app\modules\photogallery\models\admin;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;
use yii\helpers\Url;
use app\modules\photogallery\models\Image;
use app\modules\photogallery\models\Category;

class ImageCreateForm extends Model {

    /**
     * {@inheritdoc}
     */
    public $id;
    public $author;
    public $category;
    public $title;
    public $date;
    public $status;
    public $extension;
    public $image;
    ///////////////////
    public $watermark;
    public $imageFile;

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['category', 'title', 'status', 'watermark'], 'required'],
            [['author', 'category', 'title', 'date', 'extension', 'image'], 'string', 'max' => 50],
//            ['image', 'unique'],
            [['status'], 'string', 'max' => 10],
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, gif, jpg, jpeg'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'slug' => 'Slug',
        ];
    }

    public function save() {
        if ($this->validate()) {

            $image = new Image;
            $image->author = $this->author;
            $image->category = $this->category;
            $image->title = $this->title;
            $image->date = date("d.m.y");
            $image->status = $this->status;
            $image->extension = $this->imageFile->extension;
            if ($image->save()) {
                $this->processingImage($image);
                $image->image = '@web/images/photogallery/' . $image->id . '.' . $image->extension;
                $imageCategory = Category::findOne(["slug" => $image->category]);
                if ($image->save()) {
                    $imagesCount = Yii::$app->db->createCommand("SELECT COUNT(*) FROM image WHERE category = '$image->category'")->queryOne();
                    $imageCategory->count = $imagesCount['COUNT(*)'];
                    if($imageCategory->save()){
                        Yii::$app->session->setFlash("success", "Image successfully saved!");
                    }
                } else {
                    Yii::$app->session->setFlash("danger", "Image wasn't saved!");
                    $image->delete();
                    if (isset($image->image)) {
                        unlink(Url::to("@app" . Yii::getAlias($image->image)));
                    }
                    $imagesCount = Yii::$app->db->createCommand("SELECT COUNT(*) FROM image WHERE category = '$image->category'")->queryOne();
                    $imageCategory->count = $imagesCount['COUNT(*)'];
                    $imageCategory->save();
                }
                $this->id = $image->id;
                return $image;
            }
        } else {
            return false;
        }
    }

    private function processingImage($image) {
        if ($this->watermark !== "none") {
            $imgFile = $this->imageFile->tempName;

            $originalStamp = imagecreatefrompng(Url::to("@app/web/images/stamp.png"));
            imageSaveAlpha($originalStamp, true);

            $imgInfo = getimagesize($imgFile);
            $imgSx = $imgInfo[0];
            $imgSy = $imgInfo[1];
            $type = $imgInfo[2];

            switch ($type) {
                case 1:
                    $img = imagecreatefromgif($imgFile);
                    imageSaveAlpha($img, true);
                    break;
                case 2:
                    $img = imagecreatefromjpeg($imgFile);
                    break;
                case 3:
                    $img = imagecreatefrompng($imgFile);
                    imageSaveAlpha($img, true);
                    break;
            }

            $stampSx = $imgSy / 7 * 2;
            $stampSy = $imgSy / 7;
            $tmp = imagecreatetruecolor($stampSx, $stampSy);
            imagealphablending($tmp, true);
            imageSaveAlpha($tmp, true);
            $transparent = imagecolorallocatealpha($tmp, 0, 0, 0, 127);
            imagefill($tmp, 0, 0, $transparent);
            imagecolortransparent($tmp, $transparent);

            imagecopyresampled($tmp, $originalStamp, 0, 0, 0, 0, $stampSx, $stampSy, imagesx($originalStamp), imagesy($originalStamp));
            $stamp = $tmp;

            switch ($this->watermark) {
                case "lt":
                    imagecopy($img, $stamp, 0, 0, 0, 0, $stampSx, $stampSy);
                    break;
                case "rt":
                    imagecopy($img, $stamp, $imgSx - $stampSx, 0, 0, 0, $stampSx, $stampSy);
                    break;
                case "lb":
                    imagecopy($img, $stamp, 0, $imgSy - $stampSy, 0, 0, $stampSx, $stampSy);
                    break;
                case "rb":
                    imagecopy($img, $stamp, $imgSx - $stampSx, $imgSy - $stampSy, 0, 0, $stampSx, $stampSy);
                    break;
            }

            switch ($type) {
                case 1:
                    imagegif($img, Url::to('@app/web/images/photogallery/' . $image->id . '.' . $image->extension));
                    break;
                case 2:
                    imagejpeg($img, Url::to('@app/web/images/photogallery/' . $image->id . '.' . $image->extension));
                    break;
                case 3:
                    imagepng($img, Url::to('@app/web/images/photogallery/' . $image->id . '.' . $image->extension));
                    break;
            }
            imagedestroy($img);
            imagedestroy($tmp);
            imagedestroy($stamp);
        } else {
            $this->imageFile->saveAs('@app/web/images/photogallery/' . $image->id . '.' . $image->extension);
        }
    }

}
