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
use App\Models\ForumUserCollection;
use App\Services\ArticleInfoService;

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
     * 消息中心
     */
    public function messageAction()
    {
        $this->view->user_menu_choose = 'message';
        $this->view->render("user", "message");
    }

    /**
     * 我的文章列表（我发布的，我收藏的）
     * @param int $type
     */
    public function articleAction($type = 0)
    {
        $this->view->user_menu_choose = 'article';
        $this->view->article_nums = ForumArticleInfo::count([
            'conditions' => 'user_id = :user_id: AND status = :status:',
            'bind' => ['user_id' => $this->user['id'], 'status' => 1]
        ]);
        $this->view->collection_nums = ForumUserCollection::count([
            'conditions' => 'user_id = :user_id: AND status = :status:',
            'bind' => ['user_id' => $this->user['id'], 'status' => 1]
        ]);
        $this->view->render("user", "article");
    }

    /**
     * 我关注
     */
    public function attentionAction()
    {
        $this->view->user_menu_choose = 'attention';
        $this->view->article_nums = ForumArticleInfo::count([
            'conditions' => 'user_id = :user_id: AND status = :status:',
            'bind' => ['user_id' => $this->user['id'], 'status' => 1]
        ]);
        $this->view->collection_nums = ForumUserCollection::count([
            'conditions' => 'user_id = :user_id: AND status = :status:',
            'bind' => ['user_id' => $this->user['id'], 'status' => 1]
        ]);
        $this->view->render("user", "attention");
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
        is_numeric($sex) && $updateData['sex'] = $sex;
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


}