<?php

namespace app\components;

use yii\base\Widget;
use yii\helpers\Html;



class TermWidget extends Widget{

    public $data;

    public function run(){
        return $this->render('term',['data' => $this->data]);
    }
}

?>