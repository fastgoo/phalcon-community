<?php
/**
 * Created by PhpStorm.
 * User: Mr.Zhou
 * Date: 2017/12/6
 * Time: 上午11:17
 */

namespace App\Controllers\Auth;

use App\Controllers\BaseController;

class LoginOutController extends BaseController
{
    public function indexAction()
    {
        $url = $this->request->get('redirectUrl');
        $this->session->remove('user');
        $this->response->redirect($url, true);
    }


}