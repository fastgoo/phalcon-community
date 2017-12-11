<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\ForumUser;

class HomeController extends BaseController
{
    public function detailAction($id)
    {
          var_dump(ForumUser::findFirst($id)->toArray());die;
          //查询用户的信息
          //查询用户最近的发表的帖子
          //查询用户最新的回答
    }
}