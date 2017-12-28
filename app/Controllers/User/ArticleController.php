<?php
/**
 * Created by PhpStorm.
 * User: Mr.Zhou
 * Date: 2017/12/19
 * Time: 下午9:00
 */

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\ForumArticleInfo;
use App\Models\ForumArticleReply;
use App\Models\ForumUser;
use App\Services\ArticleInfoService;

class ArticleController extends BaseController
{
    /**
     * 初始化
     * 如果是ajax提交返回 json
     * 否者跳转到首页
     */
    public function initialize()
    {
        /*if (!$this->user) {
            if ($this->request->isAjax()) {
                output_data(-401, '请先登录，再操作');
            }
            $this->response->redirect('/');
        }*/
    }

    /**
     * 我的文章列表
     */
    public function getMyDataAction()
    {
        $page = $this->request->getPost('current_page', 'int', 1);
        $pageNums = $this->request->getPost('page_nums', 'int', 20);
        $type = $this->request->getPost('type', 'int', 1);
        $articleRes = ArticleInfoService::getMyArticle($this->user, $page, $pageNums);
        $tags = $this->commonConfig->tags->toArray();
        $data = [];
        if ($type == 2) {
            $articleRes = ArticleInfoService::getCollectionArticle($this->user, $page, $pageNums);
            if ($articleRes['count']) {
                foreach ($articleRes['rows'] as $key => $value) {
                    $data[$key] = $value->toArray();
                    $data[$key]['articleInfo'] = $value->articleInfo;
                    $data[$key]['tag_name'] = $tags[$value->articleInfo->tag];
                    $data[$key]['time'] = timeCompute($value->created_time);
                }
            }
        }else{
            if ($articleRes['count']) {
                foreach ($articleRes['rows'] as $key => $value) {
                    $data[$key] = $value->toArray();
                    $data[$key]['tag_name'] = $tags[$value->tag];
                }
            }
        }
        $articleRes['rows'] = $data;
        output_data(1, 'success', $articleRes);
    }

}