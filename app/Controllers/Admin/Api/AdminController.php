<?php
/**
 * Created by PhpStorm.
 * User: Mr.Zhou
 * Date: 2017/11/21
 * Time: 上午11:27
 */

namespace App\Controllers\Admin\Api;

use App\Controllers\BaseController;
use App\Models\RobotAdminInfo;

class AdminController extends BaseController
{
    /**
     * ceshiooo
     */
    public function loginAction()
    {
        output_data(1, 'success');
    }

    public function registerAction()
    {
        $adminInfo = RobotAdminInfo::findFirst("id = 1");
//        $adminInfo->update_time = time();
//        $adminInfo->create_time = time();
//        $adminInfo->app_secret = '123123';
//        $adminInfo->app_id = '123123';
//        $flag = $adminInfo->save();

        var_dump($this->lastQuery->sql);
    }


    public function transaction()
    {
        try {
            $this->db->begin();
            $robot = new Robots();
            $robot->name = "WALL·E";
            $robot->created_at = date("Y-m-d");
            if ($robot->save() === false) {
                throw new \Exception("用户数据更新失败，事务终止");
            }
            $this->db->commit();
            output_data(1, 'fail');
        } catch (\Exception $exception) {
            $this->db->rollback();
            output_data(-1, 'fail');
        }
    }

}