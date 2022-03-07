<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Video */

$this->title = 'Create Video';
$this->params['breadcrumbs'][] = ['label' => 'Videos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="video-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin([
                'options' => ['enctype' => 'multipart/form-data']
            ]) ?>

    <div class="d-flex flex-column justify-content-center align-items-center">
        <div class="upload-icon">
            <i class="fas fa-upload"></i>
        </div>
        <br>
            <p class="m-0">Drag and drop video files to upload them.</p>
            <p class="text-muted">Your videos will be private until you publish them.</p>
            
            <?php echo $form->errorSummary($model) ?>

                <button class="btn btn-primary btn-file">
                    Select File
                    <input type="file" id="videoFile" name="video">
                </button>

                <?php ActiveForm::end() ?>
    </div>

</div>
