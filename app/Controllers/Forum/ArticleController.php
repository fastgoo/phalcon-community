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
use App\Services\AdvertisingService;
use App\Services\ArticleInfoService;
use App\Services\CoopLinkService;
use App\Services\RecommendResourceService;
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
        $this->view->setVar('status',1) ;
        $this->view->recommend_resource = RecommendResourceService::getRecommendData();
        $this->view->reply_rank = ReplyService::getRank();
        $this->view->hot_article = ArticleInfoService::getHotData();
        $this->view->advertsing = AdvertisingService::getAdvData();
        $this->view->coop_link = CoopLinkService::getCoopData();
        $this->view->render("forum", "detail");

    }

    /**
     * 添加资讯页面
     */
    public function addAction()
    {
        $this->view->tags = $this->commonConfig->tags;
        $this->view->verify_question = setQuestionVerify();
        $this->view->render("forum", "add");
    }

    /**
     * 修改资讯页面
     * @param $articleId
     */
    public function editAction(int $articleId)
    {
        if (!$this->user) {
            $this->response->redirect('/');
        }
        $articleInfo = ForumArticleInfo::findFirst([
            'conditions' => 'id = :article_id: AND status = :status:',
            'bind' => [
                'article_id' => $articleId,
                'status' => 1
            ]
        ]);
        if (!$articleInfo) {
            $this->response->redirect('/');
        }
        if ($articleInfo->user_id != $this->user['id']) {
            $this->response->redirect('/');
        }
        //echo $articleInfo->content;exit;
        $this->view->tags = $this->commonConfig->tags;
        $this->view->verify_question = setQuestionVerify();
        $this->view->article = $articleInfo;
        $this->view->render("forum", "edit");
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
        $html_content = $this->request->getPost('html_content');
        $content = $this->request->getPost('content');
        $answer = $this->request->getPost('verify_answer', 'int');
        $articleId = $this->request->getPost('article_id', 'int');
        if (!$title || !in_array($tag, [0, 1, 2]) || !$content || !$html_content || is_null($answer)) {
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
        $article->html_content = $html_content;
        $article->updated_time = time();
        if ($article->save()) {
            output_data(1, 'success');
        }
        output_data(-1, '发布失败，请重试');
    }

    /**
     * 设置置顶、精华
     */
    public function setTopOrEssenceAction()
    {
        if (!$this->request->isPost()) {
            output_data(-502, '非法请求');
        }

        if (!$this->user) {
            output_data(-401, '请先登录');
        }
        if ($this->user['verify_type'] < 110) {
            output_data(-403, '你无权设置');
        }
        $article_id = $this->request->getPost('article_id', 'int');
        $is_top = $this->request->getPost('is_top', 'int');
        $is_essence = $this->request->getPost('is_essence', 'int');
        if (!$article_id || (!$is_top && !$is_essence)) {
            output_data(-1, '必要信息不能为空');
        }
        $articleInfo = ForumArticleInfo::findFirst([
            'conditions' => 'id = :article_id: AND status = :status:',
            'bind' => [
                'article_id' => $article_id,
                'status' => 1
            ]
        ]);
        if (!$articleInfo) {
            output_data(-1, '文章不存在，不可操作');
        }
        $status = 0;
        if ($is_top) {
            $status = $articleInfo->is_top = $articleInfo->is_top ? 0 : 1;
        }

        if ($is_essence) {
            $status = $articleInfo->is_essence = $articleInfo->is_essence ? 0 : 1;
        }

        if ($articleInfo->save()) {
            output_data(1, '操作成功', ['status' => $status]);
        }
        output_data(-1, '操作失败');
    }

    /**
     * 删除文章
     */
    public function deleteAction()
    {
        if (!$this->request->isPost()) {
            output_data(-502, '非法请求');
        }

        if (!$this->user) {
            output_data(-401, '请先登录');
        }
        $article_id = $this->request->getPost('article_id', 'int');
        if (!$article_id) {
            output_data(-1, '必要信息不能为空');
        }
        $articleInfo = ForumArticleInfo::findFirst([
            'conditions' => 'id = :article_id: AND status = :status:',
            'bind' => [
                'article_id' => $article_id,
                'status' => 1
            ]
        ]);
        if (!$articleInfo) {
            output_data(-1, '文章不存在，不可操作');
        }
        if ($articleInfo->user_id != $this->user['id'] && $this->user['verify_type'] < 110) {
            output_data(-1, '你无权操作');
        }
        $articleInfo->status = -1;
        if ($articleInfo->save()) {
            output_data(1, '删除成功');
        }
        output_data(-1, '删除失败');
    }
}