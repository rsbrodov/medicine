<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;


class UserSearch extends User
{

    public function rules()
    {
        return [
            //[['id', 'status'], 'integer'],
            [['username'], 'safe'],
        ];
    }


    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }


    public function search($params)
    {
        if(Yii::$app->user->can('admin'))
        {

                $query = User::find();

        }

        if(Yii::$app->user->can('head_doctor'))
        {

                $query = User::find();

        }


        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'forcePageParam' => false,
                'pageSizeParam' => false,
                'pageSize' => 20
            ],
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                    //'title' => SORT_ASC,
                ]
            ],
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            /*->andFilterWhere(['=', 'id', $this->role])*/;
           // ->andFilterWhere(['like', 'recipes_collection_id', $this->recipes_collection_id])
           // ->andFilterWhere(['like', 'techmup_number', $this->techmup_number]);


        return $dataProvider;
    }
}
