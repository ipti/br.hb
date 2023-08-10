<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\icons\Icon;
use app\components\LetterWidget;


$this->title = "Todos as Cartas de Aviso";
?>
<div class="pull-right hidden-print">
    <?=Html::button(Icon::show('print',[], Icon::FA).Yii::t('app', 'Print'), ['id'=>'print-button', 'class'=>'btn btn-primary fixed-btn', 'onclick'=>'window.print()'])?>
</div>

<?php
    foreach ($schools as $i => $school):
        $sName = $school['name'];
        $classrooms = $school['classrooms'];
    //School
?>

    <div class="report-row">
        <div class="col grid-12">
            <p class='page-white'> Escola: <?= $sName ?> </p> 
        </div>
    </div>

    <div class="footer-print"></div>

    <?php 
        foreach ($classrooms as $j => $classroom):
            $cName = $classroom['name'];
            $students = $classroom['students'];
            //Classroom
    ?>
        <div class="report-row">
            <div class="col grid-12">
                <p class='page-white'> Turma: <?= $cName ?> </p> 
            </div>
        </div>

        <div class="footer-print"></div>

            <?php

            foreach ($students as $k => $student):
                $sName = $student['name'];
                $sSex = $student['sex'];
                $sMother = $student['nameMother'];
                $sFather = ($student['nameFather'] == 'NAO DECLARADO' ? '' : $student['nameFather']);
            ?> 
            <?=  LetterWidget::widget([
                    'data'=>[
                        'sName'=> $sName,
                        'sSex'=> $sSex,
                        'cName'=> $cName,
                        'mother'=> $sMother,
                        'father'=> $sFather
                    ]
                ]);

            ?>
             <div class="footer-print"></div>
<?php
    endforeach;
    endforeach;
    endforeach;
?>