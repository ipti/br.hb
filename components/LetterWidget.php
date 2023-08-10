<?php

namespace app\components;

use yii\base\Widget;
use yii\helpers\Html;



class LetterWidget extends Widget{

    public $data;

    public function run(){
        return $this->render('letter',['data' => $this->data]);
    }
}

?>