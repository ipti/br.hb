<?php

namespace app\components;

use yii\base\Widget;
use yii\helpers\Html;



class PrescriptionWidget extends Widget{

    public $student;
    public $vermifugo;
    public $sulfato;

    public function run(){
        return $this->render('prescription',['student' => $this->student, 'sulfato' => $this->sulfato, 'vermifugo' => $this->vermifugo]);
    }
}

?>