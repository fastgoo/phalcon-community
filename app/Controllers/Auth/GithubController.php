<?php
/**
 * Created by PhpStorm.
 * User: Mr.Zhou
 * Date: 2017/12/5
 * Time: 下午10:27
 */

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use League\OAuth2\Client\Provider\Github;

class GithubController extends BaseController
{
    private $githubProvider;

    public function onConstruct()
    {
        $this->githubProvider = new Github($this->commonConfig->github->toArray());
    }

    /**
     * 跳转到github授权页面
     */
    public function authAction()
    {
        $authUrl = $this->githubProvider->getAuthorizationUrl();
        $this->response->redirect($authUrl, true);
    }

    /**
     * github授权成功回调地址
     */
    public function callbackAction()
    {
        $code = $this->request->get('code');
        $state = $this->request->get('state');

        if (!$code) {
            $this->authAction();
            return;
        }
        if (!$state) {
            exit('授权认证失败');
        }

        $token = $this->githubProvider->getAccessToken('authorization_code', ['code' => $code]);
        try {
            $user = $this->githubProvider->getResourceOwner($token);
            printf('Hello %s!', $user->getNickname());

        } catch (Exception $e) {
            exit('授权认证失败');
        }
        echo $token->getToken();
    }

}