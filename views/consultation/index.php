<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use \kartik\icons\Icon;
use \yii\helpers\Url;

use kartik\builder\Form;
use kartik\widgets\DepDrop;
use kartik\select2\Select2;
use kartik\widgets\DatePicker;
use kartik\widgets\TimePicker;


/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var searchModel app\models\enrollmentSearch */
/* @var campaign integer */


$this->assetBundles['Consultation'] = new app\assets\AppAsset();
$this->assetBundles['Consultation']->js = [
    'scripts/ConsultationView/Functions.js',
    'scripts/ConsultationView/Click.js'
];

$this->title = Yii::t('app', 'Consultations');
$this->params['breadcrumbs'][] = $this->title;
$this->params['button'] =
        Html::a(Yii::t('app', 'Create Consultation'), ['create', 'cid' => $campaign], ['class' => 'btn btn-success navbar-btn']);
$this->params['campaign'] = $campaign;
?>

<div style="display: flex;float: right;">
    <?php echo Html::a(Icon::show('file-pdf-o', [], Icon::FA).yii::t('app',"Prescription"),Url::toRoute(['reports/just-prescription', 'cid' => $campaign, 'isConsutationLetters'=> false]),
    ['target'=>"_blank", 'class' => 'btn btn-primary pull-right']) ?>
    <?php echo Html::a(Icon::show('file-pdf-o', [], Icon::FA).yii::t('app',"Anamnese"),Url::toRoute(['reports/just-anamnese', 'cid' => $campaign, 'isConsutationLetters'=> false]),
    ['target'=>"_blank", 'class' => 'btn btn-primary pull-right ml-10']) ?>
</div>

<div class="consultation-index">

    <?=Html::a(Icon::show('file-pdf-o', [], Icon::FA).yii::t('app','All Prescriptions...'),['reports/multiple-prescriptions', 'cid'=>$campaign],
         ['target'=>'_blank', 'class' => 'btn btn-primary pull-right', 'style' => 'display:none']) ?>
    <br>
    <br>
    <?=Html::a(Icon::show('file-pdf-o', [], Icon::FA).yii::t('app','All Letters/Anamnese...'),'#',
         ['id'=>'selectLetterOptions', 'class' => 'btn btn-primary pull-right', 'style' => 'display:none']) ?>
    <br>
    <br>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions' => function ($model, $key, $index, $column){
                    $c = $this->params['campaign'];
                    $consult =$model->getTerms()->where("campaign = :cid",["cid"=>$c])->one()->getConsults()->one();
                    return ['consultation-key'=> $consult == null ? "" : $consult->id];
                },
        'columns' => [
            ['class'=> kartik\grid\DataColumn::class,
                'attribute'=>'student',
                'header'=> Yii::t('app', 'Student'),
                'content' => function ($model, $key, $index, $column){
                    return $model->getStudents()->one()->name;
                }
            ],
            ['class'=> kartik\grid\DataColumn::class,
                'attribute'=>'classroom',
                'options' => ['style' => 'width:20%'],
                'header'=> Yii::t('app', 'Classroom'),
                'content' => function ($model, $key, $index, $column){
                    return $model->getClassrooms()->one()->name;
                }
            ],
                    
            ['class' => \kartik\grid\BooleanColumn::class,
                'contentOptions' => ['class' => 'attendedClick cursor-pointer'],
                'header'=> Yii::t('app', 'Attended'),
                'value' => function ($model, $key, $index, $column){
                /* @var $model \app\models\enrollment */
                    $c = $this->params['campaign'];
                    $consult = $model->getTerms()->where("campaign = :cid",["cid"=>$c])->one()->getConsults()->one();
                    return $consult == null ? "" : $consult->attended;
                },
                'vAlign' => 'middle',
            ],
            ['class' => \kartik\grid\BooleanColumn::class,
                'contentOptions' => ['class' => 'deliveredClick cursor-pointer'],
                'header'=> Yii::t('app', 'Delivered'),
                'value' => function ($model, $key, $index, $column){
                /* @var $model \app\models\enrollment */
                    $c = $this->params['campaign'];
                    $consult = $model->getTerms()->where("campaign = :cid",["cid"=>$c])->one()->getConsults()->one();
                    return $consult == null ? "" : $consult->delivered;
                },  
                'vAlign' => 'middle',
            ],
            [
                'class' => kartik\grid\DataColumn::class,
                'label' => yii::t('app', 'Print'),
                'options' => ['style' => 'width:10%'],
                'content' => function($model, $key, $index, $column) {
                    /* @var $model \app\models\enrollment */
                    $cid = $this->params['campaign'];
                    $hemoglobin = $model->getTerms()->where("campaign = :cid",["cid"=>$cid])->one()->getHemoglobins()->where("sample = 1")->one();
                    if($hemoglobin != null){

                        $sid = $hemoglobin->agreedTerm->enrollments->student;
                        $eid = $hemoglobin->agreedTerm->enrollment;
                        $link = $hemoglobin->isAnemic() 
                        ? Html::a(Icon::show('file-text-o', [], Icon::FA).yii::t("app","Prescription"),Url::toRoute(['reports/prescription', 'cid'=>$cid, 'eid' => $model->id]))
                        ."<br>".Html::a(Icon::show('envelope-o', [], Icon::FA).yii::t('app', 'Letter'), Url::toRoute(['reports/consultation-letter', 'sid' => $sid, 'eid' => $eid, 'cid'=> $cid]))
                        ."<br>".Html::a(Icon::show('file-text-o', [], Icon::FA).yii::t('app', 'Anamnese'),Url::toRoute(['reports/anamnese','cid'=>$cid, 'eid' => $eid]))
                        : "----------";
                        return $link;
                    }
                    return "";
                }
            ],
            [
                'class' => kartik\grid\DataColumn::class,
                'label' => yii::t('app', 'Delete'),
                'options' => ['style' => 'width:10%'],
                'content' => function($model, $key, $index, $column) {
                    $cid = $this->params['campaign'];
                    $consult = $model->getTerms()->where("campaign = :cid", ["cid" => $cid])->one()->getConsults()->one();

                    $deleteUrl = Url::toRoute(['consultation/delete', 'id' => $consult->id]);

                    $deleteButton = Html::a(
                        Icon::show('trash-o', [], Icon::FA),
                        $deleteUrl,
                        [
                            'class' => 'delete-consult',
                            'data' => [
                                'method' => 'post',
                                'confirm' => 'Você tem certeza que deseja excluir este item?',
                                'ajax' => '1'
                            ],
                        ]
                    );

                    return "<br>" . $deleteButton;
                }
            ],
        ],
        'pjax' => true,
        'pjaxSettings' => [
            'neverTimeout' => true,
            'options' => [
                'id' => 'pjaxConsults'
            ],
        ],
    ]); ?>
</div>

<?php
    Modal::begin([
        'size'=>Modal::SIZE_SMALL,
        'id'=>'selectLetterOptionsModal',
        'closeButton'=>false
    ]);
    echo "<div class='modal-container'><p>";
    //echo Html::label(yii::t('app','School'));
    echo Html::beginForm(['reports/letter-and-anamnese', 'cid'=>$campaign],'POST',['id'=>'form-consultation-letter', 'class'=>'form-vertical']);
    echo Form::widget([
        'formName' => 'consultation-letter-form',
        'columns'=>1,            
        'attributes' => [
            'consult-date' => [
                'label'=>yii::t('app', 'Consult Date'), 
                'type' => Form::INPUT_WIDGET,
                'widgetClass' => DatePicker::class,
                'options'=>[
                    'pluginOptions' => ['format' => 'dd/mm/yyyy'],
                ],
            ],
            'consult-time' => [
                'label' => yii::t('app', 'Consult Time'),
                'type' => Form::INPUT_WIDGET,
                'widgetClass' => TimePicker::class,
                'options'=>[
                    'pluginOptions' =>[
                        'defaultTime' => 'false'
                    ]
                ]
            ],
            'consult-location' => [
                'label'=>yii::t('app', 'Consult Location'), 
                'type' => Form::INPUT_TEXT,
            ],
            'actions'=>[
                'type'=>Form::INPUT_RAW, 
                'value'=>'<div>' . 
                    Html::button(Yii::t('app', 'Cancel'), ['data-dismiss'=>'modal', 'class'=>'btn btn-danger pull-left btn-actions']) . ' ' .
                    Html::button(Yii::t('app','Generate'), ['id'=>'submit-consultation-letter', 'type'=>'button', 'class'=>'btn btn-success pull-right btn-actions']) . 
                '</div>',
            ],
        ]
    ]); 
    echo Html::endForm();
    echo "</p>";
    echo "</div>";
    Modal::end();
?>


<?php
    Modal::begin([
        'size' => Modal::SIZE_SMALL,
        'id' => 'updateAttendedModal',
        'closeButton'=>false,
    ]);
    echo "<div class='modal-container'><p>";
    echo Yii::t("app","Are you sure you want to update?");
    echo "</p>";
    echo "<br>";
    echo "<div>";
    echo Html::button(Yii::t('app', 'Cancel'), ['data-dismiss'=>"modal", 'class' => 'btn btn-danger pull-left'])
        .Html::button(Yii::t('app', 'Confirm'), ['id'=>'updateAttendedModal-confirm', 'class' => 'btn btn-success pull-right']);
    echo "</div>";
    echo "<br>";
    echo "<br></div>";
    Modal::end();
    
    Modal::begin([
        'size' => Modal::SIZE_SMALL,
        'id' => 'updateDeliveredModal',
        'closeButton'=>false,
    ]);
    echo "<div class='modal-container'><p>";
    echo Yii::t("app","Are you sure you want to update?");
    echo "</p>";
    echo "<br>";
    echo "<div>";
    echo Html::button(Yii::t('app', 'Cancel'), ['data-dismiss'=>"modal", 'class' => 'btn btn-danger pull-left'])
        .Html::button(Yii::t('app', 'Confirm'), ['id'=>'updateDeliveredModal-confirm', 'class' => 'btn btn-success pull-right']);
    echo "</div>";
    echo "<br>";
    echo "<br></div>";
    Modal::end();
?>