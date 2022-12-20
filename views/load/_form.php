<?php
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */


$form = ActiveForm::begin([
    'id' => 'load-form',
    'options' => ['type' => ActiveForm::TYPE_VERTICAL],
]);

/* @var $this yii\web\View */

$this->title = Yii::t('app', 'Import TAG data');
$this->params['breadcrumbs'][] = $this->title;

$this->assetBundles['Load'] = new app\assets\AppAsset();
$this->assetBundles['Load']->js = [
    'scripts/LoadView/Click.js'
];
?>
<div class="row justify-content-md-center">
    <div class="form-group">
        <?php
        echo Select2::widget([
            'name' => 'school',
            'id' => 'schools',
            'data' => $schools,
            'options' => [
                'placeholder' => yii::t('app', 'Select School...'),
                'class' => 'form-select2'
            ],
            'pluginOptions' => ['allowClear' => true]
        ]);
        echo Select2::widget([
            'name' => 'year',
            'id' => 'years',
            'data' => $years,
            'options' => [
                'placeholder' => yii::t('app', 'Select Year...'),
                'class' => 'form-select2'
            ],
            'pluginOptions' => ['allowClear' => true]
        ]);
        echo "<table id='classrooms' class='kv-grid-table table table-bordered table-striped'>"
        . "<thead>"
        . "<tr>"
        . "<th>" . yii::t("app", "Classroom") . "</th>"
        . "<th>" . yii::t("app", "Ano") . "</th>"
        . "<th>" . yii::t("app", "Importar") . "</th>"
        . "<tr>"
        . "</thead>"
        . "<tbody></tbody>"
        . "</table>";
        echo "<button id='send' type='button' class='btn btn-primary' style='display:none'>Importar</button>"
        ?>
    </div>
</div>
<?php ActiveForm::end() ?>