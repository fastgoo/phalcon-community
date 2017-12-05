<?php
/**
 * Created by PhpStorm.
 * User: Mr.Zhou
 * Date: 2017/7/17
 * Time: 下午9:44
 */

namespace App\Controllers\News;

use App\Controllers\BaseController;

class HomeController extends BaseController
{
    public function onConstruct()
    {

    }

    public function initialize()
    {
        $this->view->header_choose_type = "news";
    }

    /**
 * 首页数据
 */
    public function indexAction()
    {
        //var_dump($_SERVER);exit;
        $this->view->render("news", "home");
    }

    /**
     * 详情页数据
     */
    public function detailAction()
    {

        $this->view->render("news", "detail");
    }
}
