<?php
namespace app\components;

use yii\base\Widget;
use yii\helpers\Html;

class AnamneseWidget extends Widget{

    public $data;

    public function run(){
        return $this->render('anamnese',['data' => $this->data]);
    }
}
?>