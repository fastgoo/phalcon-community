<?php

namespace App\Models;

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
<<<<<<< HEAD
        $this->belongsTo("user_id", "App\\Models\\ForumUser", "id", ['alias' => 'userInfo']);
=======
        //$this->hasOne("user_id","App\\Models\\ForumUser","id",['alias' => 'articleUserInfo']);
        $this->belongsTo(
            "user_id",
            "App\\Models\\ForumUser",
            "id",
            ['alias' => 'articleUserInfo']
        );
>>>>>>> master
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
     * 获取模型对象
     *
     * @return string
     */
    public function t() {
        return __CLASS__;
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

}
