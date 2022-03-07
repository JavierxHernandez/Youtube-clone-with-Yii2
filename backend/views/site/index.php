<?php

/* @var $this yii\web\View */
/**
 * @var $latestVideo \common\models\Video
 * @var $numberOfView \common\models\VideoView
 * @var $numberOfSubscribers \common\models\User
 * @var $subscribers \common\models\Subscriber
 */

use yii\helpers\Url;

$this->title = 'My Yii Application';
?>

<div class="site-index d-flex">

    <?php if ($latestVideo): ?>
    <div class="card mr-3" style="width: 14rem;">
        <video class="embed-responsive-item"
            poster="<?php echo $latestVideo->getThumbnailLink() ?>"
            src="<?php echo $latestVideo->getVideoLink() ?>">
        </video>
        <div class="card-body">
            <h5 class="card-title"><?php echo $latestVideo->title ?></h5>
            <p class="card-text">Likes: <?php echo $latestVideo->getLikes()->count() ?></p>
            <p class="card-text">Views: <?php echo $latestVideo->getViews()->count() ?></p>
            <a href="<?php echo Url::to(['/video/update', 'video_id' => $latestVideo->video_id]) ?>" class="btn btn-primary">Edit</a>
        </div>
    </div>
    <?php else: ?>
            <div class="card-body">
                You don't have uploaded videos yet
            </div>
    <?php endif; ?>

    <div class="card mr-3" style="width: 14rem;">
        <div class="card-body">
            <h5 class="card-title">Total Views</h5>
            <p class="card-text" style="font-size: 48px">Total: <?php echo $numberOfView ?></p>
        </div>
    </div>

    <div class="card mr-3" style="width: 14rem;">
        <div class="card-body">
            <h5 class="card-title">Total of Subscribers</h5>
            <p class="card-text" style="font-size: 48px">Total: <?php echo $numberOfSubscribers ?></p>
        </div>
    </div>

    <div class="card mr-3" style="width: 14rem;">
        <div class="card-body">
            <h5 class="card-title">Lastest Subscribers</h5>
            <?php foreach ($subscribers as $subscriber) : ?>
                <?php echo $subscriber->user->username ?>
            
            <?php endforeach ?>
            

        </div>
    </div>
</div>

