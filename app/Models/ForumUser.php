<?php

namespace App\Models;

class ForumUser extends BaseModel
{

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
     * @Column(type="integer", length=4, nullable=false)
     */
    public $auth_type;

    /**
     *
     * @var string
     * @Column(type="string", length=100, nullable=false)
     */
    public $auth_id;

    /**
     *
     * @var string
     * @Column(type="string", length=100, nullable=false)
     */
    public $nickname;

    /**
     *
     * @var string
     * @Column(type="string", length=200, nullable=false)
     */
    public $head_img;

    /**
     *
     * @var integer
     * @Column(type="integer", length=1, nullable=false)
     */
    public $sex;

    /**
     *
     * @var string
     * @Column(type="string", length=100, nullable=false)
     */
    public $city;

    /**
     *
     * @var string
     * @Column(type="string", length=200, nullable=false)
     */
    public $sign;

    /**
     *
     * @var integer
     * @Column(type="integer", length=4, nullable=false)
     */
    public $verify_type;

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
    public function initialize()
    {
        $this->setSchema("phalcon-forum");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'forum_user';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return ForumUser[]|ForumUser|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return ForumUser|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
