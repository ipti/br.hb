<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\icons\Icon;

echo $html;

?>

<div class="pull-right hidden-print">
    <?=Html::button(Icon::show('print',[], Icon::FA).Yii::t('app', 'Print'), ['id'=>'print-button', 'class'=>'btn btn-primary fixed-btn', 'onclick'=>'window.print()'])?>
</div>