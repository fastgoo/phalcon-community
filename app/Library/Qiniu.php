<?php

/**
 * Created by PhpStorm.
 * User: zhoujianjun
 * Date: 2017/7/16
 * Time: 上午9:54
 */

namespace App\Library;

use Qiniu\Auth;
use Qiniu\Storage\BucketManager;
use Qiniu\Storage\UploadManager;
use Phalcon\Di;


class Qiniu
{
    public $config;

    public function __construct()
    {
        $this->config = Di::getDefault()->get("commonConfig")->qiniu;
    }

    /**
     * 七牛存储授权认证
     * @return string
     * @throws \Exception
     */
    public function auth()
    {
        $auth = new Auth($this->config->accessKey, $this->config->secretKey);
        $token = $auth->uploadToken($this->config->bucket);
        if (!$token) {
            throw new \Exception("七牛云储存获取token认证失败");
        }
        return $token;
    }

    /**
     * 上传文件
     * @param string $fileName
     * @param string $file
     * @return mixed
     * @throws \Exception
     */
    public function upload($fileName = '', $file = '')
    {
        $token = $this->auth();
        $uploadMgr = new UploadManager();
        $name = $fileName ? $fileName : date('YmdHis') . rand(1000, 9999);
        $file = $file ? $file : $_FILES['filedata'];
        list($ret, $err) = $uploadMgr->putFile($token, $name, $file['tmp_name']);
        if ($err !== null) {
            throw new \Exception("七牛云文件上传失败(原因): ".$err->message());
        }
        return $ret['key'];
    }

    /**
     * 删除存储对象里面的文件
     * @param string $key
     * @return bool
     * @throws \Exception
     */
    public function delete($key = '')
    {
        $auth = new Auth($this->config->accessKey, $this->config->secretKey);
        $bucketMgr = new BucketManager($auth);
        $err = $bucketMgr->delete($this->config->bucket, $key);
        if ($err !== null) {
            throw new \Exception("删除七牛云存储文件失败(原因): ".$err->message());
        }
        return true;
    }
}
