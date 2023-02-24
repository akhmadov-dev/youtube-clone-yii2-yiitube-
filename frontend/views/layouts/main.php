<?php

/** @var yii\web\View $this */

/** @var string $content */

use common\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;

$this->beginContent('@frontend/views/layouts/base.php');
?>

<!--main-->
<main role="main" class="d-flex">
    <!--sidebar-->
    <?= $this->render('_sidebar') ?>
    <!--/sidebar-->

    <div class="content-wrapper p-3">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>
<!--/main-->

<?php $this->endContent() ?>

