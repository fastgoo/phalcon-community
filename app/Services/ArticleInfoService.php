<?php
/**
 * Created by PhpStorm.
 * User: Mr.Zhou
 * Date: 2017/12/8
 * Time: 下午3:26
 */

namespace App\Services;

use App\Models\ForumArticleInfo;
use App\Models\ForumUserCollection;

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

    public function getArticleFromUsers(Array $user = [], int $page = 1, int $nums = 15)
    {
        $conditions = "user_id = :user_id: AND status = :status:";
        $bind = ['user_id' => $user['id'], 'status' => 1];
        $data = ForumArticleInfo::find([
            "conditions" => $conditions,
            "bind" => $bind,
            'order' => "id DESC",
            'limit' => $nums,
            'offset' => ($page - 1) * $nums,
        ]);
        $count = ForumArticleInfo::count([
            "conditions" => $conditions,
            "bind" => $bind
        ]);
        return [
            'rows' => $data,
            'count' => $count,
            'max_page' => (int)ceil($count / $nums)
        ];
    }


    /**
     * 获取指定用户的文件，分页操作
     * @param array $user
     * @param int $page
     * @param int $nums
     * @return array
     */
    public static function getMyArticle(Array $user = [], int $page = 1, int $nums = 15)
    {
        $conditions = "user_id = :user_id: AND status = :status:";
        $bind = ['user_id' => $user['id'], 'status' => 1];
        $data = ForumArticleInfo::find([
            "conditions" => $conditions,
            "bind" => $bind,
            'order' => "id DESC",
            'limit' => $nums,
            'offset' => ($page - 1) * $nums,
        ]);
        $count = ForumArticleInfo::count([
            "conditions" => $conditions,
            "bind" => $bind
        ]);
        return [
            'rows' => $data,
            'count' => $count,
            'max_page' => (int)ceil($count / $nums)
        ];
    }

    /**
     * 获取收藏文章信息
     * @param array $user
     * @param int $page
     * @param int $nums
     * @return array
     */
    public static function getCollectionArticle(Array $user = [], int $page = 1, int $nums = 15)
    {
        $conditions = "user_id = :user_id: AND status = :status:";
        $bind = ['user_id' => $user['id'], 'status' => 1];
        $data = ForumUserCollection::find([
            "conditions" => $conditions,
            "bind" => $bind,
            'order' => "id DESC",
            'limit' => $nums,
            'offset' => ($page - 1) * $nums,
        ]);
        $count = ForumUserCollection::count([
            "conditions" => $conditions,
            "bind" => $bind
        ]);
        return [
            'rows' => $data,
            'count' => $count,
            'max_page' => (int)ceil($count / $nums)
        ];
    }


}