<?php
//声明命名空间
namespace Frame\Libs;

//定义basecontroller类
abstract class BaseController
{
	//受保护的Smarty对象属性;
	protected $smarty = null;

	public function __construct()
	{
		//创建Smarty类的对象
		$smarty = new \Frame\Vendor\Smarty();
		//Smarty配置左右定界符
		$smarty->left_delimiter = "<{";
		$smarty->right_delimiter = "}>";
		//指定试图目录
		$smarty->setTemplateDir(VIEW_PATH);
		//指定心得编译目录
		$smarty->setCompileDir(sys_get_temp_dir().DS."view_c".DS);
		//给$this->smarty属性赋值
		$this->smarty = $smarty;
	}

	public function jump($msg,$url="?",$time=3)
	{
		echo "<h3>{$msg}<h3>";
		header("refresh:{$time};url={$url}");
		die();
	}

	//判断用户是否登录,最简单的验证方式：角色验证，(RBAC)
	protected function isLogin()
	{
		if(empty($_SESSION['username']))
		{
			$this->jump("没有登录","?c=user&a=login");
		}
	}
	
}