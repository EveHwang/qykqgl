<?php
//命名空间
namespace Admin\Controller;
use Frame\Libs\BaseController;
use Admin\Model\DepartmentModel;

class DepartmentController extends BaseController
{
	public function index()
	{
        $departments = DepartmentModel::getInstance()->fetchAll("id asc");
        //问题1：取数据的顺序，降序：
        //问题2：分类的转换
        //问题3：分类没有缩进
        $departments = DepartmentModel::getInstance()->departmentList($departments);

		//显示视图
		$this->smarty->assign("departments",$departments);
		$this->smarty->display('index.html');
	}

	//添加分类：显示表单
	public function add()
	{
		//获取分类的名称：
		$departments = DepartmentModel::getInstance()->departmentList(DepartmentModel::getInstance()->fetchAll("id asc"));

		$this->smarty->assign("departments",$departments);

		$this->smarty->display('add.html');
	}
	//添加分类：保存表单数据
	public function insert()
	{
		//获取表单数据
		$data['de_name']		= $_POST['de_name'];
		$data['name']		    = $_POST['name'];
		$data['age']			= $_POST['age'];
        $data['sex']			= $_POST['sex'];
        $data['tel']			= $_POST['tel'];
        $data['id']			    = $_POST['id'];

		//使用模型类方法添加数据，返回结果
		if(DepartmentModel::getInstance()->insert($data))
		{
			$this->jump("信息添加成功","?c=department");
		}else
		{
			$this->jump("信息添加失败","?c=department");
		}

	}

	//删除分类
	public function delete()
	{
		$id = $_GET['id'];

		if(DepartmentModel::getInstance()->delete($id))
		{
			$this->jump("记录为{$id}的信息删除成功","?c=department");
		}else
		{
			$this->jump("记录为{$id}的信息删除失败","?c=department");
		}
	}


	//修改数据：显示表单
	public function edit()
	{
		//取被修改记录的数据
		$id = $_GET['id'];

		$department = DepartmentModel::getInstance()->fetchOne("id={$id}");
		//问题1：不想看到pid，想看到pid对应的分类名称
		$categoryPid = DepartmentModel::getInstance()->fetchOne("id={$department['pid']}");
		$department['pname'] = $categoryPid['classname'];
		
		//问题2：PID select中没有显示分类列表
		$departments = DepartmentModel::getInstance()->departmentList(DepartmentModel::getInstance()->fetchAll("id asc"));
		$this->smarty->assign("department",$department);
		$this->smarty->assign("departments",$departments);
		$this->smarty->display('edit.html');
	}

	//更新数据
	public function update()
	{
		//获取数据
        $data['de_name']		= $_POST['de_name'];
        $data['name']		    = $_POST['name'];
        $data['age']			= $_POST['age'];
        $data['sex']			= $_POST['sex'];
        $data['tel']			= $_POST['tel'];

		$id = $_POST['id'];

		if(DepartmentModel::getInstance()->update($data,$id))
		{
			$this->jump("记录为{$id}的信息修改成功","?c=department&index");
		}else
		{
			$this->jump("记录为{$id}的信息修改成功","?c=department&index");
		}
	}
}

