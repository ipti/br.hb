<?php
/* @var $this ImportController */

$this->breadcrumbs=array(
	'Import'=>array('/import'),
	'FromTAG',
);
?>        
<style>
    .no-close .ui-dialog-titlebar-close {
    display: none;
}
    
</style>

    
<h1><?php echo $this->id . '/' . $this->action->id; ?></h1>

<div class="form">
    <div class="row">
        <table id="schools">
            <tr><th>Nome</th><th>Importar</th></tr>
        </table>
    </div>
    <div class="row buttons">
        <?php echo CHtml::button(yii::t('default','Import'), array('id'=>'import')); ?>
    </div>
</div>



<?php 
    $target = 'window.location='."'".$this->createUrl('import/index')."'";
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
            'id'=>'confirm',
            // additional javascript options for the dialog plugin
            'options'=>array(
                    'title'=>yii::t('default','Information'),
                    'dialogClass'=> "no-close",
                    'autoOpen'=>false,
                    'modal'=>true, 
                    'buttons' => array(
                        array('text'=>'OK','click'=> 'js:function(){'.$target.'}'),
                    ),
                )
    ));

    echo yii::t('default','Import completed successfully!');

    $this->endWidget('zii.widgets.jui.CJuiDialog');


?>

<script>
    var schools;
    var school_address;
    var classroom;
    var enrollment;
    var student;
    var student_address;
    
    var importArray = {};
$(document).ready(function(){
    schools  = JSON.parse('<?php echo json_encode($schools) ?>');
    schools_address = JSON.parse('<?php echo json_encode($schools_address) ?>');
    classroom   = JSON.parse('<?php echo json_encode($classroom) ?>');
    enrollment  = JSON.parse('<?php echo json_encode($enrollment) ?>');
    student     = JSON.parse('<?php echo json_encode($student) ?>');
    student_address = JSON.parse('<?php echo json_encode($student_address) ?>');
    
    for(i in schools){
        var s = schools[i];
        $('#schools').append("<tr>"
            +"<td>"+s.name+"</td>"
            +"<td><input type='checkbox' name='school' value="+s.fid+" ></td>"
            +"</tr>");
        $('#schools').append("<tr>" 
            +"<td cellspan='2'><select multiple id=classrom_"+s.fid+" disabled></select></td>"    
            +"</tr>");
        for(j in classroom){
            var c = classroom[j];
            $("#classrom_"+s.fid).append('<option value='+c.fid+'>'+c.name+'</option>');
        }
        $('#schools input').on('click', function(){
            $("#classrom_"+s.fid).attr('disabled', !$("#classrom_"+s.fid).attr('disabled'));
        });
        $("#classrom_"+s.fid).attr('class','span-14').select2({
            placeholder: "<?php echo yii::t('default','Select Classrooms')?>"
            });
    }
    $("#import").on('click', function(){
    
    var d = new Date();
    var n1 = d.getTime(); 
        $("input:checkbox[name=school]:checked").each(function(){
            var schoolID = $(this).val();
            var classroomIDs = $("#classrom_"+schoolID).val();
            importArray[schoolID] = {};
            importArray[schoolID]['Info'] = find(schools,'fid',schoolID);
            importArray[schoolID]['Address'] = find(schools_address,'school_id',schoolID);
            importArray[schoolID]['Classrooms']={};
            
            $(classroomIDs).each(function(i, e){
                var classroomID = e;
                var classroomInfo = find(classroom, 'fid',classroomID);
                importArray[schoolID]['Classrooms'][classroomID] = {};
                importArray[schoolID]['Classrooms'][classroomID]['Info'] = classroomInfo;
                importArray[schoolID]['Classrooms'][classroomID]['Students'] = {};
                
                var enrollments = findAll(enrollment, 'classroom', classroomID);
                for(i in enrollments){
                    e = enrollments[i];
                    var studentID = e.student;
                    var studentInfo = find(student, 'fid', studentID);
                    var studentAddress = find(student_address, 'student_id', studentID);
                    importArray[schoolID]['Classrooms'][classroomID]['Students'][studentID] = {};
                    importArray[schoolID]['Classrooms'][classroomID]['Students'][studentID]['Info'] = studentInfo;
                    importArray[schoolID]['Classrooms'][classroomID]['Students'][studentID]['Address'] = studentAddress;
                }
            });
        });
        var url = 'index.php?r=import/tohb';
        $.post(url,{import:JSON.stringify(importArray)}, importConfirmed, 'JSON');
    d = new Date();
    var n2 = d.getTime(); 
    console.log(n2-n1 +"ms");
    });
    
});

/**
 * Confirma que o import foi executado com sucesso.
 * 
 * @returns {void} */
function importConfirmed(){
    $("#confirm").dialog("open");
}

/**
 * Procura o objeto dentro de uma array que possui o valor em determinado campo.
 * 
 * 
 * @param {array} array
 * @param {string} field
 * @param {mixed} value
 * @returns {object}
 *  */
function find(a, f, v){
    for(i in a){
        if(a[i][f] == v)
            return a[i];
    }
    return null;
}

/**
 * Procura os objetos dentro de uma array que possui o valor em determinado campo.
 * 
 * 
 * @param {array} array
 * @param {string} field
 * @param {mixed} value
 * @returns {array}
 */
function findAll(a, f, v){
    r = new Array();
    for(i in a){
        if(a[i][f] == v)
            r.push(a[i]);
    }
    return r;
}
</script>