<?php
/**
 * Created by PhpStorm.
 * User: Mr.Zhou
 * Date: 2017/12/9
 * Time: 下午2:52
 */

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\ForumUserCollection;

class CollectionController extends BaseController
{
    public function initialize()
    {

    }

    /**
     * 收藏文章接口
     */
    public function setCollectionAction()
    {
        if (!$this->request->isPost()) {
            output_data(-502, '非法请求');
        }
        if (!$this->user) {
            output_data(-401, '请先登录');
        }
        $article_id = $this->request->getPost('article_id');
        if (!$article_id) {
            output_data(-1, '必要信息不能为空');
        }

        $collectionModel = ForumUserCollection::findFirst([
            "conditions" => "user_id = :user_id: AND article_id = :article_id:",
            "bind" => [
                'article_id' => $article_id,
                'user_id' => $this->user['id'],
            ],
        ]);

        if (!$collectionModel) {
            $collectionModel = new ForumUserCollection();
            $collectionModel->user_id = $this->user['id'];
            $collectionModel->article_id = $article_id;
            $collectionModel->created_time = time();
            $collectionModel->updated_time = time();
            if (!$collectionModel->save()) {
                output_data(-1, '关注用户失败');
            }
            output_data(1, '关注用户成功', ['status' => 1]);
        }
        if ($collectionModel->status == 1) {
            $collectionModel->status = 0;
        } else {
            $collectionModel->status = 1;
        }

        if (!$collectionModel->save()) {
            output_data(-1, '关注用户失败');
        }
        output_data(1, '关注用户成功', ['status' => $collectionModel->status]);
    }

}