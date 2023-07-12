<?php
use yii\bootstrap\Modal;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\helpers\Html;
use app\models\student;

$this->title = Yii::t('app', 'Students');

echo Html::a('Criar Aluno', ['child/create'], [
    'class' => 'btn btn-success',
    'id' => 'createButton',
    'data-toggle' => 'modal',
    'data-target' => '#createModal',
]);

// Exibir o GridView
echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        'name',
        'mother',
        [
            'attribute' => 'birthday',
            'value' => function ($model) {
                return Yii::$app->formatter->asDate($model->birthday, 'php:d/m/Y');
            },
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{edit} {delete}',
            'buttons' => [
                'edit' => function ($url, $model) {
                    $id = $model->id;
                    $editUrl = Url::to(['child/update', 'id' => $id]);
                    $editButton = Html::button('Editar', ['value' => $editUrl, 'class' => 'btn btn-primary btn-sm', 'id' => 'editButton-' . $id]);
                    
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
                            });
                        });
                    ";
                    $this->registerJs($script);
                    
                    return $editButton;
                },
                'delete' => function ($url, $model) {
                    $id = $model->id;
                    $deleteUrl = Url::to(['child/delete', 'id' => $id]);
                    $deleteButton = Html::button('Excluir', ['class' => 'btn btn-danger btn-sm', 'id' => 'deleteButton-' . $id]);
                    
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

// Modal de criação
Modal::begin([
    'id' => 'createModal',
    'size' => 'modal-lg',
]);
echo "<div id='createModalContent'></div>";
Modal::end();

// Script para carregar o formulário de criação no modal
$createUrl = Url::to(['child/create']);
$script = "
    $('#createButton').on('click', function() {
        $.get('$createUrl', function(data) {
            $('#createModalContent').html(data);
            $('#createModal').modal('show');
        });
    });
";
$this->registerJs($script);