<?php
use yii\bootstrap\Modal;
use \kartik\helpers\Html;
use \yii\helpers\Url;
use kartik\icons\Icon;

/* @var $this yii\web\View */
$this->title = yii::t('app', 'Campaigns');


$this->assetBundles['Site'] = new app\assets\AppAsset();
$this->assetBundles['Site']->js = [
    'scripts/SiteView/Functions.js',
    'scripts/SiteView/Click.js'
];

?>
<div class="site-index">
    <div class="body-content">

        <div class="row">
        <?php
        $campaing = new \app\models\campaign();
        $today = date("j-n-Y");
        $count = 0;
        $campaings = $campaing->find()->where('end > '.$today)->orderBy('begin, end asc')->all();
        foreach ($campaings as $c){
            /* @var $c \app\models\Campaign*/
            $count++;
            
            $campaing = [];
            $campaing['Name'] = $c->name;
            $campaing['Id'] = $c->id;
            
            $terms['Total'] = $c->getTerms()->count();
            $terms['Agreed'] = $c->getTerms()->where(["agreed" => true])->count();
            $terms['UnAgreed'] = $terms['Total']-$terms['Agreed'];
            $terms['Url'] = Url::to(['term/index', 'c' => $campaing['Id']]);
            
            $anatomies['Total'] = $c->getStudentsAnatomies()->count();
            $anatomies['Updated'] = $c->getStudentsAnatomies()->where('anatomy.date >= :date', ['date'=>$c->begin])->count();
            $anatomies['Unknown'] = $terms['Total']-$anatomies['Total'];
            $anatomies['OutOfDate'] = $terms['Total']-$anatomies['Updated']-$anatomies['Unknown'];
            $anatomies['Url'] = Url::to(['anatomy/index', 'c' => $campaing['Id']]);

            $hb1['Total'] = $terms['Agreed'];
            $hb1['Done'] = $c->getHemoglobins()->where(["sample" => '1'])->count();
            $hb1['UnDone'] = $hb1['Total'] - $hb1['Done'];
            $hb1['Url'] = Url::to(['hemoglobin/index', 'c' => $campaing['Id'], 's' => '1']);

            $consults['Total'] =  $c->getConsults()->count();
            $consults['Attended'] =  $c->getConsults()->where(["attended" => '1'])->count();
            $consults['NotAttended'] = $consults['Total']-$consults['Attended'];
            $consults['Url'] = Url::to(['consultation/index', 'c' => $campaing['Id']]);

            $hb2['Total'] = $consults['Attended'];
            $hb2['Done'] = $c->getHemoglobins()->where(["sample" => '2'])->count();
            $hb2['UnDone'] = $hb2['Total'] - $hb2['Done'];
            $hb2['Url'] = Url::to(['hemoglobin/index', 'c' => $campaing['Id'], 's' => '2']);

            $hb3['Total'] = $consults['Attended'];
            $hb3['Done'] = $c->getHemoglobins()->where(["sample" => '3'])->count();
            $hb3['UnDone'] = $hb3['Total'] - $hb3['Done'];
            $hb3['Url'] = Url::to(['hemoglobin/index', 'c' => $campaing['Id'], 's' => '3']);
        ?>
            <div id="campaing-col[<?= $campaing['Id'] ?>]" class="campaign-col col-sm-6 col-md-3">
                <div id="campaing-box[<?= $campaing['Id'] ?>]" class="campaign-box">
                    <h2 id="campaing-box[<?= $campaing['Id'] ?>]-title" class="campaign-box-container campaign-box-title"><?php echo $campaing['Name']  ?></h2>
                    <a id="campaing-box[<?= $campaing['Id'] ?>]-edit" class="campaign-box-edit" href="#"><?= yii::t('app', 'edit') . ' ' . Icon::show('edit')?></a>
                    <div id="campaing-box[<?= $campaing['Id'] ?>]-terms" class="campaign-box-container">
                        <div class="campaign-box-label"><?= Html::a(Yii::t('app', 'Terms').': ',$terms['Url'])?></div>
                        <div class="campaign-box-content">
                            <?= Html::a($terms['Agreed'].' '.Icon::show('check', ['class'=>'icon-sucess']),
                                    $terms['Url'])?>&nbsp;
                            <?= Html::a($terms['UnAgreed'].' '.Icon::show('remove', ['class'=>'icon-error']),
                                    $terms['Url'])?>
                        </div>
                    </div>
                    <div id="campaing-box[<?= $campaing['Id'] ?>]-anatomies" class="campaign-box-container">
                        <div class="campaign-box-label"><?= Html::a(Yii::t('app', 'Anatomies').': ',$anatomies['Url'])?></div>
                        <div class="campaign-box-content">
                            <?= Html::a($anatomies['OutOfDate'].' '.Icon::show('info', ['class'=>'icon-info']),
                                    $anatomies['Url'])?>&nbsp;
                            <?= Html::a($anatomies['Updated'].' '.Icon::show('check', ['class'=>'icon-sucess']),
                                    $anatomies['Url'])?>&nbsp;
                            <?= Html::a($anatomies['Unknown'].' '.Icon::show('remove', ['class'=>'icon-error']),
                                    $anatomies['Url'])?>
                        </div>
                    </div>
                    <div id="campaing-box[<?= $campaing['Id'] ?>]-hb1" class="campaign-box-container">
                        <div class="campaign-box-label"><?= Html::a(Yii::t('app', 'HB1').': ',$hb1['Url'])?></div>
                        <div class="campaign-box-content">
                            <?= Html::a($hb1['Done'].' '.Icon::show('check', ['class'=>'icon-sucess']),
                                    $hb1['Url'])?>&nbsp;
                            <?= Html::a($hb1['UnDone'].' '.Icon::show('remove', ['class'=>'icon-error']),
                                    $hb1['Url'])?>
                        </div>
                    </div>
                    <div id="campaing-box[<?= $campaing['Id'] ?>]-consults" class="campaign-box-container">
                        <div class="campaign-box-label"><?= Html::a(Yii::t('app', 'Consults').': ',$consults['Url'])?></div>
                        <div class="campaign-box-content">
                            <?= Html::a($consults['Attended'].' '.Icon::show('check', ['class'=>'icon-sucess']),
                                    $consults['Url'])?>&nbsp;
                            <?= Html::a($consults['NotAttended'].' '.Icon::show('remove', ['class'=>'icon-error']),
                                    $consults['Url'])?>
                        </div>
                    </div>
                    <div id="campaing-box[<?= $campaing['Id'] ?>]-hb2" class="campaign-box-container">
                        <div class="campaign-box-label"><?= Html::a(Yii::t('app', 'HB2').': ',$hb2['Url'])?></div>
                        <div class="campaign-box-content">
                            <?= Html::a($hb2['Done'].' '.Icon::show('check', ['class'=>'icon-sucess']),
                                    $hb2['Url'])?>&nbsp;
                            <?= Html::a($hb2['UnDone'].' '.Icon::show('remove', ['class'=>'icon-error']),
                                    $hb2['Url'])?>
                        </div>
                    </div>
                    <div id="campaing-box[<?= $campaing['Id'] ?>]-hb3" class="campaign-box-container">
                        <div class="campaign-box-label"><?= Html::a(Yii::t('app', 'HB3').': ',$hb3['Url'])?></div>
                        <div class="campaign-box-content">
                            <?= Html::a($hb3['Done'].' '.Icon::show('check', ['class'=>'icon-sucess']),
                                    $hb3['Url'])?>&nbsp;
                            <?= Html::a($hb3['UnDone'].' '.Icon::show('remove', ['class'=>'icon-error']),
                                    $hb3['Url'])?>
                        </div>
                    </div>
                    <?php
                        $now = time(); // or your date as well
                        $begin = strtotime($c["begin"]);
                        $end = strtotime($c["end"]);
                        $tot = floor(($end-$begin)/(60*60*24));
                        $act = floor(($now-$begin)/(60*60*24));
                        $tot = $tot == 0 ? 1 : $tot;
                    ?>

                    <?= yii\bootstrap\Progress::widget([
                        'percent' => $act/$tot * 100,
                        'label' => yii::t("app","Day")." ".$act.'/'.$tot,
                        'options'=>[
                            'class' => 'active campaign-box-content campaign-box-progress-bar'],
                        'barOptions' => ['class' => 'progress-bar-campaign text-black-bar']
                    ]);?>
                    <div class="clearfix"></div>
                </div>
            </div>
            
            <?php if ($count % 4 == 0 ) { ?>
                </div>
                <div class="row">
            <?php } ?>
                    
        <?php }?>
            <div class="campaign-box col-lg-2" id="newCampaignBox">
                <?= Html::button(Icon::show('plus',[], Icon::BSG).
                    yii::t('app', 'New Campaign'), 
                    ['value' => Url::to(['campaign/create']),
                        'id'=>'newCampaign',
                        'class'=>'btn btn-success',
                        'for'=>'#'
                    ]) 
                ?>
            </div>
        </div>

    </div>
</div>
<?php
    Modal::begin(['id' => 'campignModal']);
        echo "<div id='campignModalContent'></div>";
    Modal::end();
?>
