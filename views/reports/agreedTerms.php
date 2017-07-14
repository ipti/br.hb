<div class="report-content" id="weight-height">
        <div class="report-head">
            
            <div class="row pdf">
                <div class="col grid-3 pdf">
                <img src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/hb.png" alt="HB" width="40">
                </div>
                <div class="col grid-6 pdf">
                    <h4 class="report-title">Termos Consentidos</h4>
                </div>
                <div class="col grid-3 pdf">
                    <img src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/apoio.png" alt="Apoio" width="220">
                </div>
                
            </div>
        </div>

        <div class="report-body">
            <?php 

                foreach ($terms as $cName => $students):?>

                    <div class="report-row pdf report-text-left">
                        <div class="col grid-12 pdf">
                            <p style="font-size:13px"> <span class="bold">Escola: </span><?= $school ?> </p>
                        </div>
                    </div>
                    <div class="report-row pdf report-text-left">
                        <div class="col grid-12 pdf">
                            <p style="font-size:13px"> <span class="bold">Turma: </span><?= $cName ?> </p>
                        </div>
                    </div>
                        <table class="table" id="height">
                            <tr class="border-bottom">
                                <th class='border-right' style="width:50%;">Aluno</th>
                                <th class='border-right text-center' style="width:17%;">Nascimento</th>
                                <th class='border-right text-center' style="width:11%;">Taxa 1</th>
                                <th class='border-right text-center' style="width:11%;">Taxa 2</th>
                                <th class="text-center" style="width:11%;">Taxa 3</th>
                            </tr>
                        <?php foreach ($students as $k => $student): ?>

                            <tr>
                                <td class='border-bottom-dashed-right'> <?= $student['name'] ?></td>
                                <td class='border-bottom-dashed-right text-center'><?= date("d/m/Y", strtotime($student['birthday'])) ?></td>
                                <td class='border-bottom-dashed-right text-center'><?= $student['hb1'] == null? '': ($student['hb1'].' g/dL') ?></td>
                                <td class='border-bottom-dashed-right text-center'><?= $student['hb2'] == null? '': ($student['hb2'].' g/dL') ?></td>
                                <td class='border-bottom-dashed text-center'><?= $student['hb3'] == null? '': ($student['hb3'].' g/dL') ?></td>
                            
                            </tr>
                       
                       <?php endforeach; ?>

                        </table>

                        <?php if (end($terms) !== $students) { ?>
                            <pagebreak type='NEXT-ODD' resetpagenum='1' pagenumstyle='i' suppress='off' />
                        <?php } ?>

                <?php endforeach; ?>



</div>