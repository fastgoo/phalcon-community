<?php
/**
 * Created by PhpStorm.
 * User: Mr.Zhou
 * Date: 2017/7/17
 * Time: 下午9:56
 */

/**
 * 输出对应的json数据
 */
if (!function_exists('output_data')) {
    function output_data($code = 1, $msg = 'success', $data = [])
    {
        if (empty($data) || (!is_array($data) && !is_object($data))) {
            $data = new stdClass();
        }
        $response = Phalcon\Di::getDefault()->getResponse();
        $response->setJsonContent(compact('code', 'msg', 'data'));
        $response->send();
        die;
    }
}

/**
 * 日志类初始化配置
 * $logger->log("This is a message");
 * $logger->error("This is another error");
 * $logger->begin();
 * $logger->commit();
 */
if (!function_exists('logMessage')) {
    function logMessage($name = '')
    {
        $path = '../log/';
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }
        $logger = new Phalcon\Logger\Adapter\File($path . ($name ? $name : date('Y-m-d')) . ".log");
        return $logger;
    }
}

/**
 * hash算法密码加密
 */
if (!function_exists('passwordHash')) {
    function passwordHash($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }
}

/**
 * hash算法密码解密
 */
if (!function_exists('passwordVerify')) {
    function passwordVerify($password, $hashKey)
    {
        return password_verify($password, $hashKey);
    }
}

/**
 * 设置七牛图片地址
 */
if (!function_exists('getImageUrl')) {
    function getImageUrl($key, $width=0, $height=0)
    {
        $baseUrl = $response = Phalcon\Di::getDefault()->get("commonConfig")->qiniu->url;

        if (strpos($key, 'ttp:')) {
            return $key;
        } else {
            if ($width && $height) {
                return $key ? "$baseUrl/$key?imageView2/1/w/$width/h/$height/q/100|imageslim" : '';
            } else {
                return $key ? "$baseUrl/$key" : '';
            }
        }
    }
}
