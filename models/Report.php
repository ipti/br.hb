<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\enrollment;
use app\models\term;
use app\models\campaing;

class Report extends Model{

    public $cid;
    public $eid;



    public function getAnamnese(){
        $enrollment = $this->eid != null ? enrollment::find()->where("id = :eid", [ 'eid' => $this->eid])->one() : null;
        $student = $enrollment != null ? $enrollment->students : null;
        $term = $this->eid != null ? term::find()->where("enrollment = :eid and campaign = :cid", ['eid' => $this->eid, 'cid' => $this->cid])->one() : null;
        $hb1 = $term != null ? $term->getHemoglobins()->where("sample = 1")->one() : null;
        $anatomy = $student != null ? $student->getAnatomies()->orderBy("date desc")->one() : null;
        
        $data = [];

        $data['name'] = $student != null ? $student->name : "";
        $data['birthday'] = $student != null ? date("d/m/Y", strtotime($student->birthday)) : "";
        $b = $student != null ? $student->birthday : "";
        $today = $student != null ? new \DateTime(date("Y-m-d")) : "";
        $data['age'] = $student != null ? $today->diff(new \DateTime($b))->format("%y") . " " . \yii::t('app', 'years old') : "";
        $data['sex'] = $student != null ? \yii::t('app', $student->gender) : "";
        $data['weight'] = $anatomy != null ? $anatomy->weight . "kg" : "";
        $data['height'] = $anatomy != null ? $anatomy->height . "m" : "";
        $data['imc'] = $anatomy != null ? number_format($data['weight'] / ($data['height'] * $data['height']), 2) : "";
        $data['rate1'] = $hb1 != null ? $hb1->rate . "g/dL" : "";

        return $data;
    }

}

?>