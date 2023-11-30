<?php

namespace app\components;

use yii\base\Widget;
use yii\helpers\Html;

class PrescriptionJustPdfWidget extends Widget
{

    public $data;

    public function run()
    {
        return $this->render('prescriptionJustPdf', ['data' => $this->data]);
    }
}
