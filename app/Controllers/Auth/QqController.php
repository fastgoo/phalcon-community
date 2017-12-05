<?php
/**
 * Created by PhpStorm.
 * User: Mr.Zhou
 * Date: 2017/12/5
 * Time: 下午10:27
 */

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use Overtrue\Socialite\SocialiteManager;

class QqController extends BaseController
{
    private $socialite;

    public function onConstruct()
    {
        $this->socialite = new SocialiteManager(['qq' => $this->commonConfig->qq->toArray()]);
    }

    /**
     * 跳转到github授权页面
     */
    public function authAction()
    {
        $response = $this->socialite->driver('qq')->redirect();
        $response->send();
    }

    /**
     * github授权成功回调地址
     */
    public function callbackAction()
    {
        $user = $this->socialite->driver('qq')->user();
        var_dump($user);
    }

}