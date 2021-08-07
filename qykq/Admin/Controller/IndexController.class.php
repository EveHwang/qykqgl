<?php
// 声明命名空间
namespace Admin\Controller;
use Frame\Libs\BaseController;

// 定义最终的indexcontroller类，继承basecontroller类
final class IndexController extends BaseController
{
    //首页显示
	public function index()
	{
		$this->isLogin();
		$this->smarty->display("index.html");
	}


	//显示头部
	public function top()
	{

		$this->isLogin();
		$this->smarty->display("top.html");
	}
	//显示左边导航栏
	public function left()
	{
		//最简单的验证
		$this->isLogin();
		$this->smarty->display("left.html");
	}
	//显示中间

	public function center()
	{
		$this->smarty->display("center.html");
	}

	public function main()
	{
		//最简单的验证
		$this->isLogin();
		$this->smarty->display("main.html");
	}

}