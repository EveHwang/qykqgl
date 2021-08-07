<?php
namespace Home\Model;
use Frame\Libs\BaseModel;

class IndexModel extends BaseModel
{
    protected $table = "user";

    public function  fetchOneWithJoin($id)
    {
        $sql = "select * from user ";

        $sql.= "where id = '$id';";

        return $this->pdo->fetchOne($sql);
    }
}