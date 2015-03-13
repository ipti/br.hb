<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

use yii\widgets\ActiveForm;
use yii\data\ActiveDataProvider;

use kartik\grid\GridView;
use kartik\grid\CheckboxColumn;

use app\models\school;

use kartik\widgets\DepDrop;
use kartik\select2\Select2;


/* @var $this yii\web\View */
/* @var $model app\models\Campaign */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="campaign-form form">

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3><?= $model->isNewRecord ? Yii::t('app', 'Create Campaign') : Yii::t('app', 'Update Campaign') ?></h3>
    <?= $model->isNewRecord ? '' : $model->name ?>
</div>

<?php $form = ActiveForm::begin([
     'id' => $model->formName(),
 ]); ?>
<div class="modal-form">


    
    
    <?php
    //beforeSubmit
    $js = "
        $('form#".$model->formName()."').on('beforeSubmit', function(e){
            var \$form = $(this);
            submitCampaignForm(\$form);
        }).on('submit', function(e){
            e.preventDefault();
        });";
    $this->registerJs($js);
    ?>

    <?= Html::activeHiddenInput($model, 'coordinator') ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => 20]) ?>
    <?= $form->field($model, 'begin')->input("date") ?>
    <?= $form->field($model, 'end')->input("date") ?>
    <?php
        if($model->isNewRecord){
            $data = ArrayHelper::map(school::find()->all(), 'id', 'name');
            echo Html::label(yii::t('app','Schools'));
            echo Select2::widget([
                'name' => 'schools', 
                'id'=>'campaign_schools',
                'data' => $data,
                'options' => [
                    'placeholder' => yii::t('app', 'Select Schools...'),
                    //'multiple' => true,
                    'class' => 'form-select2',
                ],
                'pluginOptions'=>['allowClear'=>true]
            ]);

            $js = "
                $('#campaign_classrooms').on('change', function(e){
                    var val = $('#campaign_classrooms option:selected');
                    if(val.attr('value') === '')
                       val.remove();
                });";
            $this->registerJs($js);
            
            echo Html::label(yii::t('app','Classrooms'));
            echo DepDrop::widget([
                'name'=>'classrooms',
                'id'=>'campaign_classrooms',
                'data'=> [],
                'options' => [
                    'placeholder' => yii::t('app', 'Select Classrooms...'),
                    'multiple'=>true,
                    'class' => 'form-select2',
                    ],
                'type' => DepDrop::TYPE_SELECT2,
                'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
                'pluginOptions'=>[
                    'depends'=>['campaign_schools'],
                    'url' => Url::to(['/campaign/get-classrooms-list']),
                    'loadingText' => yii::t('app', 'Loading Classrooms ...'),
                ]
            ]);
        }
    ?>
    
    <br>
    <div class="form-group">
        <?= Html::button(Yii::t('app', 'Cancel'), ['data-dismiss'=>"modal", 'class' => 'btn btn-danger pull-left'])
            .Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success pull-right' : 'btn btn-primary pull-right']) ?>
    </div>
    <br>
    <?php ActiveForm::end(); ?>

</div>
