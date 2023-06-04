<?php
use yii\bootstrap\Modal;
use \kartik\helpers\Html;
use \yii\helpers\Url;
use kartik\icons\Icon;

/** @var yii\web\View  $this yii\web\View */
$this->title = yii::t('app', 'Campaigns');


$this->assetBundles['Site'] = new app\assets\AppAsset();
$this->assetBundles['Site']->js = [
    'scripts/SiteView/Functions.js',
    'scripts/SiteView/Click.js'
];
$this->params['button'] = Html::button(Icon::show('plus',[], Icon::BSG).
                    yii::t('app', 'New Campaign'), 
                    ['value' => Url::to(['campaign/create']),
                        'id'=>'newCampaign',
                        'class'=>'btn btn-success navbar-btn',
                        'for'=>'#'
                    ]);

$this->params['siteIndex'] = true;

?>
<div class="site-index">
    <div class="body-content">

        <div class="row">
        <?php        
        $today = date("j-n-Y");
        $count = 0;
        foreach ($campaigns as $campaign_resume){
            $campaign_resume['terms']['Url'] = Url::to(['term/index', 'c' => $campaign_resume['campaing']['Id']]); 
            $campaign_resume['anatomies']['Url'] = Url::to(['anatomy/index', 'cid' => $campaign_resume['campaing']['Id']]);
            $campaign_resume['hb1']['Url'] = Url::to(['hemoglobin/index', 'c' => $campaign_resume['campaing']['Id'], 's' => '1']);
            $campaign_resume['consults']['Url'] = Url::to(['consultation/index', 'c' => $campaign_resume['campaing']['Id']]);
            $campaign_resume['hb2']['Url'] = Url::to(['hemoglobin/index', 'c' => $campaign_resume['campaing']['Id'], 's' => '2']);
            $campaign_resume['hb3']['Url'] = Url::to(['hemoglobin/index', 'c' => $campaign_resume['campaing']['Id'], 's' => '3']);
            $campaign_resume['ferritin']['Url'] = Url::to(['ferritin/index', 'c' => $campaign_resume['campaing']['Id']]);

            $now = time(); // or your date as well
            $begin = strtotime($campaign_resume['campaing']["begin"]);
            $end = strtotime($campaign_resume['campaing']["end"]);
            $tot = floor(($end-$begin)/(60*60*24));
            $act = floor(($now-$begin)/(60*60*24));
            $tot = $tot == 0 ? 1 : $tot;
                
            $count++;
            ?>
            <div id="campaing-col[<?= $campaign_resume['campaing']['Id'] ?>]" class="campaign-col col-sm-6 col-md-3">
                <div id="campaing-box[<?= $campaign_resume['campaing']['Id'] ?>]" class="campaign-box">
                    <h2 id="campaing-box[<?= $campaign_resume['campaing']['Id'] ?>]-title" class="campaign-box-container campaign-box-title"><?php echo $campaign_resume['campaing']['Name']  ?></h2>
                    <?= Html::button(yii::t('app', 'edit') . ' ' . Icon::show('edit'), 
                    ['value' => Url::to(['campaign/update', 'id'=> $campaign_resume['campaing']['Id']]),
                        'class'=>'updateCampaign campaign-box-edit',
                        'for'=>'#'
                    ]);?>
                    <div id="campaing-box[<?= $campaign_resume['campaing']['Id'] ?>]-anatomies" class="campaign-box-container">
                        <div class="campaign-box-label"><?= Html::a(Yii::t('app', 'Ferritin').': ',$campaign_resume['ferritin'] ['Url'])?></div>
                        <div class="campaign-box-content">
                        <?= Html::a($campaign_resume['ferritin']['Done'].' '.Icon::show('check', ['class'=>'icon-sucess']),
                                    $campaign_resume['ferritin']['Url'])?>&nbsp;
                            <?= Html::a($campaign_resume['ferritin']['UnDone'].' '.Icon::show('remove', ['class'=>'icon-error']),
                                    $campaign_resume['ferritin']['Url'])?>
                        </div>
                    </div><!-- end ferritin -->
                    <div id="campaing-box[<?= $campaign_resume['campaing']['Id'] ?>]-anatomies" class="campaign-box-container">
                        <div class="campaign-box-label"><?= Html::a(Yii::t('app', 'Anatomies').': ',$campaign_resume['anatomies']['Url'])?></div>
                        <div class="campaign-box-content">
                            <?= Html::a($campaign_resume['anatomies']['OutOfDate'].' '.Icon::show('info', ['class'=>'icon-info']),
                                    $campaign_resume['anatomies']['Url'])?>&nbsp;
                            <?= Html::a($campaign_resume['anatomies']['Updated'].' '.Icon::show('check', ['class'=>'icon-sucess']),
                                    $campaign_resume['anatomies']['Url'])?>&nbsp;
                            <?= Html::a($campaign_resume['anatomies']['Unknown'].' '.Icon::show('remove', ['class'=>'icon-error']),
                                    $campaign_resume['anatomies']['Url'])?>
                        </div>
                    </div><!-- end anatomies -->
                    <div id="campaing-box[<?= $campaign_resume['campaing']['Id'] ?>]-terms" class="campaign-box-container">
                        <div class="campaign-box-label"><?= Html::a(Yii::t('app_v2', 'Terms').': ',$campaign_resume['terms']['Url'])?></div>
                        <div class="campaign-box-content">
                            <?= Html::a($campaign_resume['terms']['Agreed'].' '.Icon::show('check', ['class'=>'icon-sucess']),
                                    $campaign_resume['terms']['Url'])?>&nbsp;
                            <?= Html::a($campaign_resume['terms']['UnAgreed'].' '.Icon::show('remove', ['class'=>'icon-error']),
                                    $campaign_resume['terms']['Url'])?>
                        </div>
                    </div> <!-- end terms -->
                    
                    <div id="campaing-box[<?= $campaign_resume['campaing']['Id'] ?>]-hb1" class="campaign-box-container">
                        <div class="campaign-box-label"><?= Html::a(Yii::t('app', 'HB1').': ',$campaign_resume['hb1']['Url'])?></div>
                        <div class="campaign-box-content">
                            <?= Html::a($campaign_resume['hb1']['Done'].' '.Icon::show('check', ['class'=>'icon-sucess']),
                                    $campaign_resume['hb1']['Url'])?>&nbsp;
                            <?= Html::a($campaign_resume['hb1']['UnDone'].' '.Icon::show('remove', ['class'=>'icon-error']),
                                    $campaign_resume['hb1']['Url'])?>
                        </div>
                    </div>
                    <div id="campaing-box[<?= $campaign_resume['campaing']['Id'] ?>]-consults" class="campaign-box-container">
                        <div class="campaign-box-label"><?= Html::a(Yii::t('app', 'Consults').': ',$campaign_resume['consults']['Url'])?></div>
                        <div class="campaign-box-content">
                            <?= Html::a($campaign_resume['consults']['Attended'].' '.Icon::show('check', ['class'=>'icon-sucess']),
                                    $campaign_resume['consults']['Url'])?>&nbsp;
                            <?= Html::a($campaign_resume['consults']['NotAttended'].' '.Icon::show('remove', ['class'=>'icon-error']),
                                    $campaign_resume['consults']['Url'])?>
                        </div>
                    </div>
                    <div id="campaing-box[<?= $campaign_resume['campaing']['Id'] ?>]-hb2" class="campaign-box-container">
                        <div class="campaign-box-label"><?= Html::a(Yii::t('app', 'HB2').': ',$campaign_resume['hb2']['Url'])?></div>
                        <div class="campaign-box-content">
                            <?= Html::a($campaign_resume['hb2']['Done'].' '.Icon::show('check', ['class'=>'icon-sucess']),
                                    $campaign_resume['hb2']['Url'])?>&nbsp;
                            <?= Html::a($campaign_resume['hb2']['UnDone'].' '.Icon::show('remove', ['class'=>'icon-error']),
                                    $campaign_resume['hb2']['Url'])?>
                        </div>
                    </div>
                    <div id="campaing-box[<?= $campaign_resume['campaing']['Id'] ?>]-hb3" class="campaign-box-container">
                        <div class="campaign-box-label"><?= Html::a(Yii::t('app', 'HB3').': ',$campaign_resume['hb3']['Url'])?></div>
                        <div class="campaign-box-content">
                            <?= Html::a($campaign_resume['hb3']['Done'].' '.Icon::show('check', ['class'=>'icon-sucess']),
                                    $campaign_resume['hb3']['Url'])?>&nbsp;
                            <?= Html::a($campaign_resume['hb3']['UnDone'].' '.Icon::show('remove', ['class'=>'icon-error']),
                                    $campaign_resume['hb3']['Url'])?>
                        </div>
                    </div>
                    <?php 
                    //$percent = $act/$tot * 100 ;
                    $percent = ($act/$tot * 100) < 0 ? 0 : (($act/$tot * 100) > 100 ? 100 : $act/$tot * 100);
                    $color = ($percent <= 30)?'progress-bar-info'
                            :(($percent > 30 && $percent <= 60 )?'progress-bar-success'
                                :(($percent > 60 && $percent <= 90 )?'progress-bar-warning'
                                    :'progress-bar-danger'))  ;?>
                    <?= yii\bootstrap\Progress::widget([
                        'percent' => $percent,
                        'label' => '<p>'. yii::t("app","Terminate day: {date}", ['date'=>  date('d/m/Y', $end)]).'</p>',
                        'options'=>[
                            'class' =>   'active campaign-box-content campaign-box-progress-bar'],
                            
                        'barOptions' => ['class' => 'progress-bar-campaign text-black-bar '.$color]
                    ]);?>
                    <div class="clearfix"></div>
                </div>
            </div>
            
                <?php
                if ($count % 4 == 0 ) { ?>
                    </div>
                    <div class="row">
                <?php } ?>    
        <?php }?>
           
        </div>

    </div>
</div>
<?php
    Modal::begin(['closeButton'=>false,
        'id' => 'campaignModal']);
        echo "<div id='campaignModalContent'></div>";
    Modal::end();
?>
