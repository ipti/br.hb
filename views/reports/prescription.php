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
use app\components\PrescriptionWidget;

$this->title = yii::t('app', 'Prescription');
?>

<?php  echo PrescriptionWidget::widget(['student' => $student, 'sulfato'=> $sulfato, 'vermifugo' => $vermifugo]); ?>

    <div class="pull-right hidden-print">
    <?=Html::button(Icon::show('print',[], Icon::FA).Yii::t('app', 'Print'), [ 'id' =>'print-button', 'class'=>'btn btn-primary', 'onclick'=>'window.print()'])?>
    </div>
