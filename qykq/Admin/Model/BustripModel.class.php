<?php
namespace Admin\Model;

use Frame\Libs\BaseModel;

class BustripModel extends BaseModel
{
	protected $table = "bustrip";
    public function fetchAllWithJion($where,$startrow,$pagesize)
    {
        $sql  = "select * from bustrip ";
        $sql .= "where {$where} ";
        $sql .= "limit {$startrow},{$pagesize}";
        return $this->pdo->fetchAll($sql);

    }
}