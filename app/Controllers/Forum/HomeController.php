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

class HomeController extends BaseController
{
    /**
     * 初始化方法
     */
    public function initialize()
    {
        $this->view->header_choose_type = "forum";
    }

    public function indexAction($tag = 0)
    {
        $this->view->choose_tag = $tag;
        $this->view->order_by_time = true;

        $page = $this->request->get('current_page', 'int', 1);
        $page_nums = $this->request->get('page_nums', 'int', 15);

        $data = ForumArticleInfo::find("id IN(1,2)");
        var_dump($data->userInfo->id);exit;
        //var_dump($data->userInfo->toArray());exit;
        //$data['user'] = $data->userInfo->toArray();
        //output_data(1,'success',$data);
        $this->view->render("forum", "home");
    }
}