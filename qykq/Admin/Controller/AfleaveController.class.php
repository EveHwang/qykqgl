<?php
namespace Admin\Controller;
use Frame\Libs\BaseController;
use Admin\Model\AfleaveModel;

class AfleaveController extends BaseController
{
	public function index()
	{
        $this->isLogin();
		$where = "2>1";// true默认值
		if(!empty($_POST['id'])) $where .= " and afleave.afleave like '%".$_REQUEST['id']."%'";
		echo $where;
		//构建分页的参数：（4）$records,$pagesize,$page,$params
		$pagesize   = 5;
		$page       = isset($_GET['page'])?$_GET['page']:1;
		$startrow   = ($page-1)*$pagesize;//从哪个记录开始取数据!
		$records    = AfleaveModel::getInstance()->rowCount($where);
		$params     = array(
						'c' => CONTROLLER,
						'a' => ACTION
				);
		//获取表单的数据、地址栏的数据
		if(!empty($_REQUEST['keyword'])) $params['keyword']=$_REQUEST['keyword'];
		//取数据
		$afleaves = AfleaveModel::getInstance()->fetchAllWithJion($where,$startrow,$pagesize);
		//print_r($comments);
		//die();

		//创建分页类对象
		$pageObj = new \Frame\Vendor\Pager($records,$pagesize,$page,$params);
		$pageStr = $pageObj->showPage();

		$this->smarty->assign(array(
					'afleaves'=>$afleaves,
					'pageStr'=>$pageStr
			));
		$this->smarty->display('index.html');
	}

	public function delete()
	{
		$id=$_GET['id'];

		if(AfleaveModel::getInstance()->delete($id))
		{
			$this->jump("评价{$id}删除成功！","?c=afleave");
		}else
		{
			$this->jump("评价{$id}删除失败！","?c=afleave");
		}
	}


//添加数据,显示表单
    public function add()
     {
          $this->isLogin();
           $this->smarty->display('add.html');
    }

//添加数据,保存表单数据
     public function insert()
     {
    //取数据
    $data['id'] 		    = $_POST['id'];
    $data['name'] 	        = $_POST['name'];
    $data['department'] 	= ($_POST['department']);
    $data['afl_time'] 	    = $_POST['afl_time'];

    if(AfleaveModel::getInstance()->insert($data))
    {
        $this->jump("数据添加记录成功！","?c=Afleave&a=index");
    }else
    {
        $this->jump("数据添加记录失败！","?c=Afleave&a=index");
    }

}


//修改数据,显示修改表单
public function edit()
{
    $this->isLogin();
    $id = $_GET['id'];
    $afleave = AfleaveModel::getInstance()->fetchOne("id={$id}");
    $this->smarty->assign("afleave",$afleave);
    $this->smarty->display('edit.html');
}

//修改数据--保存数据
    public function update()
   {

    // 把数据取过来
    $data['id'] 		      = $_POST['id'];
    $data['name'] 	          = $_POST['name'];
    $data['department'] 	   = ($_POST['department']);
    $data['afl_time'] 	      = $_POST['afl_time'];

    //判断记录是否更新
    if(AfleaveModel::getInstance()->update($data,$id))
    {
        $this->jump("id={$id}记录更新成功！","?c=Afleave&index");
    }else
    {
        $this->jump("id={$id}记录更新失败！","?c=Afleave&index");
    }
}

}
