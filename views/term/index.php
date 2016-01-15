<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use kartik\icons\Icon;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $campaign integer */

$this->assetBundles['Term'] = new app\assets\AppAsset();
$this->assetBundles['Term']->js = [
    'scripts/TermView/Functions.js',
    'scripts/TermView/Click.js'
];
$this->title = Yii::t('app', 'Terms');
$this->params['breadcrumbs'][] = $this->title;
$this->params['button'] = Html::button(Icon::show('plus',[], Icon::BSG).
                    		yii::t('app', 'New Term'), 
                    			['value' => Url::to(['term/create','c'=>$campaign]),
                       			 	'id'=>'newTerm',
                        			'class'=>'btn btn-success navbar-btn',
                        			'for'=>'#'
                    ]);
$this->params['campaign'] = $campaign;
?>

<div class="term-index">
    <?=Html::a(Icon::show('file-pdf-o', [], Icon::FA).yii::t('app','All Terms'),Url::toRoute(['reports/build-terms', 'cid' => $campaign]),
         ['target'=>"_blank", 'class' => 'btn btn-primary pull-right']) ?>
    <br>
    <br>
    <?=Html::a(Icon::show('file-pdf-o', [], Icon::FA).yii::t('app','All Terms - Weight and Height'),Url::toRoute(['reports/weight-height', 'cid' => $campaign]),
        ['target'=>"_blank", 'class' => 'btn btn-primary pull-right']) ?>
    <br>
    <br>
    <?=Html::a(Icon::show('file-pdf-o', [], Icon::FA).yii::t('app','Agreed Terms...'),'#',
         ['id'=>'selectSchoolButton', 'class' => 'btn btn-primary pull-right']) ?>
    
    <br>
    <br>
    <?=
    GridView::widget([
        'id' => 'termsGridView',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions' => function ($model, $key, $index, $column){
                    $c = $this->params['campaign'];
                    return ['term-key'=>$model->getTerms()->where("campaign = :cid", ["cid"=>$c])->orderBy("id desc")->one()->id];
                },
        'columns' => [
            ['class'=> kartik\grid\DataColumn::className(),
                'attribute'=>'student',
                'header'=> Yii::t('app', 'Student'),
                'content' => function ($model, $key, $index, $column){
                    return $model->getStudents()->one()->name;
                }
            ],
            ['class'=> kartik\grid\DataColumn::className(),
                'attribute'=>'classroom',
                'header'=> Yii::t('app', 'Classroom'),
                'content' => function ($model, $key, $index, $column){
                    return $model->getClassrooms()->one()->name;
                }
            ],
            ['class' => \kartik\grid\BooleanColumn::className(),
                'contentOptions' => ['class' => 'agreedClick cursor-pointer'],
                'header'=> Yii::t('app', 'Agreed'),
                'value' => function ($model, $key, $index, $column){
                    $c = $this->params['campaign'];
                    return $model->getTerms()->where("campaign = :cid", ["cid"=>$c])->orderBy("id desc")->one()->agreed;
                },
                'vAlign' => 'middle',
            ],
        ],
        'pjax' => true,
        'pjaxSettings' => [
            'neverTimeout' => true,
            'options' => [
                'id' => 'pjaxTerm'
            ],
        ],
    ]);
    ?>
</div>

<?php
    Modal::begin([
        'size'=>Modal::SIZE_SMALL,
        'id'=>'selectSchoolModal',
        'closeButton'=>false
    ]);
    $c = app\models\campaign::find()->where('id = :cid',['cid'=>$campaign])->one();
    /*@var $c app\models\campaign*/
    $data = yii\helpers\ArrayHelper::map($c->getSchools()->all(), 'id', 'name');
    echo "<div class='modal-container'><p>";
    //echo Html::label(yii::t('app','School'));
    echo kartik\widgets\Select2::widget([
        'name' => 'schools', 
        'id'=>'schools',
        'data' => $data,
        'options' => [
            'placeholder' => yii::t('app', 'Select School...'),
            'class' => 'form-select2',
            'campaign' => $campaign,
        ],
        'pluginOptions'=>['allowClear'=>true]
    ]);
    echo "</p>";
    echo "<br>";
    echo "<div>";
    echo Html::button(Yii::t('app', 'Cancel'), ['data-dismiss'=>'modal', 'class'=>'btn btn-danger pull-left'])
        .Html::button(Yii::t('app', 'Generate'), ['id'=>'selectSchoolModal-confirm', 'class'=>'btn btn-success pull-right']);
    echo "</div>";
    echo "<br>";
    echo "<br></div>";
    Modal::end();
?>

<?php
    Modal::begin(['closeButton'=>false,
        'id' => 'termModal']);
        echo "<div id='termModalContent'></div>";
    Modal::end();
?>
