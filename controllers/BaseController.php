<?php
/**
 * Created by PhpStorm.
 * User: smile
 * Date: 16-9-23
 * Time: 上午9:48
 */

namespace app\controllers;

use yii\web\Controller;
use Yii;
use yii\helpers\Url;
class BaseController extends Controller
{
    public $userId;
    public $realName;
    public function init()
    {
        parent::init();
        $loginUrl = Url::toRoute('/login/index');
        $this->userId = Yii::$app->session->get('userId');
        $this->realName = Yii::$app->session->get('realName');

        if(!$this->userId){
            return $this->redirect($loginUrl);
        }
    }
}