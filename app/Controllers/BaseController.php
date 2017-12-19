<?php

namespace App\Controllers;

use App\Models\ForumUser;
use Phalcon\Mvc\Controller;

class BaseController extends Controller {
    public $user;

    public function onConstruct()
    {
        //$this->user = $this->session->get('user') ?: ForumUser::findFirst('id = 11 AND status = 1')->toArray();
        $this->user = $this->session->get('user');
        $this->view->local_user = $this->user;
        $this->view->verify_title = $this->commonConfig->verify_title->toArray();
    }

    /**
     * 登陆成功设置session，跳转到指定页面
     * @param $user
     */
    public function authSuccess($user) {
        $this->session->set('user', $user);
        $url = $this->session->get('redirectUrl');
        $this->response->redirect($url, true);
    }

    /**
     * 初始化方法
     */
    public function initialize() {

    }

    /**
     * 显示模板
     *
     * @param null $path
     * @param null $params
     */
    public function display($path = null, $params = null) {
        $params = array_merge([], (array)$this->view->getParamsToView(), (array)$params);
        $this->view->setVars($params);
        if($path != null && $path != '') {
            $content = $this->simpleView()->render(trim($path, '/'), $params);
            $layout  = $this->view->getLayout();
            if($layout == '') {
                echo $content;
                exit();
            } else {
                $this->view->setContent($content);
            }
        }
        $this->view->render($this->dispatcher->getControllerName(), $this->dispatcher->getActionName(), $this->view->getParams());
    }
}
