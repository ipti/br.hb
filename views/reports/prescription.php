<?php
/* @var $this yii\web\View  */
/* @var $enrollment \app\models\enrollment */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\icons\Icon;

use app\models\campaign;

use kartik\builder\Form;
use kartik\widgets\DepDrop;
use kartik\select2\Select2;

$this->title = yii::t('app', 'Prescription');
?>
<div class="report">
    <div class="report-content">
        <div class="report-head">
            <div class="report-head-image">
                <img src="/images/reporters/prefeitura.png" class="pull-left" width="200">
                <img src="/images/reporters/hb.png" class="pull-right" height="50px;">
                <div class="clear"></div>
            </div>
            <h4 class="report-title">Receituário</h4>
            <h5 ><?=$name?></h5>
            <br>
            <br>
            <br>
        </div>
        <div class="report-body" style="text-align: center">
            <span>
                <?=$sulfato?>
                <br>
                <?=$vermifugo?>                
            </span>
        </div>
    </div>
</div>
    <div class="pull-right hidden-print">
    <?=Html::button(Icon::show('print',[], Icon::FA).Yii::t('app', 'Print'), [ 'id' =>'print-button', 'class'=>'btn btn-primary', 'onclick'=>'window.print()'])?>
    </div>
