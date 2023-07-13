<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\student;

/**
 * StudentSearch represents the model behind the search form about `app\models\student`.
 */
class studentSearch extends student
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'address'], 'integer'],
            [['fid', 'name', 'birthday', 'gender', 'responsible_1_name'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Yii\base\Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = student::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'address' => $this->address,
            'birthday' => $this->birthday,
        ]);

        $query->andFilterWhere(['like', 'fid', $this->fid])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'gender', $this->gender])
            ->andFilterWhere(['like', 'responsible_1_name', $this->responsible_1_name]);

        return $dataProvider;
    }
}
