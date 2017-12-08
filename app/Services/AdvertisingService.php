<?php
/**
 * Created by PhpStorm.
 * User: Mr.Zhou
 * Date: 2017/12/8
 * Time: 下午3:26
 */

namespace App\Services;

use App\Models\ForumAdvertising;

class AdvertisingService
{
    public function __construct()
    {

    }

    public static function getAdvData()
    {
        return ForumAdvertising::find([
            'conditions' => 'status = :status:',
            'bind' => ['status' => 1],
            'order' => 'sort DESC, id ASC',
            'cache' => ["lifetime" => 3600 * 24, "key" => "all-advertising"]
        ]);
    }


}