<?php
/* @var $this ImportController */

$this->breadcrumbs=array(
	'Import'=>array('/import'),
	'FromTAG',
);
?>        
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
    $schools = Yii::app()->db2->createCommand("SELECT inep_id as fid, `name` from school_identification;")->queryAll();
    $schools_address = Yii::app()->db2->createCommand("
        SELECT inep_id as school_id, uf.acronym as state, city.`name` as city, address_neighborhood as neighborhood, address as street, address_number as number, address_complement as complement, cep as postal_code from school_identification
            JOIN edcenso_uf as uf on uf.id = edcenso_uf_fk
            JOIN edcenso_city as city on city.id = edcenso_city_fk;")->queryAll();
    
    $classroom = Yii::app()->db2->createCommand("SELECT id as fid, `name`, turn as shift from classroom 
            WHERE school_year = DATE_FORMAT(NOW(),'%Y')-1;")->queryAll();
    
    $enrollment = Yii::app()->db2->createCommand("SELECT student_fk as student, classroom_fk as classroom FROM student_enrollment;")->queryAll();
    
    $student = Yii::app()->db2->createCommand("SELECT id as fid, `name`, birthday,IF(sex=1, 'male','female') as gender, IF(mother_name IS NULL,father_name,mother_name) as responsible FROM TAG_SGE.student_identification;")->queryAll();
    $student_address = Yii::app()->db2->createCommand("
        SELECT sda.id as student_id, uf.acronym as state, city.`name` as city, neighborhood as neighborhood, address as street, number as number, complement as complement, cep as postal_code FROM TAG_SGE.student_documents_and_address as sda
            JOIN edcenso_uf as uf on uf.id = edcenso_uf_fk
            JOIN edcenso_city as city on city.id = edcenso_city_fk;")->queryAll();
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
            
            $(classroomIDs).each(function(i, e){
                var classroomID = e;
                importArray[schoolID][classroomID] = {};
                importArray[schoolID]['Info'] = find(schools,'fid',schoolID)
                importArray[schoolID]['Address'] = find(schools_address,'school_id',schoolID);
                
                var enrollments = findAll(enrollment, 'classroom', classroomID);
                for(i in enrollments){
                    e = enrollments[i];
                    var studentID = e.student;
                    var studentInfo = find(student, 'fid', studentID);
                    var studentAddress = find(student_address, 'student_id', studentID);
                    importArray[schoolID][classroomID][studentID] = {};
                    importArray[schoolID][classroomID][studentID]['Info'] = studentInfo;
                    importArray[schoolID][classroomID][studentID]['Address'] = studentAddress;
                }
            });
        });
        var url = 'index.php?r=import/tohb';
        $.post(url,{import:JSON.stringify(importArray)}, function(){}, 'JSON');
    d = new Date();
    var n2 = d.getTime(); 
    console.log(n2-n1 +"ms");
    });
    
});

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