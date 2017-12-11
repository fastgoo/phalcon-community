<?php
/**
 * Created by PhpStorm.
 * User: Mr.Zhou
 * Date: 2017/12/7
 * Time: 上午10:15
 */

namespace App\Controllers\Forum;

use App\Controllers\BaseController;
use App\Models\ForumArticleInfo;
use App\Models\ForumArticleReply;
use App\Models\ForumArticleReplyPraise;
use App\Models\ForumUser;

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
        if (!$article_id || !$reply_id) {
            output_data(-1, '请求参数异常');
        }
        $replyPraiseModel = ForumArticleReplyPraise::findFirst([
            "conditions" => "user_id = :user_id: AND reply_id = :reply_id:",
            "bind" => [
                'user_id' => $this->user['id'],
                'reply_id' => $reply_id,
            ],
        ]);
        $replyInfoModel = ForumArticleReply::findFirst([
            "conditions" => "id = :reply_id: AND status = :status:",
            "bind" => [
                'status' => 1,
                'reply_id' => $reply_id,
            ],
        ]);
        if ($replyPraiseModel) {
            output_data(-1, '你已经点过赞了');
        }
        $replyPraiseModel = new ForumArticleReplyPraise();
        $this->db->begin();
        try {
            $replyPraiseModel->user_id = $this->user['id'];
            $replyPraiseModel->article_id = $article_id;
            $replyPraiseModel->reply_id = $reply_id;
            $replyPraiseModel->created_time = time();
            if (!$replyPraiseModel->save()) {
                throw new \Exception("点赞失败", -1);
            }
            $replyInfoModel->praise_nums += 1;
            $replyInfoModel->updated_time = time();
            if (!$replyInfoModel->save()) {
                throw new \Exception("点赞失败", -1);
            }
            $this->db->commit();
            output_data(1, '点赞成功！');
        } catch (\Exception $exception) {
            $this->db->rollback();
            output_data($exception->getCode(), $exception->getMessage());
        }
    }

    /**
     * 设置为最佳答案
     */
    public function chooseAnswerAction()
    {
        if (!$this->request->isPost()) {
            output_data(-502, '非法请求');
        }

        if (!$this->user) {
            output_data(-401, '请先登录');
        }

        $article_id = $this->request->getPost('article_id', 'int');
        $reply_id = $this->request->getPost('reply_id', 'int');
        if (!$article_id || !$reply_id) {
            output_data(-1, '请求参数异常');
        }
        $articleInfo = ForumArticleInfo::findFirst([
            "conditions" => "id = :article_id:  AND user_id = :user_id:",
            "bind" => [
                'user_id' => $this->user['id'],
                'article_id' => $article_id,
            ],
        ]);
        if (!$articleInfo) {
            output_data(-1, '不可操作');
        }
        if ($articleInfo->adoption_reply_id) {
            output_data(-1, '已经设置过最佳答案了，不可重复设置');
        }

        $replyInfo = ForumArticleReply::findFirst([
            "conditions" => "id = :reply_id: AND status = :status:",
            "bind" => [
                'reply_id' => $reply_id,
                'status' => 1,
            ],
        ]);
        if (!$replyInfo) {
            output_data(-1, '不可操作这条回复信息');
        }

        $this->db->begin();
        try {
            $articleInfo->adoption_reply_id = $reply_id;
            $articleInfo->updated_time = time();
            if (!$articleInfo->save()) {
                throw new \Exception("设置失败", -1);
            }
            $replyInfo->is_adoption = 1;
            $replyInfo->updated_time = time();
            if (!$replyInfo->save()) {
                throw new \Exception("设置失败", -1);
            }
            $this->db->commit();
            output_data(1, '设置最佳答案成功！');
        } catch (\Exception $exception) {
            $this->db->rollback();
            output_data($exception->getCode(), $exception->getMessage());
        }
    }

    /**
     * 保存回复信息
     *
     */
    public function saveAction()
    {
        if (!$this->request->isPost()) {
            output_data(-502, '非法请求');
        }
        if (!$this->user) {
            output_data(-401, '请先登录');
        }

        $articleId = $this->request->getPost('article_id', 'int');
        $replyId = $this->request->getPost('reply_id', 'int', 0);
        $content = $this->request->getPost('html_content');
        if (!$articleId || !$content) {
            output_data(-1, '必要信息不能为空');
        }
        $articleInfo = ForumArticleInfo::findFirst([
            "conditions" => "id = :article_id: AND status = :status:",
            "bind" => [
                'article_id' => $articleId,
                'status' => 1
            ],
            'columns' => '*',
        ]);
        if (!$articleInfo) {
            output_data(-1, '你回复的文章已被删除或不存在');
        }
        $replyInfo = new ForumArticleReply();

        /** 转化@用户名 */
        if (preg_match_all('%@\w+%u', $content, $matches)) {
            if (!empty($matches[0])) {
                foreach ($matches[0] as $key => $val) {
                    $nickname = mb_substr($val, 1);
                    $userInfo = ForumUser::findFirst([
                        "conditions" => "nickname LIKE :nickname: AND status = :status:",
                        "bind" => [
                            'nickname' => "%$nickname%",
                            'status' => 1
                        ],
                        'columns' => 'id',
                    ]);
                    if ($userInfo) {
                        $content = str_replace($val, "@<a href='/user/home/detail/{$userInfo->id}'>{$nickname}</a>", $content);
                        $replyInfo->at_user = $replyInfo->at_user ? $replyInfo->at_user . ",{$userInfo->id}" : $userInfo->id;
                    }
                }
            }
        }

        $this->db->begin();
        try {
            $articleInfo->reply_nums += 1;
            $articleInfo->updated_time = time();
            if (!$articleInfo->save()) {
                throw new \Exception("回复失败", -1);
            }

            $replyInfo->article_id = $articleId;
            $replyInfo->reply_id = $replyId;
            $replyInfo->user_id = $this->user['id'];
            $replyInfo->content = str_replace(['<script>', '</script>'], '', $content);
            $replyInfo->created_time = time();
            if (!$replyInfo->save()) {
                throw new \Exception("回复失败", -1);
            }
            $this->db->commit();
            output_data(1, '回复成功！');
        } catch (\Exception $exception) {
            $this->db->rollback();
            output_data($exception->getCode(), $exception->getMessage());
        }
    }


}