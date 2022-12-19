<?php
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */


$form = ActiveForm::begin([
    'id' => 'login-form',
    'options' => ['type' => ActiveForm::TYPE_VERTICAL],
]);

/* @var $this yii\web\View */

$this->title = Yii::t('app', 'Booting HB');
$this->params['breadcrumbs'][] = $this->title;

$this->assetBundles['Load'] = new app\assets\AppAsset();
$this->assetBundles['Load']->js = [
    'scripts/LoadView/Click.js'
];
?>
<div class="row justify-content-md-center">
    <div class="form-group">
        <?php
        echo Html::label(yii::t('app', 'Escolas do TAG'));
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
        echo "<table id='classrooms' class='kv-grid-table table table-bordered table-striped'>"
        . "<thead>"
        . "<tr>"
        . "<th>" . yii::t("app", "Classroom") . "</th>"
        . "<th>" . yii::t("app", "Ano") . "</th>"
        . "<th>" . yii::t("app", "Ações") . "</th>"
        . "<tr>"
        . "</thead>"
        . "<tbody></tbody>"
        . "</table>";
        ?>
    </div>
    <?= Html::submitButton('Fazer Download dos Dados', ['class' => 'btn btn-primary']) ?>
</div>
<?php ActiveForm::end() ?>