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
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>

<?php $this->beginBody() ?>
    <div class="wrap navbar-">
        <?php
            NavBar::begin([
                'brandLabel' => 'HB',
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-default navbar-fixed-top',
                ],
            ]);
            echo NavX::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => [
                    ['label' => yii::t('app', 'Campaign'), 'url' => ['/Campaign']],
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
                        ['label' => yii::t('app', 'Logout'). ' (' . Yii::$app->user->identity->username . ')',
                            'url' => ['/site/logout'],
                            'linkOptions' => ['data-method' => 'post']],
                ],
            ]);
            NavBar::end();
        ?>

        <div class="container">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
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
