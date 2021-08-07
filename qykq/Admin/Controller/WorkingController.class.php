<?php
namespace Admin\Controller;

use Frame\Libs\BaseController;
use Admin\Model\WorkingModel;


class WorkingController extends BaseController
{
	public function index()
	{

        $this->isLogin();
        $where = "2>1";
        if(!empty($_POST['id'])) $where .= " and working.id like '%".$_REQUEST['id']."%'";

        $pagesize   = 4;
        $page       = isset($_GET['page'])?$_GET['page']:1;

        $startrow   = ($page-1)*$pagesize;
        $records    = WorkingModel::getInstance()->rowCount($where);
        $params     = array(
            'c' => CONTROLLER,
            'a' => ACTION
        );
        //获取表单数据
        if(!empty($_REQUEST['id'])) $params['sou']=$_REQUEST['id'];
        $Working = WorkingModel::getInstance()->fetchAllWithJion($where,$startrow,$pagesize);
        //print_r($Working);

        //创建分页类对象
        $pageObj = new \Frame\Vendor\Pager($records,$pagesize,$page,$params);
        $pageStr = $pageObj->showPage();

        $this->smarty->assign(array(
            'workings'=>$Working,
            'pageStr'=>$pageStr
        ));
        $this->smarty->display('index.html');
    }

	public function add()
	{
        $this->isLogin();
		$workings = WorkingModel::getInstance()->WorkingList(WorkingModel::getInstance()->fetchAll("id asc"));
		$this->smarty->assign("working",$workings);
		$this->smarty->display('add.html');
	}

	public function insert()
	{
		//取数据
        $data['id']              = $_POST['id'];
        $data['name']            = $_POST['name'];
        $data['department']      = $_POST['department'];
        $data['w_time']          = $_POST['w_time'];

		//把数据传给model方法进行添加数据，根据返回的结果判断是否成功
		if(WorkingModel::getInstance()->insert($data))
		{
			$this->jump("添加数据成功","?c=Working");
		}else
		{
			$this->jump("添加数据失败","?c=Working");
		}
	}

	//删除数据
	public function delete()
	{
		$id = $_GET['id'];
		if(WorkingModel::getInstance()->delete($id))
		{
			$this->jump("删除数据成功","?c=Working");
		}else
		{
			$this->jump("删除数据失败","?c=Working");
		}
	}
	// 修改数据：显示表单
	public function edit()
	{
        $this->isLogin();
        $id = $_GET['id'];
        $working = WorkingModel::getInstance()->fetchOne("id={$id}");
		//print_r($working);
		//die();

		$this->smarty->assign("working",$working);
		$this->smarty->display('edit.html');
	}

	//更新数据，更新数据库
	public function update()
	{
		//取数据
		$data['id']              = $_POST['id'];
		$data['name']            = $_POST['name'];
		$data['department']      = $_POST['department'];
		$data['w_time']          = $_POST['w_time'];
		if(WorkingModel::getInstance()->update($data,$id))
		{
			$this->jump("记录为{$id}的数据更新成功","?c=Working");
		}else
		{
			$this->jump("记录为{$id}的数据更新失败功","?c=Working");
		}
	}
}