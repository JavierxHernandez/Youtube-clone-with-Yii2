<?php 
/* @var $model common\models\Video */

use yii\helpers\StringHelper;
?>

<div class="media">
    <a href="<?php echo  'update/'.$model->video_id ?>">
        <video class="embed-responsive embed-responsive-16by9 mr-2"
            style="width: 120px"
            poster="<?php echo $model->getThumbnailLink(); ?>"
            src="<?php echo $model->getVideoLink(); ?>">
            </video>
        </a>
        <div class="media-body">
            <h6 class="mt-0"><?php echo $model->title ?></h6>
                <?php echo StringHelper::truncateWords($model->description, 10)?>
        </div>
</div>