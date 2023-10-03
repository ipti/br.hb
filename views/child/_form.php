<?php
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use app\models\classroom;
use app\models\school;
use app\models\campaign;
/* @var $this yii\web\View */
/* @var $model app\models\Student */
/* @var $form yii\bootstrap4\ActiveForm */

$this->assetBundles['Child'] = new app\assets\AppAsset();
$this->assetBundles['Child']->js = [
    'scripts/StudentView/Functions.js'
];
?>

<div class="student-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= Form::widget([
        'model' => $model,
        'form' => $form,
        'attributes' => [
            'header_student' => [
                'type' => 'raw',
                'value' => '<hr><h4>Dados do Aluno</h4><br>'
            ],
            'name' => [
                'type' => Form::INPUT_TEXT,
                'options' => ['maxlength' => true, 'placeholder' => 'Digite o nome do aluno']
            ],
            'gender' => [
                'type' => Form::INPUT_DROPDOWN_LIST,
                'items' => ['male' => 'Masculino', 'female' => 'Feminino'],
                'options' => ['prompt' => 'Selecione o sexo']
            ],
            'birthday' => [
                'type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\date\DatePicker::class,
                'options'=>[
                    'pluginOptions' => ['format' => 'yyyy-mm-dd'],
                ],
            ],
            'allergy' => [
                'type' => Form::INPUT_CHECKBOX,
                'options' => ['value' => '1'],
            ],
            'allergy_text' => [ 
                'type' => Form::INPUT_TEXT,
                'options' => ['maxlength' => true, 'placeholder' => 'Descreva a(s) alergia(s) do aluno'],
                'fieldConfig' => ['options' => ['style' => 'display:none;']]
            ],
            'anemia' => [
                'type' => Form::INPUT_CHECKBOX,
                'options' => ['value' => '1'],
            ],
            'anemia_text' => [
                'type' => Form::INPUT_TEXT,
                'options' => ['maxlength' => true, 'placeholder' => 'Descreva a(s) anemia(s) do aluno'],
                'fieldConfig' => ['options' => ['style' => 'display:none;']]
            ],
            'header_responsible_1' => [
                'type' => 'raw',
                'value' => '<hr><h4>Dados do Responsável 1</h4><br>'
            ],
            'responsible_1_name' => [
                'type' => Form::INPUT_TEXT,
                'options' => ['maxlength' => true, 'placeholder' => 'Digite o nome do responsável 1']
            ],
            'responsible_1_telephone' => [
                'type' => Form::INPUT_TEXT,
                'options' => ['maxlength' => true, 'placeholder' => '(__) _____-____']
            ],
            'responsible_1_kinship' => [
                'type' => Form::INPUT_DROPDOWN_LIST,
                'items' => [1 => 'Mãe', 2 => 'Pai', 3 => 'Irmão/Irmã', 4 => 'Outro'],
                'options' => ['prompt' => 'Selecione o grau de parentesco']
            ],
            'responsible_1_email' => [
                'type' => Form::INPUT_TEXT,
                'options' => ['maxlength' => true, 'placeholder' => 'Digite o email do responsável 1']
            ],
            'header_responsible_2' => [
                'type' => 'raw',
                'value' => '<hr><h4>Dados do Responsável 2</h4><br>'
            ],
            'responsible_2_name' => [
                'type' => Form::INPUT_TEXT,
                'options' => ['maxlength' => true, 'placeholder' => 'Digite o nome do responsável 2']
            ],
            'responsible_2_telephone' => [
                'type' => Form::INPUT_TEXT,
                'options' => ['maxlength' => true, 'placeholder' => '(__) _____-____']
            ],
            'responsible_2_kinship' => [
                'type' => Form::INPUT_DROPDOWN_LIST,
                'items' => [1 => 'Mãe', 2 => 'Pai', 3 => 'Irmão/Irmã', 4 => 'Outro'],
                'options' => ['prompt' => 'Selecione o grau de parentesco']
            ],
            'responsible_2_email' => [
                'type' => Form::INPUT_TEXT,
                'options' => ['maxlength' => true, 'placeholder' => 'Digite o email do responsável 2']
            ],
        ],
    ]); ?>

    <hr><h4>Matrícula</h4><br>
    <div class="show-enrollment" style="<?php echo $modelEnrollment->classroom ? '' : 'display:none;'?>">
        <?php
        if($modelEnrollment->classroom) {
            $classroom = classroom::findOne($modelEnrollment->classroom);
            $school = school::findOne($classroom->school);
        
        ?>
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <p>Escola: <?= $school->name?></p>
                    <p>Turma: <?= $classroom->name?></p>
                    <!-- <p><button type="button" class="btn btn-danger" id="delete-enrollment" data="<?= $modelEnrollment->id ?>"><i class="fa fa-remove" style="margin-right:10px;"></i>Excluir Matrícula</button></p> -->
                </div>
            </div>
        </div>
        <?php }?>

        <?php if($modelTerm->campaign) {
            $campaign = campaign::findOne($modelTerm->campaign);
        ?>
        <div class="row show-campaign">
            <hr><h4>Campanha Vinculada</h4><br>
            <div class="col-sm-12">
                <div class="form-group">
                    <p>Campanha: <?= $campaign->name?></p>
                    <p><button type="button" class="btn btn-danger" id="delete-campaign" data="<?= $modelTerm->id ?>"><i class="fa fa-remove" style="margin-right:10px;"></i>Desvincular Campanha</button></p>
                </div>
            </div>
        </div>
        <?php }?>
    </div>
    <div class="new-enrollment-container" style="<?php echo $modelEnrollment->classroom ? 'display:none;' : ''?>">
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <label class="form-label">Escola</label>
                    <select class="form-control" name="school_enrollment" id="school_enrollment">
                        <option value="">Selecione uma escola</option>
                        <?php foreach($schools as $school) {?>
                            <option value="<?= $school->id ?>"><?= $school->name ?></option>
                        <?php }?>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group classroom_select_container" style="display:none;">
                    <label class="form-label">Turma</label>
                    <select class="form-control" name="classroom_enrollment" id="classroom_enrollment"></select>
                </div>
            </div>
        </div>
        <?php if($model->isNewRecord) {?>
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group campaign_select_container" style="display:none;">
                    <label class="form-label">Campanha</label>
                    <select class="form-control" name="campaign" id="campaign">
                        <option value="">Selecione a campanha</option>
                        <?php foreach($campaigns as $c) {?>
                            <option value="<?= $c->id ?>"><?= $c->name ?></option>
                        <?php }?>
                    </select>
                </div>
            </div>
        </div>
        <?php }?>
    </div>
    <div class="new-term-container" style="<?php echo $modelTerm->campaign ? 'display:none;' : ''?>">
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group campaign_select_container">
                <hr><h4>Vincular Campanha</h4><br>
                    <label for="campaign" class="form-label">Campanha</label>
                    <select name="campaign" id="campaign" class="form-control">
                        <option value="">Selecione uma campanha</option>
                        <?php foreach ($campaigns as $c) {?>
                            <option value="<?= $c->id ?>"><?= $c->name ?></option>
                        <?php }?>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <hr><h4>Endereço</h4><br>
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
                <label class="form-label">Rua</label>
                <input class="form-control" type="text" name="street" id="street" value="<?= $modelAddress->street ?>">
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label class="form-label">Número</label>
                <input class="form-control" type="text" name="number" id="number" value="<?= $modelAddress->number ?>">
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label class="form-label">Complemento</label>
                <input class="form-control" type="text" name="complement" id="complement" value="<?= $modelAddress->complement ?>">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
                <label class="form-label">Bairro</label>
                <input class="form-control" type="text" name="neighborhood" id="neighborhood" value="<?= $modelAddress->neighborhood ?>">
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label class="form-label">Cidade</label>
                <select class="form-control" name="city" id="city" readonly>
                    <option value="2806305" selected>Santa Luzia do Itanhy</option>
                </select>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label class="form-label">Estado</label>
                <select class="form-control" name="state" id="state" readonly>
                    <option value="28">Sergipe</option>
                </select>
            </div>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Criar' : 'Salvar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<style>
    .modal-content {
        padding: 30px;
    }
</style>

<script>
    $(document).on("click", "#delete-enrollment", function () {
    $(".show-enrollment").hide();
    $(".new-enrollment-container").show();
    let {origin,pathname} = window.location;
    $.ajax({
        type: "POST",
        url: `${origin}${pathname}?r=child%2Fdelete-enrollment`,
        data: {
            enrollment: $(this).attr('data')
        },
        success: function (response) {
            console.log(response);
        }
    });
}); 

$(document).on("click", "#delete-campaign", function () {
    $(".show-campaign").hide();
    $(".new-term-container").show();
    let {origin,pathname} = window.location;
    $.ajax({
        type: "POST",
        url: `${origin}${pathname}?r=child%2Fremove-campaign-of-term`,
        data: {
            term: $(this).attr('data')
        },
        success: function (response) {
            console.log(response);
        }
    });
});
</script>