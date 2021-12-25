<?php

namespace app\modules\photogallery\models\admin;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\photogallery\models\Image;

/**
 * ImageSearch represents the model behind the search form of `app\modules\photogallery\models\Image`.
 */
class ImageSearch extends Image {

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id'], 'integer'],
            [['author', 'category', 'title', 'date', 'status', 'extension', 'image'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios() {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params, $slug) {
        $query = Image::find()->where(["category" => $slug]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'author', $this->author])
                ->andFilterWhere(['like', 'category', $this->category])
                ->andFilterWhere(['like', 'title', $this->title])
                ->andFilterWhere(['like', 'date', $this->date])
                ->andFilterWhere(['like', 'status', $this->status])
                ->andFilterWhere(['like', 'extension', $this->extension])
                ->andFilterWhere(['like', 'image', $this->image]);

        return $dataProvider;
    }

}
