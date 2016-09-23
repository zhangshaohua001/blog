<?php
/**
 * Created by PhpStorm.
 * User: smile
 * Date: 16-9-23
 * Time: 上午10:19
 */

namespace app\controllers;


class IndexController extends BaseController
{
    
    public function actionIndex()
    {
        return $this->renderPartial('index');
    }

    /**
     * @return string
     * 系统主页面
     */
    public function actionMain()
    {
        return $this->render('main');
    }

    /**
     * @return string
     * 系统基本信息
     */
    public function actionBasic()
    {
        return $this->render('basic');
    }
}