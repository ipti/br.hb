<?php

namespace app\components;

use yii\base\Widget;
use yii\helpers\Html;



class TermPdfWidget extends Widget{

    public $data;

    public function run(){
        return $this->render('termPdf',['data' => $this->data]);
    }
}

?>