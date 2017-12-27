<?php
/**
 * Created by PhpStorm.
 * User: Mr.Zhou
 * Date: 2017/12/19
 * Time: 下午9:00
 */

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\ForumArticleInfo;
use App\Models\ForumArticleReply;
use App\Models\ForumUser;

class MyController extends BaseController
{
    /**
     * 初始化
     * 如果是ajax提交返回 json
     * 否者跳转到首页
     */
    public function initialize()
    {
        if (!$this->user) {
            if ($this->request->isAjax()) {
                output_data(-401, '请先登录，再操作');
            }
            $this->response->redirect('/');
        }
    }

    /**
     * 个人中心
     */
    public function indexAction()
    {
        $this->view->user_menu_choose = 'set_info';
        $this->view->user = json_decode(json_encode($this->user));
        $this->view->render("user", "setting");
    }

    /**
     * 设置用户基础信息
     */
    public function setInfoAction()
    {
        $nickname = $this->request->getPost('nickname');
        $city = $this->request->getPost('city');
        $sex = $this->request->getPost('sex');
        $sign = $this->request->getPost('sign');
        $head_img = $this->request->getPost('head_img');
        $updateData = [];
        !empty($nickname) && $updateData['nickname'] = $nickname;
        !empty($city) && $updateData['city'] = $city;
        !empty($sign) && $updateData['sign'] = $sign;
        is_numeric($sex) && $updateData['city'] = $city;
        !empty($head_img) && $updateData['head_img'] = $head_img;

        $user = ForumUser::findFirst([
            'conditions' => 'id = :id:',
            'bind' => [
                'id' => $this->user['id'],
            ]
        ]);
        if (!$user->update($updateData)) {
            output_data(-1, '修改失败');
        }

        output_data(1, '修改成功');
    }

    public function checkEmailAction()
    {

    }

    public function detailAction($user_id = 0)
    {
        $articleList = ForumArticleInfo::find([
            'conditions' => 'user_id = :user_id: AND status = :status:',
            'bind' => [
                'user_id' => $user_id,
                'status' => 1,
            ],
            'columns' => 'id,title,is_essence,is_top,reply_nums,view_nums,created_time,created_time',
            'cache' => ["lifetime" => 3600 * 1, "key" => "article_list_from_user_id_{$user_id}"]
        ]);
        $userInfo = ForumUser::findFirst([
            'conditions' => 'id = :user_id: AND status = :status:',
            'bind' => [
                'user_id' => $user_id,
                'status' => 1,
            ],
        ]);

        $replyList = ForumArticleReply::find([
            'conditions' => 'user_id = :user_id: AND status = :status:',
            'bind' => [
                'user_id' => $user_id,
                'status' => 1,
            ],
            'cache' => ["lifetime" => 3600 * 1, "key" => "reply_list_from_user_id_{$user_id}"]
        ]);
        $this->view->articleList = $articleList;
        $this->view->userInfo = $userInfo;
        $this->view->verifyTitle = $this->commonConfig->verify_title->toArray();
        $this->view->replyList = $replyList;
        $this->view->render("forum", "user_detail");
    }


}