<?php
/**
 * Created by PhpStorm.
 * User: Mr.Zhou
 * Date: 2017/12/8
 * Time: 下午3:26
 */

namespace App\Services;

use App\Models\ForumArticleInfo;

class ArticleInfoService
{
    public function __construct()
    {

    }

    public static function getHotData()
    {
        return ForumArticleInfo::find([
            'conditions' => 'status = :status: AND created_time >= :time: AND reply_nums >= :reply_nums:',
            'columns' => 'id,title,reply_nums',
            'bind' => ['status' => 1, 'time' => time() - 3600 * 24 * 7, 'reply_nums' => 1],
            'order' => 'reply_nums DESC, id DESC',
            "limit" => 10,
            'cache' => ["lifetime" => 3600, "key" => "article-hot"]
        ]);
    }
    
    /**
     * 获取用户文章
     * @param unknown $user_id
     */
    public static function getUserArticles($user_id)
    {
        return ForumArticleInfo::find([
            "conditions" => "user_id = :user_id: AND status = :status:",
            "bind" => [
                'user_id' => $user_id,
                'status' => 1
            ],
            'columns' => 'id, title, reply_nums, view_nums, created_time',
            'limit' => 10,
            'order' => 'id DESC',
        ]);
    }


}