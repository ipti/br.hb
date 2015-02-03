<?php
use yii\bootstrap\Modal;
use \kartik\helpers\Html;
use \yii\helpers\Url;

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
            <div class="col-lg-4">
                <label id="teste"></label>
                
                <?= Html::button(
                    yii::t('app', 'New Campaign'), 
                    ['value' => Url::to(['campaign/create']),
                        'id'=>'newCampaign',
                        'class'=>'btn btn-primary',
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
