<?php

namespace App\Models;

use Phalcon\Exception;

class ForumArticleInfo extends BaseModel {

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(type="integer", length=11, nullable=false)
     */
    public $id;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    public $user_id;

    /**
     *
     * @var integer
     * @Column(type="integer", length=4, nullable=false)
     */
    public $tag;

    /**
     *
     * @var string
     * @Column(type="string", length=100, nullable=false)
     */
    public $title;

    /**
     *
     * @var string
     * @Column(type="string", nullable=false)
     */
    public $content;

    /**
     *
     * @var string
     * @Column(type="string", nullable=false)
     */
    public $html_content;

    /**
     *
     * @var integer
     * @Column(type="integer", length=4, nullable=false)
     */
    public $is_essence;

    /**
     *
     * @var integer
     * @Column(type="integer", length=4, nullable=false)
     */
    public $is_top;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    public $adoption_reply_id;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    public $reply_nums;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    public $view_nums;

    /**
     *
     * @var integer
     * @Column(type="integer", length=4, nullable=false)
     */
    public $status;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    public $created_time;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    public $updated_time;

    /**
     * Initialize method for model.
     */
    public function initialize() {
        $this->setSchema("phalcon-forum");
        //$this->hasOne("user_id","App\\Models\\ForumUser","id",['alias' => 'articleUserInfo']);
        $this->belongsTo("user_id", "App\\Models\\ForumUser", "id", ['alias' => 'articleUserInfo']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource() {
        return 'forum_article_info';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return ForumArticleInfo[]|ForumArticleInfo|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null) {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return ForumArticleInfo|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null) {
        return parent::findFirst($parameters);
    }

    /**
     * 此方法可以用于获取ORM模型
     *
     * @return string
     */
    public function t() {
        return __class__;
    }

    /**
     * @param $where 搜索条件
     * @param $limit 获取条数
     * @param $offset 偏移量
     * @return bool
     */
    public function gets($where, $limit, $offset) {
        $query = $this->select('*')->from($this->t());
        if(is_array($where) && count($where) > 0) {
            if(isset($where['article_id'])) {
                $query->andWhere('article=:article_id:', ['article_id' => $where['article_id']]);
            }
            if(isset($where['status'])) {
                $query->andWhere('status=:status:', ['status' => $where['status']]);
            }
            try {
                $result = $query->orderBy('id DESC')->limit($limit, $offset)->getQuery()->execute()->toArray();
                if($result !== false && is_array($result) && count($result) > 0) {
                    return $result;
                }
            } catch(Exception $ex) {
                //记录错误日志
            }
            return false;
        }
    }
}
