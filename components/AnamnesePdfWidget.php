<?php
namespace app\components;

use yii\base\Widget;
use yii\helpers\Html;

class AnamnesePdfWidget extends Widget{

    public $data;

    public function run(){
        return $this->render('anamnesePdf',['data' => $this->data]);
    }
}
?>