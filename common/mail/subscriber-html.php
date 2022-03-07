<?php

use common\helpers\Html as HelpersHtml;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */
/* @var $channel common\models\User */

?>

<p>Hello <?php echo $channel->username ?></p>
<p>user <?php echo \common\helpers\Html::channelLink($user, true) ?> has subscribed to you</p>

<p>FreeCodeTube team</p>
