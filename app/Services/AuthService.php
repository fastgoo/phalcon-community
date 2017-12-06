<?php
/**
 * Created by PhpStorm.
 * User: Mr.Zhou
 * Date: 2017/12/6
 * Time: 上午9:50
 */

namespace App\Services;

use App\Models\ForumUser;
use Phalcon\Di;


class AuthService
{
    private $di;

    public function __construct()
    {
        $this->di = Di::getDefault();
    }

    /**
     * 授权用户，注册或者登陆
     * @param $authUser
     * @return array|bool
     */
    public function register($authUser)
    {
        $user = ForumUser::findFirst([
            "conditions" => "auth_type = :auth_type: AND auth_id = :auth_id:",
            "bind" => [
                'auth_type' => $authUser['auth_type'],
                'auth_id' => $authUser['auth_id']
            ],
            'columns' => '*',
        ]);
        if ($user) {
            return $user->toArray();
        }

        /** 注册用户，附初始化值，避免NULL */
        $user = new ForumUser();
        $authUser['sex'] = 0;
        $authUser['city'] = '';
        $authUser['sign'] = '';
        $authUser['verify_type'] = 0;
        $authUser['status'] = 1;
        $authUser['created_time'] = time();
        $authUser['updated_time'] = time();
        if ($user->save($authUser)) {
            return $user->toArray();
        }
        return false;
    }


}