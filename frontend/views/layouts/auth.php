<?php
/** @var yii\web\View $this */

/** @var string $content */

use common\widgets\Alert;

$this->beginContent('@frontend/views/layouts/base.php');
?>
    <main role="main" class="d-flex">
        <div class="container">
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
    </main>

<?php $this->endContent() ?>