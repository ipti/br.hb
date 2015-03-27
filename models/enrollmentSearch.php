<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\enrollment;

/**
 * enrollmentSearch represents the model behind the search form about `app\models\enrollment`.
 */
class enrollmentSearch extends enrollment
{
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['student', 'classroom'], 'safe']
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $actualController = Yii::$app->controller->className();
       
        $c = $params['c'];
        /* @var $campaign \app\models\campaign */
        $campaign = \app\models\campaign::find()->where("id = :c",["c"=>$c])->one();
    
        $query = $campaign->getEnrollments();
        
        $query->select("enrollment.*");
        
        if($actualController == \app\controllers\ConsultationController::className()){
            $query->innerJoin('term as t', 't.enrollment = enrollment.id and t.agreed = true');
            $query->innerJoin('consultation as co', 'co.term = t.id');
            $query->where("campaign = :cid", ["cid" => $c]);
        }
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        $sName ="";
        $cName ="";
        
        if(isset($params["enrollmentSearch"])){
            $sName = $params["enrollmentSearch"]['student'];
            $cName = $params["enrollmentSearch"]['classroom'];
            $params["enrollmentSearch"]['student'] = "";
            $params["enrollmentSearch"]['classroom'] = "";
        }
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }
        
        $query->innerJoin('student as s', 's.id = enrollment.student');
        $query->innerJoin('classroom as c', 'c.id = enrollment.classroom');

        $query->andFilterWhere(['id' => $this->id]);
        $query->andFilterWhere(['like', 's.name', $sName])
              ->andFilterWhere(['like', 'c.name', $cName]);
        
        return $dataProvider;
    }
}
