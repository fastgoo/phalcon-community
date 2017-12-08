<?php
/**
 * Created by PhpStorm.
 * User: Mr.Zhou
 * Date: 2017/12/8
 * Time: 下午3:26
 */

namespace App\Services;

use App\Models\ForumCoopLink;

class CoopLinkService
{
    public function __construct()
    {

    }

    public static function getCoopData()
    {
        return ForumCoopLink::find([
            'conditions' => 'status = :status:',
            'columns' => 'name,url',
            'bind' => ['status' => 1],
            'order' => 'sort DESC',
            //"limit" => 10,
            //'cache' => ["lifetime" => 3600, "key" => "article-hot"]
        ]);
    }


}