<?php

namespace App\Controllers;

use Phalcon\Mvc\Controller;

class BaseController extends Controller
{
    public $user;

    public function onConstruct()
    {
        $this->user = $this->session->get('user');
        $this->view->local_user = $this->user;
    }

    /**
     * 登陆成功设置session，跳转到指定页面
     * @param $user
     */
    public function authSuccess($user)
    {
        $this->session->set('user', $user);
        $url = $this->session->get('redirectUrl');
        $this->response->redirect($url, true);
    }

    /**
     * 初始化方法
     */
    public function initialize()
    {

    }

}
