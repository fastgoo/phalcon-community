<?php
/**
 * Created by PhpStorm.
 * User: Mr.Zhou
 * Date: 2017/12/8
 * Time: 下午3:26
 */

namespace App\Services;

use App\Models\ForumRecommendResource;

class RecommendResourceService
{
    public function __construct()
    {

    }

    public static function getRecommendData()
    {
        return ForumRecommendResource::find([
            'conditions' => 'status = :status:',
            'columns' => 'id,title,url',
            'bind' => ['status' => 1],
            'order' => ' sort DESC, id ASC',
            'cache' => ["lifetime" => 3600 * 24, "key" => "recommend-resource-data"]
        ]);
    }


}