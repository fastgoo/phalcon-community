<?php
/**
 * Created by PhpStorm.
 * User: Mr.Zhou
 * Date: 2017/11/21
 * Time: 下午4:29
 */

namespace App\Models;

use Phalcon\Di;
use Phalcon\Mvc\Model;

class BaseModel extends Model {
    /**
     * @var \Phalcon\Db\Adapter\Pdo\Mysql
     */
    private $db;

    public function initialize() {
    }

    /**
     * 获取数据库对象
     *
     * @return mixed|\Phalcon\Db\Adapter\Pdo\Mysql
     */
    public function db() {
        if(!is_object($this->db)) {
            $this->db = $this->getDI()->getShared('db');
        }
        return $this->db;
    }

    /**
     * @return Model\Query\BuilderInterface
     */
    public function queryBuilder() {
        return $this->getModelsManager()->createBuilder();
    }

    /**
     * 封装查询语句
     *
     * @param string $columns
     * @return Model\Query\BuilderInterface
     */
    public function select($columns = '*') {
        return $this->queryBuilder()->columns($columns);
    }

    /**
     * @param array  $tab
     * @param string $search
     * @param string $field
     * @param string $orderBy
     * @param int    $pageSize
     * @param int    $page
     * @return array
     */

    public static function fetchPage($tab = [], $search = '', $field = '*', $orderBy = '', $pageSize = 0, $page = 0) {
        $dataCallBack = function ($tab, $search, $field, $orderBy, $pageSize, $page) {
            $builder = Di::getDefault()->get("modelsManager")->createBuilder();
            if($field) {
                $builder->columns($field);
            }
            foreach($tab as $key => $table) {
                if($key == 0) {
                    $builder->from($table);
                } else {
                    $builder->join($table[0], $table[1], $table[2]);
                }
            }
            if($search) {
                $builder->where($search);
            }
            if($orderBy) {
                $builder->orderBy($orderBy);
            }
            if($pageSize > 0 && $page > 0) {
                $builder->limit($pageSize, $pageSize * ($page - 1));
            }
            return $builder->getQuery()->execute()->toArray();
        };

        $countCallBack = function ($tab, $search) {
            $builder = Di::getDefault()->get("modelsManager")->createBuilder();
            foreach($tab as $key => $table) {
                if($key == 0) {
                    $builder->from($table);
                } else {
                    $builder->join($table[0], $table[1], $table[2]);
                }
            }
            if($search) {
                $builder->where($search);
            }
            $res = $builder->columns('COUNT(*) AS nums')->getQuery()->getSingleResult();
            return !empty($res->nums) ? intval($res->nums) : 0;
        };
        $data          = $dataCallBack($tab, $search, $field, $orderBy, $pageSize, $page);
        if($pageSize > 0 && $page > 0) {
            $nums                  = $countCallBack($tab, $search);
            $result                = [];
            $result['items']       = $data;
            $result['current']     = $page;
            $result['total_pages'] = $nums > 0 ? ceil($nums / $pageSize) : 0;
            $result['total_items'] = $nums;
        } else {
            $result = $data;
        }
        return $result;
    }

}