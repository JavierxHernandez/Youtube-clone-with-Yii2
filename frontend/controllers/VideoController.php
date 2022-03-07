<?php

namespace frontend\controllers;

use common\models\Video;
use common\models\VideoLike;
use common\models\VideoView;
use Yii;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

class VideoController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['like', 'dislike', 'history'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'like' => ['post'],
                    'dislike' => ['post'],
                ],
            ],
        ];
    }
    public function actionIndex()
    {

        $dataProvider = new ActiveDataProvider([
            'query' => Video::find()->with('createdBy')->published()->latest(),
            'pagination' => [
                'pageSize' => 12
            ]
        ]);
        
        return $this->render('index', [
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionView()
    {
        $this->layout = 'auth';

        $video = $this->findVideo();
        $videoView = new VideoView();
        $videoView->video_id = $video->video_id;
        $videoView->user_id = Yii::$app->user->id;
        $videoView->created_at = time();
        $videoView->save();

        $similarVideos = Video::find()
                        ->published()
                        ->andWhere(['NOT', ['video_id' => $video->video_id]])
                        ->byKeyword($video->title)
                        ->limit(10)
                        ->all();

        return $this->render( 'view', [
            'model' => $video,
            'similarVideos' => $similarVideos,
        ]);
    }

    public function actionLike()
    {
        $video = $this->findVideo();
        $userId = Yii::$app->user->id;
        $videoId = $video->video_id;

        $videoLikeDislike = VideoLike::find()
        ->userIdVideoId($userId, $videoId)
        ->one();

        if (! $videoLikeDislike) {
            $this->saveLikeDislike($userId, $videoId, VideoLike::TYPE_LIKE);
        } elseif ($videoLikeDislike->type == VideoLike::TYPE_LIKE) {
            $videoLikeDislike->delete();
        } else {
            $videoLikeDislike->delete();
            $this->saveLikeDislike($userId, $videoId, VideoLike::TYPE_LIKE);
        }
        return $this->renderPartial('_buttons', [
            'model' => $video
        ]);
    }
    public function actionDislike()
    {
        $video = $this->findVideo();
        $userId = Yii::$app->user->id;
        $videoId = $video->video_id;

        $videoLikeDislike = VideoLike::find()
        ->userIdVideoId($userId, $videoId)
        ->one();

        if (! $videoLikeDislike) {
            $this->saveLikeDislike($userId, $videoId, VideoLike::TYPE_DISLIKE);
        } elseif ($videoLikeDislike->type == VideoLike::TYPE_DISLIKE) {
            $videoLikeDislike->delete();
        } else {
            $videoLikeDislike->delete();
            $this->saveLikeDislike($userId, $videoId, VideoLike::TYPE_DISLIKE);
        }
        return $this->renderPartial('_buttons', [
            'model' => $video
        ]);
    }
    
    protected function saveLikeDislike($userId, $videoId, $type)
    {
        $videoLikeDislike = new VideoLike();
        $videoLikeDislike->video_id = $videoId;
        $videoLikeDislike->user_id = $userId;
        $videoLikeDislike->type = $type;
        $videoLikeDislike->created_at = time();
        $videoLikeDislike->save();
    }

    public function actionSearch($keyword)
    {

        $query = Video::find()
        ->with('createdBy')
        ->published()
        ->latest();

        if ($keyword) {
            $query->byKeyword($keyword)
            ->orderBy("MATCH(title, description, tags) AGAINST ('$keyword') DESC");
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);

        return $this->render('search', [
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionHistory()
    {
        $query = Video::find()
        ->alias('v')
        ->innerJoin( "(SELECT video_id, MAX(created_at) as max_date FROM video_view
                        WHERE user_id = :userId
                        GROUP BY video_id) vv", 'vv.video_id = v.video_id', [
                            'userId' => Yii::$app->user->id
                        ])
                        ->orderBy("vv.max_date DESC");

        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);

        return $this->render('history', [
            'dataProvider' => $dataProvider
        ]);
    }

    protected function findVideo()
    {
        $video_id = Yii::$app->request->get();
        $video = Video::findOne($video_id['id']);
        if (! $video) {
           throw new NotFoundHttpException("video does not exit");
        }

        return $video;
    }
}
