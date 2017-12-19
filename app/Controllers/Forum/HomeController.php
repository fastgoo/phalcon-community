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

class HomeController extends BaseController
{
    /**
     * 初始化方法
     */
    public function initialize()
    {
        $this->view->header_choose_type = "forum";
        $this->view->recommend_resource = RecommendResourceService::getRecommendData();
        $this->view->reply_rank = ReplyService::getRank();
        $this->view->hot_article = ArticleInfoService::getHotData();
        $this->view->advertsing = AdvertisingService::getAdvData();
        $this->view->coop_link = CoopLinkService::getCoopData();
    }

    public function indexAction($tag = 0)
    {

        $this->view->choose_tag = $tag;
        $this->view->order_by_time = true;

        $page = $this->request->get('current_page', 'int', 1);
        $pageNums = $this->request->get('page_nums', 'int', 20);
        $searchStr = $this->request->get('search');

        $conditions = "status = :status:";
        $bind = ['status' => 1];
        $order = "is_top DESC";
        if ($searchStr) {
            $conditions .= ' AND (title LIKE "%:search_str:%" OR content LIKE "%:search_str:%")';
            $bind['search_str'] = $searchStr;
        }

        switch ($tag) {
            case 0:
                $order .= ", created_time DESC";
                break;
            case 1:
                $order .= ", reply_nums DESC";
                break;
            case 2:
                $order .= ", reply_nums DESC, is_essence DESC";
                $conditions .= ' AND is_essence = :is_essence:';
                $bind['is_essence'] = 1;
                break;
            case 3:
                $conditions .= " AND tag = :tag:";
                $bind['tag'] = 1;
                break;
            case 4:
                $conditions .= " AND tag = :tag:";
                $bind['tag'] = 2;
                break;
        }

        $data = ForumArticleInfo::find([
            "conditions" => $conditions,
            "bind" => $bind,
            'order' => $order,
            'limit' => $pageNums,
            'offset' => ($page - 1) * $pageNums
        ]);
        $count = ForumArticleInfo::count([
            "conditions" => $conditions,
            "bind" => $bind
        ]);

        $this->view->article_list = $data;
        $this->view->article_nums = $count;
        $this->view->pagination = [
            'current_page' => $page,
            'count' => $count,
            'max_page' => (int)ceil($count / $pageNums),
            'link' => '/forum/home/index' . ($tag ? "/$tag" : "") . "?current_page="
        ];
        //echo 1;exit;
        $this->view->render("forum", "home");
    }
}