<?php
//声明命名空间
namespace Admin\Controller;
use Admin\Model\BustripModel;
use Frame\Libs\BaseController;


Class BustripController extends BaseController
{
    //显示用户列表
    public function index()
    {
        $this->isLogin();
        $where = "2>1";
        if(!empty($_POST['id'])) $where .= " and bustrip.id like '%".$_REQUEST['id']."%'";

        $pagesize   = 4;
        $page       = isset($_GET['page'])?$_GET['page']:1;

        $startrow   = ($page-1)*$pagesize;
        $records    = BustripModel::getInstance()->rowCount($where);
        $params     = array(
            'c' => CONTROLLER,
            'a' => ACTION
        );
        //获取表单数据
        if(!empty($_REQUEST['sou'])) $params['sou']=$_REQUEST['sou'];
        $Bustrip = BustripModel::getInstance()->fetchAllWithJion($where,$startrow,$pagesize);
        //print_r($Bustrip);

        //创建分页类对象
        $pageObj = new \Frame\Vendor\Pager($records,$pagesize,$page,$params);
        $pageStr = $pageObj->showPage();

        $this->smarty->assign(array(
            'bustrips'=>$Bustrip,
            'pageStr'=>$pageStr
        ));
        $this->smarty->display('index.html');
    }

    //删除用户数据
    public function delete()
    {
        $this->isLogin();
        $id=$_GET['id'];
        //echo $id;
        $modelObj = BustripModel::getInstance();
        if($modelObj->delete($id))
        {
            $this->jump("id={$id}的记录删除成功！","?c=Bustrip ");
        }else
        {
            $this->jump("id={$id}的记录删除失败！","?c=Bustrip ");
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
        // qushuju
        $data['id'] 		    = $_POST['id'];
        $data['name'] 	        = $_POST['name'];
        $data['department'] 	= ($_POST['department']);
        $data['bt_time'] 	    = $_POST['bt_time'];

        if(BustripModel::getInstance()->insert($data))
        {
            $this->jump("数据添加记录成功！","?c=Bustrip&a=index");
        }else
        {
            $this->jump("数据添加记录失败！","?c=Bustrip&a=index");
        }

    }


    //修改数据,显示修改表单
    public function edit()
    {
        $this->isLogin();
        $id = $_GET['id'];
        $bustrip = BustripModel::getInstance()->fetchOne("id={$id}");
        $this->smarty->assign("bustrip",$bustrip);
        $this->smarty->display('edit.html');
    }

    //修改数据--保存数据
    public function update()
    {

        // 把数据取过来
        $data['id'] 		= $_POST['id'];
        $data['name'] 	= $_POST['name'];
        $data['department'] 	   = ($_POST['department']);
        $data['bt_time'] 	= $_POST['bt_time'];

        //判断记录是否更新
        if(BustripModel::getInstance()->update($data,$id))
        {
            $this->jump("id={$id}记录更新成功！","?c=Bustrip&index");
        }else
        {
            $this->jump("id={$id}记录更新失败！","?c=Bustrip&index");
        }
    }

}