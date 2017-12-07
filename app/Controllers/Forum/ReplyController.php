<?php
/**
 * Created by PhpStorm.
 * User: Mr.Zhou
 * Date: 2017/12/7
 * Time: 上午10:15
 */

namespace App\Controllers\Forum;

use App\Controllers\BaseController;
use App\Models\ForumArticleReplyPraise;

class ReplyController extends BaseController
{
    public function initialize()
    {

    }

    /**
     * 点赞操作接口
     */
    public function doPraiseAction()
    {
        if (!$this->request->isPost()) {
            output_data(-502, '非法请求');
        }

        if (!$this->user) {
            output_data(-401, '请先登录');
        }

        $article_id = $this->request->getPost('article_id', 'int');
        $reply_id = $this->request->getPost('reply_id', 'int');
        if(!$article_id || !$reply_id){
            output_data(-1, '请求参数异常');
        }
        $replyPraiseModel = ForumArticleReplyPraise::findFirst([
            "conditions" => "user_id = :user_id: AND reply_id = :reply_id:",
            "bind" => [
                'user_id' => $this->user['id'],
                'reply_id' => $reply_id,
            ],
        ]);
        if($replyPraiseModel){
            output_data(-1, '你已经点过赞了');
        }
        $replyPraiseModel = new ForumArticleReplyPraise();
        $replyPraiseModel->user_id = $this->user['id'];
        $replyPraiseModel->article_id = $article_id;
        $replyPraiseModel->reply_id = $reply_id;
        $replyPraiseModel->created_time = time();
        if($replyPraiseModel->save()){
            output_data(1, '点赞成功！');
        }
        output_data(1, '点赞失败 - -!');
    }


    public function saveAction()
    {
        if (!$this->request->isPost()) {
            output_data(-502, '非法请求');
        }

        if (!$this->security->checkToken()) {
            output_data(-400, '请刷新页面重新再提交请求');
        }

        $this->user['id'] = 1;
        $title = $this->request->getPost('title');
        $tag = $this->request->getPost('tag', 'int');
        $content = $this->request->getPost('html_content');
        $answer = $this->request->getPost('verify_answer', 'int');
        $articleId = $this->request->getPost('article_id', 'int');
        if (!$title || !in_array($tag, [0, 1, 2]) || !$content || is_null($answer)) {
            output_data(-1, '必要信息不能为空');
        }
        if ($articleId) {
            $article = ForumArticleInfo::findFirst([
                "conditions" => "id = :article_id: AND status = :status: AND user_id = :user_id:",
                "bind" => [
                    'article_id' => $articleId,
                    'user_id' => $this->user['id'],
                    'status' => 1
                ],
                'columns' => '*',
            ]);
            if (!$article) {
                output_data(-1, '你编辑的文章不存在');
            }
        } else {
            $article = new ForumArticleInfo();
            $article->created_time = time();
            $article->user_id = $this->user['id'];
        }
        $article->tag = $tag;
        $article->title = strip_tags($title);
        $article->content = str_replace(['<script>', '</script>'], '', $content);
        $article->updated_time = time();
        if ($article->save()) {
            output_data(1, 'success');
        }
        output_data(-1, '发布失败，请重试');
    }


}