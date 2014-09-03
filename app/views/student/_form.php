<?php
/* @var $this StudentController */
/* @var $model Student */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'student-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

<!--	<div class="row">
		<?php echo $form->labelEx($model,'fid'); ?>
		<?php echo $form->textField($model,'fid',array('size'=>45,'maxlength'=>45, 'disabled'=>'true')); ?>
		<?php echo $form->error($model,'fid'); ?>
	</div>-->

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'responsible'); ?>
		<?php echo $form->textField($model,'responsible',array('size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'responsible'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'address'); ?>
		<?php echo //$form->dropDownList($model, 'address', CHtml::listData(Address::model()->findAll(), 'id', 'street'));
                CHtml::button(yii::t('default', 'Address'), array('onclick'=>'$("#addressForm").dialog("open"); return false;'));
               // $form->dropDownList($model,'address',CHTML::listData(Address::model()->findAll(), 'id', 'street')); ?>
		<?php echo $form->error($model,'address'); ?>
            <?php echo chtml::HiddenField('myAddress', '');
            ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'birthday'); ?>
		<?php echo $form->dateField($model,'birthday'); ?>
		<?php echo $form->error($model,'birthday'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'gender'); ?>
		<?php echo $form->radioButtonList($model,'gender',
                        array(
                            'male'=>yii::t('default', 'Male'),
                            'female'=>yii::t('default', 'Female')),
                        array('labelOptions'=>array('style'=>'display:inline'))); ?>
		<?php echo $form->error($model,'gender'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

    <?php $this->endWidget(); 


    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
            'id'=>'addressForm',
            // additional javascript options for the dialog plugin
            'options'=>array(
                    'title'=>'addressForm',
                    'autoOpen'=>false,
                    'modal'=>true,		
            ),
    ));

    $model = $model->addressFK == null ? Address::model() : $model->addressFK;
    CController::renderPartial('/address/_form', array('model'=>  $model));

    $this->endWidget('zii.widgets.jui.CJuiDialog');?>

        
        
</div><!-- form -->

<script>
    var save = '<?php echo yii::t('default','save');?>';
    var address = null;
    
    $(document).ready(function(){
        $('#address-form input[type=submit]').hide();
        
        $('#address-form .buttons').append("<input type='button' value='"+save+"' id='modalsave'/>")
        $('#modalsave').on('click', function(){
            address = JSON.stringify($('#address-form').serializeArray());
            $("#myAddress").attr('value',address);
            $("#addressForm").dialog("close");
        });
    });
    $(window).load(function(){
        $("#addressForm").dialog("open");
        $('#modalsave').trigger("click");
    });
</script>