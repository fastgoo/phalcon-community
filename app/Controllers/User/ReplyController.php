<?php
/**
 * Created by PhpStorm.
 * User: Mr.Zhou
 * Date: 2017/12/9
 * Time: 下午2:52
 */

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\ForumArticleInfo;
use App\Models\ForumArticleReply;
use App\Models\ForumArticleReplyView;
use App\Models\ForumUserAttention;
use App\Models\ForumUserCollection;
use App\Services\ArticleInfoService;
use App\Services\ReplyService;

class ReplyController extends BaseController
{
    public function initialize()
    {

    }

    public function setReadMsgAction()
    {
        if (!$this->request->isPost()) {
            output_data(-502, '非法请求');
        }
        if (!$this->user) {
            output_data(-401, '请先登录');
        }
        $type = $this->request->getPost('type', 'int',1);

        $readModel = new ForumArticleReplyView();
        $flag = $readModel->create([
            'type' => $type,
            'user_id' => $this->user['id'],
            'created_time' => time(),
        ]);
        if ($flag) {
            output_data(1, 'success');
        }
        output_data(-1, '信息阅读失败');
    }

    /**
     * 获取回复列表接口
     */
    public function myReplyListAction()
    {
        if (!$this->request->isPost()) {
            output_data(-502, '非法请求');
        }
        if (!$this->user) {
            output_data(-401, '请先登录');
        }

        $page = $this->request->getPost('current_page', 'int', 1);
        $pageNums = $this->request->getPost('page_nums', 'int', 20);

        $res = ReplyService::getMyArticleReply($this->user, $page, $pageNums);
        $arr = [];
        $titles = $this->commonConfig->verify_title->toArray();
        foreach ($res['rows'] as $key => $value) {
            $arr[$key] = [
                'article_id' => $value->article_id,
                'user_id' => $value->user_id,
                'content' => $value->content,
                'title' => $value->articleInfo->title,
                'nickname' => $value->userInfo->nickname,
                'head_img' => $value->userInfo->head_img,
                'verify_type' => $value->userInfo->verify_type,
                'type_name' => !empty($titles[$value->userInfo->verify_type]) ? $titles[$value->userInfo->verify_type] : '',
                'time' => timeCompute($value->created_time),
            ];
        }
        $res['rows'] = $arr;
        output_data(1, 'success', $res);
    }

    /**
     * 获取@我的回复列表接口
     */
    public function atMeListAction()
    {
        if (!$this->request->isPost()) {
            output_data(-502, '非法请求');
        }
        if (!$this->user) {
            output_data(-401, '请先登录');
        }

        $page = $this->request->getPost('current_page', 'int', 1);
        $pageNums = $this->request->getPost('page_nums', 'int', 20);

        $res = ReplyService::getAtMeReply($this->user, $page, $pageNums);
        $arr = [];
        $titles = $this->commonConfig->verify_title->toArray();
        foreach ($res['rows'] as $key => $value) {
            $arr[$key] = [
                'article_id' => $value->article_id,
                'user_id' => $value->user_id,
                'content' => $value->content,
                'title' => $value->articleInfo->title,
                'nickname' => $value->userInfo->nickname,
                'head_img' => $value->userInfo->head_img,
                'verify_type' => $value->userInfo->verify_type,
                'type_name' => !empty($titles[$value->userInfo->verify_type]) ? $titles[$value->userInfo->verify_type] : '',
                'time' => timeCompute($value->created_time),
            ];
        }
        $res['rows'] = $arr;
        output_data(1, 'success', $res);
    }


}