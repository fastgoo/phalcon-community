<?php
/**
 * Created by PhpStorm.
 * User: Mr.Zhou
 * Date: 2017/12/9
 * Time: 下午2:52
 */
namespace App\Controllers\User;

use App\Controllers\BaseController;

class AttentionController extends BaseController
{
    public function initialize()
    {

    }

    public function setAttentionAction()
    {
        if (!$this->request->isPost()) {
            output_data(-502, '非法请求');
        }

        if (!$this->user) {
            output_data(-401, '请先登录');
        }

        $user_id = $this->request->getPost('user_id');
        $status = $this->request->getPost('status', 'int',1);

        if (!$user_id || !in_array($status, [1, -1]) || !$content || is_null($answer)) {
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