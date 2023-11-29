<?php

namespace app\components;

use yii\base\Widget;
use yii\helpers\Html;

class AnamneseJustPdfWidget extends Widget
{

    public $data;

    public function run()
    {
        return $this->render('anamneseJustPdf', ['data' => $this->data]);
    }
}
