<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>

<img src="images/logo-85.png">

<div id="login-container ">

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>

    <?= $form->field($model, 'username',[
        'inputOptions' => [
            'placeholder' => $model->getAttributeLabel(yii::t('app', 'Username')),
        ],
    ])->textInput()->label(false) ?>

    <?= $form->field($model, 'password', [
        'inputOptions' => [
            'placeholder' => $model->getAttributeLabel(yii::t('app', 'Password')),
        ],
    ])->passwordInput()->label(false) ?>

    <select name="LoginForm[year]" id="year-select">
        <?php
        $anoAtual = date('Y');

        for ($ano = $anoAtual; $ano >= 2014; $ano--) {
            echo "<option value='$ano'>$ano</option>";
        }
        ?>
    </select>

    <?= $form->field($model, 'rememberMe', [
        'template' => "<div class=\"col-lg-offset-1 col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
    ])->checkbox() ?>

    <div class="form-group">
        <div class="col-lg-11">
            <?= Html::submitButton(Yii::t('app', 'Login'), ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>
