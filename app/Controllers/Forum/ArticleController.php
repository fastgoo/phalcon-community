<?php
/**
 * Created by PhpStorm.
 * User: Mr.Zhou
 * Date: 2017/12/3
 * Time: 下午5:10
 */

namespace App\Controllers\Forum;

use App\Controllers\BaseController;
use App\Models\ForumArticleInfo;
use App\Services\ReplyService;

class ArticleController extends BaseController
{
    /**
     * 初始化方法
     */
    public function initialize()
    {
        $this->view->header_choose_type = "forum";
    }

    /**
     * 资讯详情
     * @param $id
     */
    public function detailAction($id)
    {
        $page = $this->request->get('current_page', 'int', 1);
        $nums = $this->request->get('page_nums', 'int', 15);
        $page <= 0 && $page = 1;
        $nums <= 0 && $nums = 15;

        $article = ForumArticleInfo::findFirst([
            "conditions" => "id = :article_id: AND status = :status:",
            "bind" => [
                'article_id' => $id,
                'status' => 1
            ],
            'columns' => '*',
        ]);
        if (!$article) {
            $this->view->render("common", "error404");
            return;
        }
        $article->view_nums += 1;
        $article->save();
        $tags = $this->commonConfig->tags->toArray();
        $article->format_time = timeCompute($article->created_time);
        $article->tag_name = $tags[$article->tag];
        $this->view->article = $article;
        $replyService = new ReplyService();
        $replyList = $replyService->getArticleReply($id, $page, $nums);
        $this->view->reply = $replyList['data'];
        $this->view->reply_count = $replyList['count'];
        $this->view->pagination = [
            'current_page' => $page,
            'count' => $replyList['count'],
            'max_page' => (int)ceil($replyList['count'] / $nums),
            'link' => '/forum/article/detail/' . $id . "?current_page="
        ];
        $this->view->render("forum", "detail");
    }

    /**
     * 添加资讯页面
     */
    public function addAction()
    {
        $user = $this->user['id'];
        $this->view->tags = $this->commonConfig->tags;
        $this->view->verify_question = setQuestionVerify();
        $this->view->render("forum", "add");
    }

    /**
     * 修改资讯页面
     * @param $articleId
     */
    public function editAction($articleId)
    {
        $user = $this->user['id'];
        $this->view->tags = $this->commonConfig->tags;
        $this->view->verify_question = setQuestionVerify();
        $this->view->render("forum", "add");
    }

    /**
     * 保存文章信息
     */
    public function saveAction()
    {
        if (!$this->request->isPost()) {
            output_data(-502, '非法请求');
        }

        if (!$this->user) {
            output_data(-401, '请先登录');
        }

        if (!$this->security->checkToken()) {
            output_data(-400, '请刷新页面重新再提交请求');
        }

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