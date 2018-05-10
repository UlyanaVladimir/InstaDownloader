<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Html;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use frontend\models\InstaForm;
use frontend\models\InstaTagForm;
use frontend\models\InstaUrlForm;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
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
     * @inheritdoc
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
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
    
    /**
     * Displays header manager.
     *
     * @return mixed
     */
    public function actionInsta()
    {
        $form = new InstaForm();

        if($form->load(Yii::$app->request->post()) && $form->validate()){
            $insta_name = Html::encode($form->insta_name);
            $insta_result = $form->instaResult($insta_name);
            $insta_username = $form->getUsername($insta_result);
            $insta_avatar = $form->getAvatar($insta_result);
            $insta_posts = $form->getPosts($insta_result);
            $insta_followers = $form->getFollowers($insta_result);
            $insta_following = $form->getFollowing($insta_result);
            $insta_fullname = $form->getFullname($insta_result);
            $insta_biography = $form->getBiography($insta_result);
            $insta_photo = $form->getPhoto($insta_result);
        }
        else{
            $insta_name = '';
            $insta_result = '';
            $insta_username = '';
            $insta_avatar = '';
            $insta_posts = '';
            $insta_followers = '';
            $insta_following = '';
            $insta_fullname = '';
            $insta_biography = '';
            $insta_photo = '';
        }
        return $this->render('insta',
            ['form' => $form,
             'insta_name' => $insta_name,
             'insta_result' => $insta_result,
             'insta_username' => $insta_username,
             'insta_avatar' => $insta_avatar,
             'insta_posts' => $insta_posts,
             'insta_followers' => $insta_followers,
             'insta_following' => $insta_following,
             'insta_fullname' => $insta_fullname,
             'insta_biography' => $insta_biography,
             'insta_photo' => $insta_photo,]
         );
    }


    public function actionInstatag()
    {
        $form = new InstaTagForm();

        if($form->load(Yii::$app->request->post()) && $form->validate()){
            $insta_tag = Html::encode($form->insta_tag);
            $insta_result = $form->instaResult($insta_tag);
            $insta_photo = $form->getPhoto($insta_result);
        }
        else{
            $insta_tag = '';
            $insta_result = '';
            $insta_photo = '';
        }
        return $this->render('instatag',
            ['form' => $form,
             'insta_tag' => $insta_tag,
             'insta_result' => $insta_result,
             'insta_photo' => $insta_photo,]
         );
    }

    public function actionInstaurl()
    {
        $form = new InstaUrlForm();

        if($form->load(Yii::$app->request->post()) && $form->validate()){
            $insta_url = Html::encode($form->insta_url);
            $insta_result = $form->instaResult($insta_url);
            $insta_photo = $form->getPhoto($insta_result);
        }
        else{
            $insta_url = '';
            $insta_result = '';
            $insta_photo = '';
        }
        return $this->render('instaurl',
            ['form' => $form,
             'insta_url' => $insta_url,
             'insta_result' => $insta_result,
             'insta_photo' => $insta_photo,]
         );
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
