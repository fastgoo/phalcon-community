<?php
/**
 * Created by PhpStorm.
 * User: Mr.Zhou
 * Date: 2017/12/5
 * Time: 下午10:27
 */

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Services\AuthService;
use Overtrue\Socialite\SocialiteManager;

class GithubController extends BaseController
{
    private $socialite;

    public function onConstruct()
    {
        $this->socialite = new SocialiteManager($this->commonConfig->socialite->toArray());
    }

    /**
     * 跳转到github授权页面
     */
    public function authAction()
    {
        $url = $this->request->get('redirectUrl');
        $this->session->set('redirectUrl', $url);
        $response = $this->socialite->driver('github')->redirect();
        $response->send();
    }

    /**
     * github授权成功回调地址
     */
    public function callbackAction()
    {
        $user = $this->socialite->driver('github')->user();
        $authUser = [
            'auth_id' => (string)$user['id'],
            'nickname' => $user['nickname'],
            'head_img' => $user['avatar'],
            'auth_type' => 1,
        ];
        $authService = new AuthService();
        $res = $authService->register($authUser);
        if ($res) {
            $this->authSuccess($res);
        } else {
            exit("登陆失败");
        }
    }

}