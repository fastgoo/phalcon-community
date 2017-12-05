<?php

namespace App\Models;

class RobotAdminInfo extends BaseModel
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
     * @var string
     * @Column(type="string", length=100, nullable=false)
     */
    public $openid;

    /**
     *
     * @var string
     * @Column(type="string", length=100, nullable=false)
     */
    public $nickname;

    /**
     *
     * @var string
     * @Column(type="string", length=20, nullable=false)
     */
    public $username;

    /**
     *
     * @var string
     * @Column(type="string", length=200, nullable=false)
     */
    public $password;

    /**
     *
     * @var string
     * @Column(type="string", length=200, nullable=false)
     */
    public $head_img;

    /**
     *
     * @var string
     * @Column(type="string", length=200, nullable=false)
     */
    public $idcard_forward_side;

    /**
     *
     * @var string
     * @Column(type="string", length=200, nullable=false)
     */
    public $idcard_back_side;

    /**
     *
     * @var string
     * @Column(type="string", length=50, nullable=false)
     */
    public $app_id;

    /**
     *
     * @var string
     * @Column(type="string", length=200, nullable=false)
     */
    public $app_secret;

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
    public $login_time;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    public $create_time;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    public $update_time;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("wechat-robot");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'robot_admin_info';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return RobotAdminInfo[]|RobotAdminInfo|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return RobotAdminInfo|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public function beforeCreate()
    {
        $this->create_time = date("Y-m-d H:i:s");
    }

    public function beforeUpdate()
    {
        $this->update_time = time();
    }

    public function beforeSave()
    {
        $this->update_time = time();
    }
}
