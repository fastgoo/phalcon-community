<?php

namespace App\Controllers;

use App\Models\ForumUser;
use Phalcon\Mvc\Controller;

class BaseController extends Controller
{
    public $user;

    public function onConstruct()
    {
        $this->user = $this->session->get('user') ?: ForumUser::findFirst('id = 11 AND status = 1')->toArray();
        //$this->user = $this->session->get('user');
        $this->view->local_user = $this->user;
        $this->view->verify_title = $this->commonConfig->verify_title->toArray();
        $this->view->login_type = json_encode($this->commonConfig->login_type->toArray());
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
