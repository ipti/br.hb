,0,<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use kartik\icons\Icon;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel app\models\enrollmentSearch */
/* @var $campaign app\models\campaign */


$this->assetBundles['Anatomy'] = new app\assets\AppAsset();
$this->assetBundles['Anatomy']->js = [
    'scripts/AnatomyView/Functions.js',
    'scripts/AnatomyView/Click.js'
];

$this->title = Yii::t('app', 'Anatomies');
$this->params['breadcrumbs'][] = $this->title;
$this->params['button'] = Html::button(Icon::show('plus',[], Icon::BSG).
                            yii::t('app', 'New Anatomy'), 
                            ['value' => Url::to(['anatomy/create','cid'=>$campaign->id]),
                                'id'=>'newAnatomy',
                                'class'=>'btn btn-success navbar-btn',
                                'for'=>'#'
                            ]);
        
?>

<div class="anatomy-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
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
                'header'=> Yii::t('app', 'Classroom'),
                'content' => function ($model, $key, $index, $column){
                    return $model->getClassrooms()->one()->name;
                }
            ],
            ['class'=> kartik\grid\DataColumn::class,
                'header'=> Yii::t('app', 'Weight'),
                'content' => function ($model, $key, $index, $column){
                    $anatomy = $model->getStudents()->one()->getAnatomies()->orderBy("date desc")->one();
                    if($anatomy != null)
                        return $anatomy->weight . "kg";
                    return null;
                }
            ],
            ['class'=> kartik\grid\DataColumn::class,
                'header'=> Yii::t('app', 'Height'),
                'content' => function ($model, $key, $index, $column){
                    $anatomy = $model->getStudents()->one()->getAnatomies()->orderBy("date desc")->one();
                    if($anatomy != null)
                        return $anatomy->height . "m";
                    return null;
                }
            ],
            ['class'=> kartik\grid\DataColumn::class,
                'header'=> Yii::t('app', 'IMC'),
                'content' => function ($model, $key, $index, $column){
                    $anatomy = $model->getStudents()->one()->getAnatomies()->orderBy("date desc")->one();
                    if($anatomy != null){
                        $dataAtual = new \DateTime();
                        $dataNascimentoObj = new \DateTime($model->getStudents()->one()->birthday);
                        $idade = $dataNascimentoObj->diff($dataAtual)->y;
                        $genero = $model->getStudents()->one()->gender == "male" ? "masculino" : "feminino";
                        
                        if($idade <= 18 && $idade >= 5) {
                            $situation = $anatomy->classificarIMCInfantil($anatomy->IMC(), $idade, $genero);
                        }else {
                            $situation = $anatomy->IMCSituation();
                        }

                        /*
                        Desnutrição Grave    = -1;
                        Desnutrição Moderada        = 0;
                        Normal     = 1;
                        Sobrepeso     = 2;
                        Obesidade = 3;
                         */
                        $classname = '';
                        if($situation == -1 || $situation == 3 || $situation == 4) {
                            $classname = 'danger';
                        }else if ($situation == 1) {
                            $classname = 'info';
                        }else if ($situation == 2 || $situation == 0) {
                            $classname = 'warning';
                        }
                        return $anatomy->IMC() . "kg/m²<br>"
                            . "<span class='text-".$classname."'>" 
                                . yii::t("app", strval($situation))
                            ."</span>";
                        
                    }
                    return null;
                }
            ],
            ['class'=> kartik\grid\DataColumn::class,
                'header'=> Yii::t('app', 'Date'),
                'content' => function ($model, $key, $index, $column){
                    $anatomy = $model->getStudents()->one()->getAnatomies()->orderBy("date desc")->one();
                    if($anatomy != null)
                        return date("d/m/Y", strtotime($anatomy->date));
                    return null;
                }
            ],
            ['class'=> kartik\grid\BooleanColumn::class,
                'header'=> Yii::t('app', 'Updated'),
                'options'=>['mydate'=>$campaign->begin],
                'contentOptions' => [
                    'class' => 'agreedClick cursor-pointer',
                    'link' =>  Url::to(['anatomy/create','cid'=>$campaign->id])
                ],
                'content' => function ($model, $key, $index, $column){
                    $anatomy = $model->getStudents()->one()->getAnatomies()->orderBy("date desc")->one();
                    if($anatomy != null)
                        return $anatomy->date >= $column->options['mydate'] 
                                ? '<span class="glyphicon glyphicon-ok text-success"></span>'
                                : '<span class="icon-info fa fa-info"></span>';
                    return '<span class="icon-error fa fa-remove"></span>';
                }
            ],
        ],
        'pjax' => true,
        'pjaxSettings' => [
            'neverTimeout' => true,
            'options' => [
                'id' => 'pjaxAnatomies'
            ],
        ],
    ]); ?>

</div>

<?php
    Modal::begin(['closeButton'=>false,
        'id' => 'anatomyModal']);
        echo "<div id='anatomyModalContent'></div>";
    Modal::end();
?>