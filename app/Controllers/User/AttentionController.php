<?php
/**
 * Created by PhpStorm.
 * User: Mr.Zhou
 * Date: 2017/12/9
 * Time: 下午2:52
 */

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\ForumUserAttention;
use App\Models\ForumUserCollection;

class AttentionController extends BaseController
{
    public function initialize()
    {

    }

    /**
     * 获取用户关注状态和收藏文章状态
     */
    public function getAttentionCollectionAction()
    {
        if (!$this->request->isGet()) {
            output_data(-502, '非法请求');
        }
        if (!$this->user) {
            output_data(-401, '请先登录');
        }
        $user_id = $this->request->get('user_id');
        $article_id = $this->request->get('article_id');
        $attention = ForumUserAttention::findFirst([
            "conditions" => "user_id = :user_id: AND attention_user_id = :attention_user_id: AND status = :status:",
            "bind" => [
                'attention_user_id' => $user_id,
                'user_id' => $this->user['id'],
                'status' => 1,
            ],
        ]);
        $collection = ForumUserCollection::findFirst([
            "conditions" => "user_id = :user_id: AND article_id = :article_id: AND status = :status:",
            "bind" => [
                'article_id' => $article_id,
                'user_id' => $this->user['id'],
                'status' => 1,
            ],
        ]);
        $result = [
            'attention' => $attention ? 1 : 0,
            'collection' => $collection ? 1 : 0,
        ];
        output_data(1, 'success', $result);
    }

    /**
     * 关注用户操作接口
     */
    public function setAttentionAction()
    {
        if (!$this->request->isPost()) {
            output_data(-502, '非法请求');
        }

        if (!$this->user) {
            output_data(-401, '请先登录');
        }
        $user_id = $this->request->getPost('user_id');
        if (!$user_id) {
            output_data(-1, '必要信息不能为空');
        }

        $attentionModel = ForumUserAttention::findFirst([
            "conditions" => "user_id = :user_id: AND attention_user_id = :attention_user_id:",
            "bind" => [
                'attention_user_id' => $user_id,
                'user_id' => $this->user['id'],
            ],
        ]);

        if (!$attentionModel) {
            $attentionModel = new ForumUserAttention();
            $attentionModel->user_id = $this->user['id'];
            $attentionModel->attention_user_id = $user_id;
            $attentionModel->status = 1;
            $attentionModel->created_time = time();
            $attentionModel->updated_time = time();
            if (!$attentionModel->save()) {
                output_data(-1, '关注用户失败');
            }
            output_data(1, '关注用户成功', ['status' => 1]);
        }
        if ($attentionModel->status == 1) {
            $attentionModel->status = 0;
        } else {
            $attentionModel->status = 1;
        }

        if (!$attentionModel->save()) {
            output_data(-1, '关注用户失败');
        }
        output_data(1, '操作成功', ['status' => $attentionModel->status]);
    }

}