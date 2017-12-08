<?php
/**
 * Created by PhpStorm.
 * User: Mr.Zhou
 * Date: 2017/12/7
 * Time: 下午2:08
 */

namespace App\Services;

use App\Models\ForumArticleReply;

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
        $conditions = "status = :status: AND article_id = :article_id:";
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


}