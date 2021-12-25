<?php

namespace app\modules\photogallery\models;

use Yii;

/**
 * This is the model class for table "image".
 *
 * @property int $id
 * @property string|null $author
 * @property string $category
 * @property string $title
 * @property string $date
 * @property string $status
 * @property string $extension
 * @property string $image
 */
class Image extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'image';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['category', 'title', 'status', 'date'], 'required'],
            [['author', 'category', 'title', 'date', 'extension', 'image'], 'string', 'max' => 50],
            ['image', 'unique'],
            ['status', 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'author' => 'Author',
            'category' => 'Category',
            'title' => 'Title',
            'date' => 'Date',
            'status' => 'Status',
            'extension' => 'Extension',
            'image' => 'Image',
        ];
    }

}
