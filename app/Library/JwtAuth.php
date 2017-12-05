<?php
/**
 * Created by PhpStorm.
 * User: Mr.Zhou
 * Date: 2017/7/19
 * Time: 下午7:46
 */

namespace App\Library;

use Firebase\JWT\JWT;
use Phalcon\Di;
use Exception;

class JwtAuth
{
    private static $jwtKey;
    private static $type;
    private static $privateKey;
    private static $publicKey;

    /**
     * 设置token签名类型  RS256   HS256
     * @param string $type
     * @return JwtAuth
     */
    public static function type($type = '')
    {
        $jwt_auth_config = Di::getDefault()->get("commonConfig")->jwt_auth;

        /** 优先获取用户设置 */
        if (!$type) {
            if ($jwt_auth_config->type == 'RS256') {
                self::$privateKey = file_get_contents($jwt_auth_config->privete);
                self::$publicKey = file_get_contents($jwt_auth_config->public);
            } else {
                self::$jwtKey = $jwt_auth_config->key;
            }
            self::$type = $jwt_auth_config->type;
        } else {
            if ($type == 'RS256') {
                self::$privateKey = file_get_contents($jwt_auth_config->privete);
                self::$publicKey = file_get_contents($jwt_auth_config->public);
            } else {
                self::$jwtKey = $jwt_auth_config->key;
            }
            self::$type = $type;
        }
        return new self();
    }

    /**
     * 生成token字符串
     * @param $data
     * @return string
     */
    public function encode($data = array())
    {
        if (self::$type == 'RS256') {
            $tokenStr = JWT::encode($data, self::$privateKey, self::$type);
        } else {
            $tokenStr = JWT::encode($data, self::$jwtKey);
        }
        return $tokenStr;
    }

    /**
     * 验证token字符串
     * 返回数组
     * @param string $jwt
     * @return object
     */
    public function decode($jwt = '')
    {
        try {
            if (self::$type == 'RS256') {
                $data = JWT::decode($jwt, self::$publicKey, array(self::$type));
            } else {
                $data = JWT::decode($jwt, self::$jwtKey, array(self::$type));
            }
            if (!is_array($data) && !is_object($data)) {
                throw new Exception('授权认证失败');
            } else {
                return $data;
            }
        } catch (Exception $e) {
            logMessage('jwt-auth')->error('授权失败----->'.$jwt);
            return false;
        }
    }
}
