<?php

use yii\helpers\Url;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/**
 * @var $this 
 * @var $channel \common\models\User 
 */
?>

<div class="jumbotron">
  <h1 class="display-4"><?php echo $channel->username ?></h1>
  <p></p>
  <hr class="my-4">
    <?php Pjax::begin() ?>
    <?php  echo $this->render('_subscribe', [
        'channel' => $channel
    ]) ?>
    <?php Pjax::end() ?>
</div>

<?php  echo ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => '@frontend/views/video/_video_item',
    'layout' => '<div class="d-flex flex-wrap">{items}</div>{pager}',
    'itemOptions' => [
        'tag' => false
    ]
]) ?>