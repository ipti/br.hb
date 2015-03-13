
<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use app\models\campaign;
use app\models\school;
use kartik\widgets\DepDrop;
use kartik\select2\Select2;

 $this->assetBundles['Reports'] = new app\assets\AppAsset();
 $this->assetBundles['Reports']->js = [
    'scripts/ReportsView/Term.js'
    ];
 
 

$this->title = yii::t('app', 'Termos');
?>

<div class="report">
    <div class="report-head hidden-print">
        <div class="row">
                   
            <div class="campaign-col col-sm-6 col-md-3">
                <?php
                $data = ArrayHelper::map(campaign::find()->all(), 'id', 'name');
                echo Html::label(yii::t('app', 'Campaign'));
                echo Select2::widget([
                    'name' => 'campaign',
                    'id' => 'campaign',
                    'data' => $data,
                    'options' => [
                        'placeholder' => yii::t('app', 'Select Campaign...'),
                    ],
                    'pluginOptions' => ['allowClear' => true]
                ]);
                ?>
            </div>
            
        </div>



