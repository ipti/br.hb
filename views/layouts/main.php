<?php
use yii\helpers\Html;
use kartik\nav\NavX;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

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
    
<?php //  var_dump($this->context->id); exit(); ?>

    <div class="navbar">
        <?php
            NavBar::begin([
                'brandLabel' => '<img src="images/logo-85.png" width="50" class="img-responsive">',
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-default',
                ],
            ]);
            echo '<h1 class="navbar-text">' . Html::encode($this->title) . '</h1>';
            echo NavX::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => [
                    ['label' => yii::t('app', 'HB'),
                        'items' => [
                            ['label' => yii::t('app', 'Student'), 'url' => ['/student']],
                            ['label' => yii::t('app', 'Term'), 'url' => ['/term']],
                            ['label' => yii::t('app', 'Anatomy'), 'url' => ['/anatomy']],
                            ['label' => yii::t('app', 'Hemoglobin'), 'url' => ['/hemoglobin']],
                            ['label' => yii::t('app', 'Consultation'), 'url' => ['/consultation']],
                        ],
                    ],
                    Yii::$app->user->isGuest ?
                        ['label' => yii::t('app', 'Login'), 'url' => ['/site/login']] :
                        ['label' => yii::t('app', 'Logout'),
                            'url' => ['/site/logout'],
                            'linkOptions' => ['data-method' => 'post']],
                ],
            ]);
            NavBar::end();
        ?>

        <div class="container">
            <?= $content ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <p class="pull-left">&copy; IPTI <?= date('Y') ?></p>
            <p class="pull-right"><?= Yii::powered() ?></p>
        </div>
    </footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
