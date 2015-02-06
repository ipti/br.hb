<?php
use yii\bootstrap\Modal;
use \kartik\helpers\Html;
use \yii\helpers\Url;
use kartik\icons\Icon;

/* @var $this yii\web\View */
$this->title = 'HB - IPTI';


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
        $campaing = new \app\models\Campaign();
        $today = date("j-n-Y");
        $campaings = $campaing->find()->where('end > '.$today)->all();
        foreach ($campaings as $c){
            //$c = new \app\models\Campaign();
            
            $campaingName = $c->name;
            
            $terms['Total'] = $c->getTerms()->count();
            $terms['Agreed'] = $c->getTerms()->count("agreed = true");
            $terms['UnAgreed'] = $terms['Total']-$terms['Agreed'];
            $terms['Url'] = "";

            $anatomies['Total'] = $c->getStudentsAnatomies()->count();
            $anatomies['Updated'] = $c->getStudentsAnatomies()->count("date >= ".$c->begin);
            $anatomies['OutOfDate'] = $c->getStudentsAnatomies()->count("date < ".$c->begin);
            $anatomies['Unknown'] = $anatomies['Total']-$anatomies['Updated']-$anatomies['OutOfDate'];
            $anatomies['Url'] = "";

            $hb1['Total'] = $terms['Agreed'];
            $hb1['Done'] = $c->getHemoglobins()->count('sample = 1');
            $hb1['UnDone'] = $hb1['Total'] - $hb1['Done'];
            $hb1['Url'] = "";

            $consults['Total'] =  $c->getConsults()->count();
            $consults['Attended'] =  $c->getConsults()->count('Attended = 1');
            $consults['NotAttended'] = $consults['Total']-$consults['Attended'];
            $consults['Url'] = "";

            $hb2['Total'] = $consults['Attended'];
            $hb2['Done'] = $c->getHemoglobins()->count('sample = 2');
            $hb2['UnDone'] = $hb2['Total'] - $hb2['Done'];
            $hb2['Url'] = "";


            $hb3['Total'] = $consults['Attended'];
            $hb3['Done'] = $c->getHemoglobins()->count('sample = 3');
            $hb3['UnDone'] = $hb3['Total'] - $hb3['Done'];
            $hb3['Url'] = "";
        ?>
            <div class="campaign-box col-lg-2">
                <div id="campaing-box-title" class="campaign-box-container"><?= Html::label($campaingName,'') ?></div>
                <div id="campaing-box-terms" class="campaign-box-container">
                    <div class="campaing-box-label"><?= Html::label(Yii::t('app', 'Terms').': ')?></div>
                    <div class="campaing-box-content">
                        <?= Html::a($terms['Agreed'].Icon::show('ok-sign', ['class'=>'alert-success'], Icon::BSG, false),
                                [$terms['Url']])?>&nbsp;
                        <?= Html::a($terms['UnAgreed'].Icon::show('remove-sign', ['class'=>'alert-danger'],  Icon::BSG, false),
                                [$terms['Url']])?>
                    </div>
                </div>
                <div id="campaing-box-anatomies" class="campaign-box-container">
                    <div class="campaing-box-label"><?= Html::label(Yii::t('app', 'Anatomies').': ')?></div>
                    <div class="campaing-box-content">
                        <?= Html::a($anatomies['Updated'].Icon::show('ok-sign', ['class'=>'alert-success'], Icon::BSG, false),
                                [$anatomies['Url']])?>&nbsp;
                        <?= Html::a($anatomies['OutOfDate'].Icon::show('info-sign', ['class'=>'alert-warning'], Icon::BSG, false),
                                [$anatomies['Url']])?>&nbsp;
                        <?= Html::a($anatomies['Unknown'].Icon::show('remove-sign', ['class'=>'alert-danger'],  Icon::BSG, false),
                                [$anatomies['Url']])?>
                    </div>
                </div>
                <div id="campaing-box-hb1" class="campaign-box-container">
                    <div class="campaing-box-label"><?= Html::label(Yii::t('app', 'HB1').': ')?></div>
                    <div class="campaing-box-content">
                        <?= Html::a($hb1['Done'].Icon::show('ok-sign', ['class'=>'alert-success'], Icon::BSG, false),
                                [$hb1['Url']])?>&nbsp;
                        <?= Html::a($hb1['UnDone'].Icon::show('remove-sign', ['class'=>'alert-danger'],  Icon::BSG, false),
                                [$hb1['Url']])?>
                    </div>
                </div>
                <div id="campaing-box-consults" class="campaign-box-container">
                    <div class="campaing-box-label"><?= Html::label(Yii::t('app', 'Consults').': ')?></div>
                    <div class="campaing-box-content">
                        <?= Html::a($consults['Attended'].Icon::show('ok-sign', ['class'=>'alert-success'], Icon::BSG, false),
                                [$consults['Url']])?>&nbsp;
                        <?= Html::a($consults['NotAttended'].Icon::show('remove-sign', ['class'=>'alert-danger'],  Icon::BSG, false),
                                [$consults['Url']])?>
                    </div>
                </div>
                <div id="campaing-box-hb2" class="campaign-box-container">
                    <div class="campaing-box-label"><?= Html::label(Yii::t('app', 'HB2').': ')?></div>
                    <div class="campaing-box-content">
                        <?= Html::a($hb2['Done'].Icon::show('ok-sign', ['class'=>'alert-success'], Icon::BSG, false),
                                [$hb2['Url']])?>&nbsp;
                        <?= Html::a($hb2['UnDone'].Icon::show('remove-sign', ['class'=>'alert-danger'],  Icon::BSG, false),
                                [$hb2['Url']])?>
                    </div>
                </div>
                <div id="campaing-box-hb3" class="campaign-box-container">
                    <div class="campaing-box-label"><?= Html::label(Yii::t('app', 'HB3').': ')?></div>
                    <div class="campaing-box-content">
                        <?= Html::a($hb3['Done'].Icon::show('ok-sign', ['class'=>'alert-success'], Icon::BSG, false),
                                [$hb3['Url']])?>&nbsp;
                        <?= Html::a($hb3['UnDone'].Icon::show('remove-sign', ['class'=>'alert-danger'],  Icon::BSG, false),
                                [$hb3['Url']])?>
                    </div>
                </div>
               <!-- <div id="campaing-box-progress" class="campaign-box-container">
                    <?= yii\bootstrap\Progress::widget([
                        'percent' => 27,
                        'label' => 'Day: 27/100',
                        'options'=>['id'=>'campaing-box-progress-bar',
                            'class' => 'active progress-striped'],
                        'barOptions' => ['class' => 'progress-bar-success']
                    ]);?>
                </div> -->
            </div>
        <?php }?>
            <div class="campaign-box col-lg-2" id="newCampaignBox">
                <?= Html::button(Icon::show('plus',[], Icon::BSG).
                    yii::t('app', 'New Campaign'), 
                    ['value' => Url::to(['campaign/create']),
                        'id'=>'newCampaign',
                        'class'=>'btn btn-success',
                        'for'=>'#teste'
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
