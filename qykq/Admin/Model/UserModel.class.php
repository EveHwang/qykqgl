<?php
namespace Admin\Model;
use Frame\Libs\BaseModel;

class  UserModel extends BaseModel
{
	protected $table = "user";

    public function fetchAllWithJion($id)
    {
        $sql = "select * from user ";
        $sql.= "where id = '$id';";
        return $this->pdo->fetchOne($sql);

    }

}