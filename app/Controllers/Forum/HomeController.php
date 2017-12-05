<?php
/**
 * Created by PhpStorm.
 * User: Mr.Zhou
 * Date: 2017/12/3
 * Time: 下午5:10
 */

namespace App\Controllers\Forum;

use App\Controllers\BaseController;

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
        $this->view->render("forum", "home");
    }

    public function detailAction()
    {
        $this->view->render("forum", "detail");
    }

    public function addAction()
    {
        $this->view->render("forum", "add");
    }

    public function showAction()
    {
        $this->view->render("forum", "show_content");
    }

    public function error404Action()
    {
        $this->view->render("common", "error404");
    }
}