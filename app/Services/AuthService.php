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
use GuzzleHttp\Client as HttpClient;

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

        $hasNickname = ForumUser::findFirst([
            "conditions" => "nickname = :nickname: AND status = :status:",
            "bind" => [
                'nickname' => $authUser['nickname'],
                'status' => 1
            ],
            'columns' => '*',
        ]);
        if ($hasNickname) {
            $authUser['nickname'] .= '_' . time();
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
        if (strpos($authUser['head_img'], 'https://') === false) {
            $path = self::downImage($authUser['head_img']);
            $res = self::uploadImage($path);
            @unlink($path);
            $authUser['head_img'] = $res['data']['url'];
        }
        if ($user->save($authUser)) {
            return $user->toArray();
        }
        return false;
    }

    public static function downImage($url)
    {
        $client = new HttpClient(['timeout' => 10.0,]);
        $response = $client->get($url);
        $contentType = $response->getHeader('Content-Type');
        $typeName = '.jpg';
        switch ($contentType[0]) {
            case 'image/jpeg':
                $typeName = '.jpg';
                break;
            case 'image/png':
                $typeName = '.png';
                break;
            case 'image/gif':
                $typeName = '.gif';
                break;
        }
        $pathName = BASE_PATH . '/public/app/images/' . time() . rand(100, 999) . $typeName;
        $resource = fopen($pathName, 'a');
        fwrite($resource, $response->getBody()->getContents());
        fclose($resource);
        return $pathName;
    }

    public static function uploadImage($path)
    {
        $client = new HttpClient(['timeout' => 10.0,]);
        $body = fopen($path, 'r');
        $r = $client->request('POST', Di::getDefault()->get('config')->application->baseUri . '/base.api/file/upload', [
        //$r = $client->request('POST', 'https://admin.fastgoo.net/public/upload/file', [
            'multipart' => [[
                'name' => 'file_name',
                'contents' => $body
            ]]
        ]);
        return json_decode($r->getBody()->getContents(), true);
    }
}