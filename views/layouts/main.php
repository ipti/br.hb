<?php

use yii\helpers\Html;
use yii\bootstrap\NavBar;
use kartik\icons\Icon;
use app\assets\AppAsset;
use app\models\campaign;

$request = Yii::$app->request;
//$campaign_id = $request->get('cid');
$campaign_id = empty($request->get('cid'))? $request->get('c') : $request->get('cid');
$campaign;
if(isset($campaign_id)){
    $campaign = campaign::find()->where("id = :cid", ['cid' => $campaign_id])->one();
}

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title>HB - <?= Html::encode($this->title) ?></title>
        <link href='http://fonts.googleapis.com/css?family=Lato:400,700,900' rel='stylesheet' type='text/css'>
        <?php $this->head() ?>
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    </head>
    <body>

        <?php $this->beginBody() ?>
        <div class="navbar">
            <?php
            NavBar::begin([
                'brandLabel' => '<img src="images/logo-85.png" width="50" class="img-responsive">',
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-default',
                ],
            ]);
            ?>
            <div class="pull-left">
            <?php
            echo '<h3 style="margin-bottom: 5px;">' . Html::encode($this->title) . '</h3>';
            if(isset($campaign)){ echo '<h6 style="margin-top: 0;">' . Html::encode($campaign->name) . '</h6>';}
            ?>
            </div>
            <?php
            echo "<div class='pull-right'>";

            echo Html::a(Icon::show('user',[], Icon::BSG).yii::t('app', 'Students'), ['/child/index'], ['class' => 'btn btn-primary navbar-btn']);
            echo Html::a(Icon::show('cloud',[], Icon::BSG).yii::t('app', 'Health Report'), ['/reports/health'], ['class' => 'btn btn-info navbar-btn']);

            if (isset($this->params['button'])){
                echo $this->params['button'];
            }

            if(!isset($this->params['siteIndex'])){
                echo Html::a(Icon::show('heartbeat',[], Icon::FA).yii::t('app', 'Campaigns'),['/site/index'],
                    ['class' => 'btn btn-warning navbar-btn']);
            }
            echo Yii::$app->user->isGuest 
                    ? Html::a(Icon::show('sign-in',[], Icon::FA).yii::t('app', 'Login'), ['/site/login'], ['class' => 'btn btn-info navbar-btn']) 
                    : Html::a(Icon::show('sign-out',[], Icon::FA).yii::t('app', 'Logout'), ['/site/logout'], ['class' => 'btn btn-danger navbar-btn', 'data-method' => "post"]);
            echo "</div>";
            NavBar::end();
            ?>

        </div>
        <div class="container">
            <?= $content ?>
        </div>

        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage();
yii\helpers\Url::remember();?>
