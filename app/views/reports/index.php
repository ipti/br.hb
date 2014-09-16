<?php
/* @var $this ReportsController */

$this->breadcrumbs=array(
	'Reports',
);
?>
<h1><?php echo $this->id . '/' . $this->action->id; ?></h1>

<?php
    echo CHtml::link("Letter", yii::app()->urlManager->createUrl("reports/letterReport"));
    echo "<br/>";
    echo CHtml::link("Term", yii::app()->urlManager->createUrl("reports/termReport"));
    echo "<br/>";
    echo CHtml::link("Anaminese", yii::app()->urlManager->createUrl("reports/anamineseReport"));
    echo "<br/>";
    echo CHtml::link("Prescription", yii::app()->urlManager->createUrl("reports/prescriptionReport"));
?>