<?php
/**
 * Created by PhpStorm.
 * User: Mr.Zhou
 * Date: 2017/7/17
 * Time: 下午9:44
 */

namespace App\Controllers\BaseApi;

use App\Models\ForumArticleInfo;
use App\Models\ForumArticleReply;
use App\Models\ForumUser;
use QL\QueryList;

class AddBatchUserController extends \Phalcon\Mvc\Controller
{
    public function setAction()
    {
        set_time_limit(0);
        foreach (range(1, 20) as $value) {
            $queryList = QueryList::get('https://laravel-china.org/topics?page=' . $value);
            $data = $queryList->find('.pull-left')->find('a>img')->map(function ($img) {
                $checkUser = ForumUser::findFirst([
                    "conditions" => "nickname = :nickname:",
                    "bind" => [
                        'nickname' => $img->alt,
                    ],
                ]);
                if (!$checkUser) {
                    $userModel = new ForumUser();
                    $res = $userModel->create([
                        'auth_id' => '0',
                        'nickname' => $img->alt,
                        'head_img' => $img->src,
                        'created_time' => time()
                    ]);
                    var_dump($res);
                }
            });
        }
        //var_dump($data);
    }

    public function setArticleAction()
    {
        set_time_limit(0);
        foreach (range(1, 10) as $value) {
            QueryList::get('https://segmentfault.com/search?q=phalcon&page=' . $value)->find('section')->find('h2>a')->map(function ($a) {
                $info = QueryList::get('https://segmentfault.com' . $a->href);
                $reply = $info->find(".comments-item")->find(".fmt")->htmls()->toArray();

                $article = new ForumArticleInfo();
                $time = time() - rand(100, 10000);
                $article->user_id = rand(97, 292);
                $article->tag = rand(0, 2);
                $article->title = $info->find("#articleTitle")->find("a")->text();
                $article->content = $info->find(".article__content")->html();
                $article->reply_nums = count($reply);
                $article->view_nums = rand(10, 1000);
                $article->created_time = $time;
                $article->updated_time = $time;
                if ($article->save()) {
                    foreach ($reply as $value) {
                        $reply = new ForumArticleReply();
                        $reply->user_id = rand(97, 292);
                        $reply->article_id = $article->id;
                        $reply->created_time = $article->created_time + rand(100, 600);
                        $reply->content = $value;
                        $reply->save();
                    }
                }
            });
        }
    }
}
