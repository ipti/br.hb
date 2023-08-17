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
        $countLetters = 0;
        foreach ($classrooms as $j => $classroom):
            $cName = $classroom['name'];
            $students = $classroom['students'];
            
   
            
           
            foreach ($students as $k => $student):
                $sName = $student['name'];
                $sSex = $student['sex'];
                $sHb1 = $student['hb1'];
                $sMother = $student['nameMother'];
                $sFather = ($student['nameFather'] == 'NAO DECLARADO' ? '' : $student['nameFather']);
               
            
             
             echo LetterWidget::widget([
                    'data'=>[
                        'sName'=> $sName,
                        'sSex'=> $sSex,
                        'sHb1'=> $sHb1,
                        'cName'=> $cName,
                        'mother'=> $sMother,
                        'father'=> $sFather,
                        'isConsutationLetters'=> $isConsutationLetters
                    ]
                ]);
                $countLetters+=1;
                if ($countLetters == 2) {
                    $countLetters = 0;
                    echo "<div class='footer-print'></div>";
                }
  
    endforeach;
    endforeach;
    endforeach;

?>
