<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

?>

<header>
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar navbar-expand-lg bg-body-tertiary shadow-sm',
        ]
    ]);
    $menuItems = [
        // ['label' => 'Create', 'url' => ['/video/create']],
    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
        $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
    }
    ?>

    <form class="d-flex" role="search" action="<?= \yii\helpers\Url::to(['video/search']) ?>">
        <input class="form-control me-2" name="keyword" type="search" placeholder="Search" aria-label="Search" value="<?= \Yii::$app->request->get('keyword') ?>">
        <button class="btn btn-outline-success" type="submit">Search</button>
    </form>

    <?php
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav me-auto mb-2 mb-md-0'],
        'items' => $menuItems,
    ]);
    if (Yii::$app->user->isGuest) {
        echo Html::tag('div', Html::a('Login', ['/site/login'], ['class' => ['btn btn-link login text-decoration-none']]), ['class' => ['d-flex']]);
    } else {
        echo Html::beginForm(['/site/logout'], 'post', ['class' => 'd-flex'])
            . Html::submitButton(
                'Logout (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link logout text-decoration-none']
            )
            . Html::endForm();
    }

    NavBar::end();
    ?>
</header>