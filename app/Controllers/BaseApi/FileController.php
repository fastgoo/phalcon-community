<?php
/**
 * Created by PhpStorm.
 * User: Mr.Zhou
 * Date: 2017/7/17
 * Time: 下午9:44
 */

namespace App\Controllers\BaseApi;

use App\Library\Qiniu;

class FileController extends \Phalcon\Mvc\Controller
{
    /**
     * 上传文件到七牛云
     * $_FILE文件，如果传入多文件只能获取第一个文件
     * return key值与url链接
     */
    public function uploadAction()
    {
        try {
            $file = '';
            foreach ($_FILES as $key => $value) {
                $file = $value;
                break;
            }
            if (!$file) {
                output_data(-1, '文件不存在');
            }
            $qiniu = new Qiniu();
            $key = $qiniu->upload('', $file);
            output_data(1, 'success', ['key' => $key, 'url' => getImageUrl($key)]);
        } catch (\Exception $exception) {
            output_data(-1, $exception->getMessage());
        }

    }

    /**
     * 删除七牛云存储的文件
     * key 为上传生成的值
     * 删除成功返回1，失败返回-1
     */
    public function deleteAction()
    {
        try {
            $key = $this->request->getPost('key');
            if (!$key) {
                throw new \Exception("获取删除key失败");
            }
            $qiniu = new Qiniu();
            $qiniu->delete($key);
            output_data(1, 'success');
        } catch (\Exception $exception) {
            output_data(-1, $exception->getMessage());
        }

    }
}
