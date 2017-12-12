<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\ForumUser;
use App\Services\ArticleInfoService;
use App\Services\ReplyService;

class HomeController extends BaseController
{
    public function detailAction($id)
    {
          //查询用户的信息
          //查询用户最近的发表的帖子
          //查询用户最新的回答
          $this->view->replys = ReplyService::getUserReplys($id);
          $this->view->user_aricles = ArticleInfoService::getUserArticles($id);
          $this->view->user= ForumUser::findFirst($id);
          $this->view->render('user', 'detail');
    }
}