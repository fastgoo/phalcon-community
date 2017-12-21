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

class HomeController extends BaseController
{
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