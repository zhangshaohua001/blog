<?php
/**
 * Created by PhpStorm.
 * User: smile
 * Date: 16-9-23
 * Time: 上午10:20
 */

namespace app\controllers;


use yii\web\Controller;
use app\components\checkcode\Checkcode;
use Yii;
use yii\helpers\Url;
use app\components\library\ShowMessage;
use app\models\sys\User;
use app\components\Filter;
class LoginController extends Controller
{
    public function actionIndex()
    {
        return $this->renderPartial('index');
    }
    /**
     *显示验证码
     */
    public function actionCheckcode()
    {
        $checkcode = new Checkcode();
        $session = Yii::$app->session;
        $session->set('code', $checkcode->get_code());
        $checkcode->doimage();
    }

    public function actionLogin()
    {
        if(Yii::$app->request->isPost){
            $username = Yii::$app->request->post('username');
            $password = Yii::$app->request->post('password');
            $verifyCode = Yii::$app->request->post('verifyCode');
            $code = Yii::$app->session->get('code');
            $loginUrl = Url::toRoute('/login');
            if(empty($verifyCode) || strtolower($verifyCode) != $code){
                ShowMessage::info("验证码为空或不正确", $loginUrl);
            }
            if(empty($username) || empty($password)){
                ShowMessage::info("用户名或密码不能为空", $loginUrl);
            }
            $userModel = User::findOneByUsername(Filter::filterVal($username));
            if(empty($userModel)){
                ShowMessage::info("用户名不存在", $loginUrl);
            }
            if($password != $userModel->password){
                ShowMessage::info("密码错误", $loginUrl);
            }
            if($userModel->status == USER_STATUS_NO){
                ShowMessage::info("用户被禁用",$loginUrl);
            }
            Yii::$app->session->set('userId',$userModel->id);
            Yii::$app->session->set('username',$userModel->username);
            $userModel->lastTime = time();
            $userModel->lastIp = Yii::$app->request->getUserIP();
            if($userModel->save()){
                return $this->redirect('/');
            }else{
                ShowMessage::info("登陆失败",$loginUrl);
            }
        }
    }

    public function actionLogout()
    {
        Yii::$app->session->removeAll();
        return $this->redirect(Url::toRoute('/login'));
    }

}