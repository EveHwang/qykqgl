<?php
namespace Admin\Model;
use Frame\Libs\BaseModel;

class DepartmentModel extends BaseModel
{
	protected $table = "department";

	//实现分类排序
	public function departmentList($arrs,$level=0,$pid=0)
	{

		static $departments = array();
		foreach($arrs as $arr)
		{
			if($arr['pid']==$pid)
			{
				$arr['level'] = $level;
				$departments[] = $arr;
				//调用方法
				$this->departmentList($arrs,$level+1,$arr['id']);
			}
		}
		return $departments;
	}
}