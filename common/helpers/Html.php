<?php

namespace common\helpers;

use yii\bootstrap5\Html as HelpersHtml;

class Html
{
    /**
     * get Channel link 
     * get html a tag 
     * @param \common\models\User $user 
     * @return string 
     */
    public static function channelLink(\common\models\User $user)
    {
        return HelpersHtml::a($user->username, [
            '/channel/view', 'username' => $user->username
        ], ['class' => 'text-dark']);
    }
}
