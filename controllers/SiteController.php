<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\UserImage;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Approve image.
     *
     * @return string
     */
    public function actionApprove()
    {   
        $UserImageModel = new UserImage();
        $imageId = Yii::$app->request->get()['id'];
        $UserImageModel->updateImagesStatus($imageId,'Approve');
        //$userId = Yii::$app->session['user']->Id ;
        $dataProvider = $UserImageModel->findImagesByUserID();
        return $this->render('moderator', [
            'dataProvider' => $dataProvider
            ]);
        
    }

    /**
     * Reject image.
     *
     * @return string
     */
    public function actionReject()
    {
        $UserImageModel = new UserImage();
        $imageId = Yii::$app->request->get()['id'];
        $UserImageModel->updateImagesStatus($imageId,'Reject');
        //$userId = Yii::$app->session['user']->Id ;
        $dataProvider = $UserImageModel->findImagesByUserID();
        return $this->render('moderator', [
            'dataProvider' => $dataProvider
            ]);
        
    }


    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $user = $model->login();
            Yii::$app->session->set('user',$user);
            $UserImageModel = new UserImage();
            if($user->type === "Uploader"){
                //uploader
                $dataProvider = $UserImageModel->findImagesByUserID($user->Id);
                return $this->render('uploader', [
                    'dataProvider' => $dataProvider,
                    ]);
            } else {
                //moderator
                $dataProvider = $UserImageModel->findImagesByUserID();
                return $this->render('moderator', [
                    'dataProvider' => $dataProvider,
                    ]);

            }
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
