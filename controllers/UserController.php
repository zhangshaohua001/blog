<?php
/**
 * Created by PhpStorm.
 * User: smile
 * Date: 16-9-23
 * Time: 下午4:53
 */

namespace app\controllers;

use Yii;
use app\models\sys\User;
use app\components\Tools;
use app\components\library\ShowMessage;
use yii\helpers\Url;
class UserController extends BaseController
{
    public $enableCsrfValidation = false;

    public function actionIndex()
    {
        $params = Yii::$app->request->queryParams;
        $dataProvider = User::search($params);
        return $this->render('index',[
            'dataProvider' => $dataProvider,
            'params' => $params,
        ]);
    }
    public function actionView($id)
    {
        $id = Tools::sysAuth($id,'DECODE');
        return $this->render('view', [
            'model' => User::findOne($id),
        ]);
    }
    public function actionCreate()
    {
        $model =  new User();
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            if($model->load($post) && $model->save()){
                ShowMessage::info('添加成功', '', Url::toRoute(['/user/index']), 'edit');
            }
        }
        return $this->render('create',[
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $id = Tools::sysAuth($id,'DECODE');
        if(!is_numeric($id)){
            ShowMessage::info('找不到该用户', '', Url::toRoute(['/user/index']), 'edit');
        }
        $model = User::findOne($id);
        if(empty($model)){
            ShowMessage::info('找不到该用户', '', Url::toRoute(['/user/index']), 'edit');
        }
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            if($model->load($post) && $model->save()){
                ShowMessage::info('修改成功', '',Url::toRoute(['/user/index']),'edit');
            }
        }
        return $this->render('update',[
            'model'=>$model,
        ]);
    }
    public function actionDelete($id)
    {
        $id = Tools::sysAuth($id,'DECODE');

        if(!is_numeric($id)){
            ShowMessage::info('找不到该用户', '', Url::toRoute(['/user/index']), 'edit');
        }
        User::findOne($id)->delete();
        ShowMessage::info('删除成功', '', Url::toRoute(['/user/index']), 'edit');
    }
}