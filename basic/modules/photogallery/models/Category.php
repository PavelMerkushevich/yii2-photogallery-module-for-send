<?php

namespace app\modules\photogallery\models;

use Yii;
use yii\helpers\Url;


/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string $status
 * @property int|null $count
 */
class Category extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['title', 'slug', 'status'], 'required'],
            ['slug', 'unique'],
            ['count', 'integer'],
            [['title', 'slug'], 'string', 'max' => 50],
            ['status', 'string', 'max' => 10],
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
            'status' => 'Status',
            'count' => 'Count',
        ];
    }

    public function getUrlToCategoryImages() {
        return Url::toRoute(['admin/image/index', 'slug' => $this->slug]);
    }

}
