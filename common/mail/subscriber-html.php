<?php

/** @var \common\models\User $channel */
/** @var \common\models\User $user */
?>

<p>Hello <?= $channel->username ?></p>
<p>User <?= \common\helpers\Html::channelLink($user, true) ?> has subscribed to you</p>

<p>Akhmadov Dev</p>