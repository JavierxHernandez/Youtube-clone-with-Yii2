<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

?>

<div class="row">
    <div class="col-sm-8">
        <video class="embed-responsive embed-responsive-16by9"
        poster="<?php echo $model->getThumbnailLink() ?>"
        src="<?php echo $model->getVideoLink() ?>" controls>
        </video>
        <h6 class="mt-3"><?php echo $model->title ?></h6>
        <div class="d-flex justify-content-between align-items-center ">
            <div>
                <?php echo $model->getViews()->count() ?> views . <?php echo Yii::$app->formatter->asDate($model->created_at) ?>
            </div>
            <div>
                <?php Pjax::begin() ?>
                <?php echo $this->render('_buttons', [
                        'model' => $model
                        ]) ?>
                <?php Pjax::end() ?>
            </div>  
        </div>
        <div>
            <p>
                <?php echo \common\helpers\Html::channelLink($model->createdBy) ?>
            </p>
            <p><?php echo Html::encode($model->description) ?></p>
        </div>
    </div>
    <div class="col-sm-4">
                    <?php  foreach ($similarVideos as $similarVideo): ?>
                        <a href="<?php echo Url::to(['/video/view', 'id' => $similarVideo->video_id]) ?>">
                            <div class="media mb-2">
                                <video class="embed-responsive embed-responsive-16by9 mr-2" style="width: 200px;"
                                poster="<?php echo $similarVideo->getThumbnailLink() ?>"
                                src="<?php echo $similarVideo->getVideoLink() ?>">
                                </video>
                                <div class="media-body">
                                    <h5 class="mt-0"><?php echo $similarVideo->title ?></h5>
                                    <p class="m-0">
                                        <?php echo \common\helpers\Html::channelLink($similarVideo->createdBy) ?>
                                    </p>
                                    <p class="m-0"><?php echo $similarVideo->getViews()->count() ?> views . <?php echo Yii::$app->formatter->asRelativeTime($model->created_at) ?></p>
                                </div>
                            </div>
                        </a>
                        
                    <?php endforeach; ?>
    </div>
</div>