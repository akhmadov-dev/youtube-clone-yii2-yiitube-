<?php

namespace common\helpers;

use yii\bootstrap5\Html as HelpersHtml;

class Html
{
    /**
     * get Channel link 
     * get html a tag 
     * @param \common\models\User $user 
     * @param bool $schema
     * @return string 
     */
    public static function channelLink(\common\models\User $user, bool $schema = false)
    {
        return HelpersHtml::a($user->username, [
            \yii\helpers\Url::to(['/channel/view', 'username' => $user->username], $schema)
        ], ['class' => 'text-dark']);
    }
}
