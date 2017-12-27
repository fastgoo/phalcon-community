<?php
/**
 * Created by PhpStorm.
 * User: Mr.Zhou
 * Date: 2017/12/26
 * Time: 下午2:22
 */

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Library\Emailer;
use App\Models\ForumEmailVerify;
use App\Models\ForumUser;

class EmailController extends BaseController
{

    /**
     * 添加邮箱验证信息
     * 添加发送邮件到队列任务
     */
    public function setEmailAction()
    {
        if (!$this->user) {
            output_data(-401, '请先登录');
        }
        $email = $this->request->getPost('email');
        if (!$email) {
            output_data(-1, '参数不能为空');
        }
        $emailModel = new ForumEmailVerify();

        $res = $emailModel->create([
            'email' => $email,
            'user_id' => $this->user['id'],
            'code' => (new \Phalcon\Security\Random)->base58(12),
            'expire_time' => time() + 600,
            'created_time' => time(),
        ]);
        if (!$res) {
            output_data(-1, '发送失败');
        }
        output_data(1, '验证码已发出，请注意查收。如收不到，请查看垃圾箱');
    }

    /**
     * 验证邮箱以及验证码的有效性
     */
    public function emailCheckAction()
    {
        if (!$this->user) {
            output_data(-401, '请先登录');
        }
        $email = $this->request->getPost('email');
        $verify_code = $this->request->getPost('verify_code');
        if (!$email || !$verify_code) {
            output_data(-1, '参数不能为空');
        }
        $emailModel = ForumEmailVerify::findFirst([
            'conditions' => 'user_id = :user_id: AND email = :email: AND code = :code:',
            'bind' => [
                'user_id' => $this->user['id'],
                'email' => $email,
                'code' => $verify_code,
            ]
        ]);
        if (!$emailModel) {
            output_data(-1, '验证失败，请核对邮箱验证码信息');
        }
        if ($emailModel->expire_time < time() || $emailModel->status != 0) {
            output_data(-1, '验证码已失效');
        }
        $user = ForumUser::findFirst([
            'conditions' => 'id = :id:',
            'bind' => ['id' => $this->user['id']],
            'columns' => 'id'
        ]);
        if (!$user) {
            output_data(-1, '用户信息已失效');
        }
        $user->email = $email;
        if (!$user->save()) {
            output_data(-1, '邮箱校验失败，请重试');
        }
        output_data(1, '修改成功');
    }

}