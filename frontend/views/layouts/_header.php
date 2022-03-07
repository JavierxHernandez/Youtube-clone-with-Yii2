<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\NavBar;
use yii\bootstrap4\Nav;
use yii\helpers\Url;

NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar navbar-expand-lg navbar-light bg-light shadow-sm',
        ],
    ]);
    $menuItems = [
        // ['label' => 'Create', 'url' => ['/video/create']],
    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
        $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
    } else {
        $menuItems[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post', ['class' => 'form-inline'])
            . Html::submitButton(
                'Logout (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>';
    }
?>

    <form action="<?php echo Url::to(['/video/search']) ?>" class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="search" placeholder="Search"
      name="keyword" value="<?php echo Yii::$app->request->get('keyword')?>">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>

<?php
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav ml-auto'],
        'items' => $menuItems,
    ]);
    NavBar::end();
?>
