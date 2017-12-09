<?php
/**
 * Created by PhpStorm.
 * User: Mr.Zhou
 * Date: 2017/12/7
 * Time: 下午2:08
 */

namespace App\Services;

use App\Models\ForumArticleReply;
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


}