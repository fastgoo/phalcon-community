<?php
/**
 * Created by PhpStorm.
 * User: yong
 * Date: 2017/12/15
 * Time: 下午2:52
 */

namespace App\Controllers\User;

use App\Controllers\BaseController;

class MemberController extends BaseController
{
    public function initialize()
    {

    }

   /**
    * 用户个人中心主页
    */
    public function indexAction(){


        $this->view->render("user", "index");


    }
    /**
     * 用户设置
     */
    public function setAction(){

        $this->view->render("user", "set");
    
    }
    /**
     * 消息中心
     */
    public function messageAction(){

        $this->view->render("user", "message");

    }
    /**
     * 我的首页
     */
    public function homeAction(){

        $this->view->render("user", "home");

    }
}