<?php

namespace App\Controllers;

use Phalcon\Mvc\Controller;

class BaseController extends Controller
{

    public function onConstruct()
    {
        $this->session->set('user', [
            'nickname' => '贤心',
            'is_verify' => '1',
            'vip' => 3,
            'head_img' => 'https://tva1.sinaimg.cn/crop.0.0.118.118.180/5db11ff4gw1e77d3nqrv8j203b03cweg.jpg',
            'title' => 'VIP3'
        ]);
        $this->session->remove('user');
        $this->view->local_user = $this->session->get('user');
    }

    /**
     * 初始化方法
     */
    public function initialize()
    {
        $this->view->local_user = $this->session->get('user');
    }

}
