<?php

namespace App\Controllers;

use Phalcon\Mvc\Controller;

class BaseController extends Controller
{

    public function onConstruct()
    {
        $this->view->local_user = $this->session->get('user');
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
