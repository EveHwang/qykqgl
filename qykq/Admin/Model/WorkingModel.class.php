<?php 
namespace Admin\Model;
use Frame\Libs\BaseModel;
class WorkingModel extends BaseModel
{
    protected $table = 'working';

    public function fetchAllWithJion($where,$startrow,$pagesize)
    {
        $sql  = "select * from working ";
        $sql .= "where {$where} ";
        $sql .= "limit {$startrow},{$pagesize}";
        return $this->pdo->fetchAll($sql);
    }
}