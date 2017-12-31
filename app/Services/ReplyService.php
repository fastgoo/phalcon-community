<?php
/**
 * Created by PhpStorm.
 * User: Mr.Zhou
 * Date: 2017/12/7
 * Time: 下午2:08
 */

namespace App\Services;

use App\Models\ForumArticleInfo;
use App\Models\ForumArticleReply;
use App\Models\ForumArticleReplyView;
use App\Models\ForumUser;

class ReplyService
{
    public function __construct()
    {

    }

    /**
     * @param $article_id
     * @param $page
     * @param $page_nums
     * @return array
     */
    public function getArticleReply($article_id, $page, $page_nums)
    {
        $conditions = "article_id = :article_id: AND status = :status:";
        $bind = ['status' => 1, 'article_id' => $article_id];
        $data = ForumArticleReply::find([
            "conditions" => $conditions,
            "bind" => $bind,
            'order' => "is_adoption DESC, praise_nums DESC, id ASC",
            'limit' => $page_nums,
            'offset' => ($page - 1) * $page_nums
        ]);
        if ($data->count() < $page_nums) {
            $count = $data->count() + ($page - 1) * $page_nums;
        } else {
            $count = ForumArticleReply::count([
                "conditions" => $conditions,
                "bind" => $bind
            ]);
        }
        return [
            'count' => $count,
            'max_page' => (int)ceil($count / $page_nums),
            'data' => $data,
        ];
    }

    public static function getRank()
    {
        $data = ForumArticleReply::find([
            'conditions' => 'status = :status: AND created_time >= :time:',
            'columns' => 'COUNT(*) AS reply_nums, user_id',
            'bind' => ['status' => 1, 'time' => time() - 3600 * 24 * 7],
            'order' => 'reply_nums DESC, id ASC',
            "group" => "user_id",
            "limit" => 12,
            'cache' => ["lifetime" => 3600, "key" => "reply-rank"]
            //]);
        ])->toArray();

        if ($data) {
            foreach ($data as $index => &$item) {
                $item['userInfo'] = ForumUser::findFirst([
                    'conditions' => 'id = :user_id: AND status = :status:',
                    'columns' => 'id,nickname,head_img',
                    'bind' => ['status' => 1, 'user_id' => $item['user_id']],
                ]);
                $item['userInfo'] && $item['userInfo'] = $item['userInfo']->toArray();
            }
        }
        return $data;
    }


    /**
     * 获取我的文章回复列表
     * @param array $user
     * @param int $page
     * @param int $nums
     * @param int $type
     * @return array
     */
    public static function getMyArticleReply(Array $user, int $page = 1, int $nums = 15, int $type = 1)
    {
        $conditions = "user_id = :user_id: AND status = :status:";
        $bind = ['user_id' => $user['id'], 'status' => 1];
        $article_arr = ForumArticleInfo::find([
            "conditions" => $conditions,
            "bind" => $bind,
            'columns' => 'id',
        ]);
        if (!$article_arr) {
            output_data(1, 'success', ['rows' => [], 'count' => 0, 'max_page' => 0]);
        }

        $conditions = "article_id IN ({article_id:array}) AND status = :status:";
        $bind = ['article_id' => array_column($article_arr->toArray(), 'id'), 'status' => 1];
        if ($type == 1) {
            $rows = ForumArticleReply::find([
                "conditions" => $conditions,
                "bind" => $bind,
                'order' => "id DESC",
                'columns' => '*',
                'limit' => $nums,
                'offset' => ($page - 1) * $nums,
            ]);
        }
        $count = ForumArticleReply::count([
            "conditions" => $conditions,
            "bind" => $bind
        ]);
        return [
            'rows' => !empty($rows) ? $rows : [],
            'count' => $count,
            'max_page' => (int)ceil($count / $nums)
        ];
    }

    /**
     * 获取@我的回复列表
     * @param array $user
     * @param int $page
     * @param int $nums
     * @param int $type
     * @return array
     */
    public static function getAtMeReply(Array $user, int $page = 1, int $nums = 15, int $type = 1)
    {
        $conditions = "FIND_IN_SET(:at_user:,at_user) AND status = :status:";
        $bind = ['at_user' => $user['id'], 'status' => 1];
        if ($type == 1) {
            $rows = ForumArticleReply::find([
                "conditions" => $conditions,
                "bind" => $bind,
                'order' => "id DESC",
                'columns' => '*',
                'limit' => $nums,
                'offset' => ($page - 1) * $nums,
            ]);
        }
        $count = ForumArticleReply::count([
            "conditions" => $conditions,
            "bind" => $bind
        ]);
        return [
            'rows' => !empty($rows) ? $rows : [],
            'count' => $count,
            'max_page' => (int)ceil($count / $nums)
        ];
    }

    /**
     * 获取新消息的数量
     * @param $user
     * @param int $type
     * @return int|mixed
     */
    public static function hasNewMessage($user, int $type = 1)
    {
        $at_user_time = ForumArticleReplyView::findFirst([
            'conditions' => "user_id = :user_id: AND type = :type:",
            'bind' => ['user_id' => $user['id'], 'type' => $type],
            'order' => 'id DESC',
            'columns' => 'created_time'
        ]);
        $created_time = 0;
        if ($at_user_time) {
            $created_time = $at_user_time->created_time;
        }
        if ($type == 2) {
            $conditions = "FIND_IN_SET(:at_user:,at_user) AND status = :status: AND created_time > :created_time:";
            $bind = ['at_user' => $user['id'], 'status' => 1, 'created_time' => $created_time];
            return ForumArticleReply::count([
                "conditions" => $conditions,
                "bind" => $bind
            ]);
        } else {
            $conditions = "user_id = :user_id: AND status = :status:";
            $bind = ['user_id' => $user['id'], 'status' => 1];
            $article_arr = ForumArticleInfo::find([
                "conditions" => $conditions,
                "bind" => $bind,
                'columns' => 'id',
            ]);
            if (!$article_arr) {
                return 0;
            }
            $conditions = "article_id IN ({article_id:array}) AND status = :status: AND created_time > :created_time:";
            $bind = ['article_id' => array_column($article_arr->toArray(), 'id'), 'status' => 1, 'created_time' => $created_time];
            return ForumArticleReply::count([
                "conditions" => $conditions,
                "bind" => $bind
            ]);
        }

    }

}