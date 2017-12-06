<?php
/**
 * Created by PhpStorm.
 * User: Mr.Zhou
 * Date: 2017/12/3
 * Time: 下午5:10
 */

namespace App\Controllers\Forum;

use App\Controllers\BaseController;

class OtherController extends BaseController
{
    /**
     * 初始化方法
     */
    public function initialize()
    {
        //$this->view->header_choose_type = "forum";
    }

    public function showAction()
    {
        $this->view->render("forum", "show_content");
    }

    public function error404Action()
    {
        $this->view->render("common", "error404");
    }

    public function maintainAction()
    {
        $this->view->render("common", "error");
    }
}