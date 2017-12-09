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
    function getImageUrl($key, $width = 0, $height = 0)
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

if (!function_exists('setQuestionVerify')) {
    function setQuestionVerify()
    {
        $di = Phalcon\Di::getDefault();
        $symbol = ['+', '-'];
        $symbolKey = array_rand($symbol, 1);
        $a = rand(1, 99);
        $b = rand(1, 99);
        switch ($symbol[$symbolKey]) {
            case '+':
                $answer = $a + $b;
                break;
            case '-':
                $answer = $a + $b;
                break;
            default:
                $answer = 0;
        }
        $di->get("session")->set('verifyAnswer', $answer);
        return "{$a} {$symbol[$symbolKey]} {$b} = ?";
    }
}

if (!function_exists('time_compute')) {
    function timeCompute($timeStart)
    {

        //$timeStart = 1475908314;
        $times = time(); //当前时间
        $month = 2592000; //月
        $day = 86400; //天
        $hour = 3600; //小时
        $minute = 60;//秒

        $times = $times - $timeStart;

        if ($month <= $times) { //月
            $month_name = $times % $month; //小时
            $month_name = ($times - $month_name) / $day;
            $str_time = $month_name . '个月前';
            return $str_time;
        }

        if ($month >= $times && $day <= $times) {//几天前
            $day_name = $times % $day; //小时
            $day_name = ($times - $day_name) / $day;
            $str_time = $day_name . '天前';
            return $str_time;
        }

        if ($day >= $times && $hour <= $times) { //几小时前
            $hour_name = $times % $hour; //小时
            $hour_name = ($times - $hour_name) / $hour;
            $str_time = $hour_name . '小时前';
            return $str_time;
        }

        if ($hour >= $times && $minute <= $times) { //几分钟前
            $minute_name = $times % $minute; //小时
            $minute_name = ($times - $minute_name) / $minute;
            $str_time = $minute_name . '分钟前';
            return $str_time;
        } else {
            $str_time = '1分钟内';
            return $str_time;
        }


    }
}
