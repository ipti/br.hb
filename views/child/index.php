<?php
use yii\bootstrap\Modal;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Alert;
use app\models\student;
use kartik\icons\Icon;

$this->title = Yii::t('app', 'Students');

echo Html::a('Adicionar', ['child/create'], [
    'class' => 'btn btn-primary navbar-btn',
    'style' => 'margin-bottom:10px',
    'id' => 'createButton'
]);

echo Html::a(Icon::show('import',[], Icon::BSG).yii::t('app', 'Import TAG data'), ['/load/index'], ['class' => 'btn btn-secondary navbar-btn']);
    

?>

<?php if (Yii::$app->session->hasFlash('success')): ?>
    <?= Alert::widget([
        'options' => ['class' => 'alert-success', 'style' => 'margin-top:20px;'],
        'body' => Yii::$app->session->getFlash('success'),
    ]) ?>
<?php endif; ?>

<?php

// Exibir o GridView
echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        'name',
        'responsible_1_name',
        [
            'attribute' => 'birthday',
            'value' => function ($model) {
                return Yii::$app->formatter->asDate($model->birthday, 'php:d/m/Y');
            },
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'contentOptions' => ['class' => 'text-center'],
            'template' => '{edit} {delete}',
            'buttons' => [
                'edit' => function ($url, $model) {
                    $id = $model->id;
                    $editUrl = Url::to(['child/update', 'id' => $id]);
                    $editButton = Html::button(Icon::show('pencil'), ['value' => $editUrl, 'class' => 'btn btn-primary btn-sm', 'id' => 'editButton-' . $id]);
                    
                    // Modal para edição
                    Modal::begin([
                        'id' => 'editModal-' . $id,
                        'size' => 'modal-lg',
                    ]);
                    echo "<div id='editModalContent-$id'></div>";
                    Modal::end();
                    
                    $script = "
                        $('#editButton-$id').on('click', function() {
                            $.get($(this).attr('value'), function(data) {
                                $('#editModalContent-$id').html(data);
                                $('#editModal-$id').modal('show');
                                $('#editModalContent-$id #student-allergy').prop('checked') ? $('.field-student-allergy_text').show() : $('.field-student-allergy_text').hide();
                                $('#editModalContent-$id #student-anemia').prop('checked') ? $('.field-student-anemia_text').show() : $('.field-student-anemia_text').hide();
                            });
                        });
                    ";
                    $this->registerJs($script);
                    
                    return $editButton;
                },
                'delete' => function ($url, $model) {
                    $id = $model->id;
                    $deleteUrl = Url::to(['child/delete', 'id' => $id]);
                    $deleteButton = Html::button(Icon::show('trash'), ['class' => 'btn btn-danger btn-sm', 'id' => 'deleteButton-' . $id, 'style' => 'margin-left:5px']);
                    
                    // Diálogo para confirmação de exclusão
                    $script = "
                        $('#deleteButton-$id').on('click', function() {
                            if (confirm('Deseja realmente excluir este estudante?')) {
                                $.post('$deleteUrl').done(function() {
                                    location.reload();
                                });
                            }
                        });
                    ";
                    $this->registerJs($script);
                    
                    return $deleteButton;
                },
            ],
        ],
    ],
]);