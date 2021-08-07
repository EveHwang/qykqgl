<?php
namespace Admin\Model;
use Frame\Libs\BaseModel;

class AfleaveModel extends BaseModel
{
	//添加属性-表名
	protected $table = 'afleave';

    public function fetchAllWithJion($where,$startrow,$pagesize)
    {
        $sql  = "select * from afleave ";
        $sql .= "where {$where} ";
        $sql .= "limit {$startrow},{$pagesize}";
        return $this->pdo->fetchAll($sql);

    }
}
