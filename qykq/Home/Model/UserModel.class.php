<?php
namespace Home\Model;
use Frame\Libs\BaseModel;

class  UserModel extends BaseModel
{
    protected $table = "user";

    public function fetchAllWithJion($where,$startrow,$pagesize)
    {
        $sql  = "select * from user ";
        $sql .= "where {$where} ";
        $sql .= "limit {$startrow},{$pagesize}";
        return $this->pdo->fetchAll($sql);

    }

}