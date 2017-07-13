<div class="report-content" id="weight-height">
        <div class="report-head">
            
            <div class="row pdf">
                <div class="col grid-3 pdf">
                <img src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/hb.png" alt="HB" width="40">
                </div>
                <div class="col grid-6 pdf">
                    <h4 class="report-title">Lista de Pesos e Alturas</h4>
                </div>
                <div class="col grid-3 pdf">
                    <img src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/apoio.png" alt="Apoio" width="220">
                </div>
                
            </div>
        </div>

        <div class="report-body">
            <?php 
                foreach ($data['students'] as $i => $school):

                    foreach ($school['classrooms'] as $j => $classroom):?>

                    <div class="report-row pdf report-text-left">
                        <div class="col grid-12 pdf">
                            <p style="font-size:13px"> <span class="bold">Escola: </span><?= $school['name']; ?> </p>
                        </div>
                    </div>
                    <div class="report-row pdf report-text-left">
                        <div class="col grid-12 pdf">
                            <p style="font-size:13px"> <span class="bold">Turma: </span><?= $classroom['name']; ?> </p>
                        </div>
                    </div>
                        <table class="table" id="height">
                            <tr class="border-bottom">
                                <th class='border-right' style="width:60%;">Aluno</th>
                                <th class='border-right text-center' style="width:15%;">Peso</th>
                                <th class="text-center" style="width:15%;">Altura</th>
                            </tr>
                        <?php foreach ($classroom['students'] as $k => $student): ?>

                            <tr>
                                <td class='border-bottom-dashed-right'> <?= $student['name'] ?></td>

                           <?php if (isset($student['weight'])){ ?>
                                <td class='border-bottom-dashed-right text-center'><?= sprintf('%0.1f', $student['weight']) ?>kg</td>
                            <?php } else { ?>
                                <td class='border-bottom-dashed-right text-center'></td>
                            <?php }

                            if (isset($student['height'])){ ?>
                                <td class='border-bottom-dashed text-center'> <?= sprintf('%0.2f', $student['height']) ?>m</td>
                                
                            <?php } else { ?>
                                <td class='border-bottom-dashed-right text-center'></td>
                            <?php } ?>
                            </tr>
                       
                       <?php endforeach; ?>

                        </table>

                        <?php if (end($school['classrooms']) !== $classroom) { ?>
                            <pagebreak type='NEXT-ODD' resetpagenum='1' pagenumstyle='i' suppress='off' />
                        <?php } ?>

                    <?php endforeach; ?>

                <?php endforeach; ?>



</div>