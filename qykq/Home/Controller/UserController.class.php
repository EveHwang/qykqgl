<?php
namespace Home\Controller;
use Frame\Libs\BaseController;
use Home\Model\IndexModel;
class UserController extends BaseController
{
//显示用户列表
public function index()
{
//验证
$this->isLogin();
$modelObj = UserModel::getInstance();//创建用户model对象
//取数据
$users = $modelObj->fetchAll();
//赋值给view
$this->smarty->assign("users",$users);
//显示view
$this->smarty->display("index.html");
}

//删除用户数据
public function delete()
{
//验证
$this->isLogin();
$id=$_GET['id'];
$modelObj = UserModel::getInstance();
if($modelObj->delete($id))
{
$this->jump("id={$id}的记录删除成功！","?c=User");
}else
{
$this->jump("id={$id}的记录删除失败！","?c=User");
}

}

//添加数据,显示表单
public function add()
{
//验证
$this->isLogin();
$this->smarty->display('add.html');
}

//添加数据,保存数据
public function insert()
{
//验证
$this->isLogin();
// 取数据
$data['id'] 		= $_POST['id'];
$data['username'] 		= $_POST['username'];
$data['name'] 		= $_POST['name'];
$data['password'] 	= md5($_POST['password']);
$data['addate'] 	= time();
$data['tel'] 		= $_POST['tel'];


if(UserModel::getInstance()->rowCount("username='{$data['username']}'"))
{
$this->jump("用户名{$data['username']}抱歉，账号已经被注册了！请重新注册","?c=User&a=add");
}



// 保存数据
//$modelObj=UserModel::getInstance();
if(UserModel::getInstance()->insert($data))
{
$this->jump("添加记录成功！","?c=User");
}else
{
$this->jump("添加记录失败！","?c=User");
}

}
//修改数据，显示表单
public function edit()
{
$this->isLogin();
//获取id值
$id = $_GET['id'];
//取数据
$user = UserModel::getInstance()->fetchOne("id=$id");
$this->smarty->assign("user",$user);
$this->smarty->display('edit.html');
}

//修改数据，保存数据
public function update()
{
$this->isLogin();
$id	= $_POST['id'];
$data['username'] 		= $_POST['username'];
$data['name'] 		= $_POST['name'];
$data['password'] 	= md5($_POST['password']);
$data['addate'] 	= $_POST['addate'];
$data['tel'] 		= $_POST['tel'];


//判断密码是否为空？
if(!empty($_POST['password']) && !empty($_POST['confirmpwd']))
{
//判断是否一致
if($_POST['password']==$_POST['confirmpwd'])
{
$data['password'] = md5($_POST['password']);
}
}

//判断记录是否更新成功
if(UserModel::getInstance()->update($data,$id))
{
$this->jump("id={$id}记录更新成功！","?c=User");
}else
{
$this->jump("id={$id}记录更新失败！","?c=User");
}
}


//用户登录，显示登录界面
public function login()
{
$this->smarty->display("login.html");
}

//用户登录
public function loginCheck()
{

$username = $_POST['username'];
$password = md5($_POST['password']);
$verify   = strtolower($_POST['verify']);

// 验证码
if($verify!=$_SESSION['captcha'])
{
$this->jump("验证码不一致！","?c=User&a=login");
}
// 验证密码是否正确
$user = UserModel::getInstance()->fetchOne("username='$username' and password='$password'");
if(!$user)
{
$this->jump("用户名或密码不正确！","?c=User&a=login");
}
// status
if($user['status']==0)
{
$this->jump("账号给停用！","?c=User&a=login");
}
// 更新user表信息
$data['last_login_ip']   = $_SERVER['REMOTE_ADDR'];
$data['login_times']	 = $user['login_times']+1;
if(!UserModel::getInstance()->update($data,$user['id']))
{
$this->jump("用户信息更新不成功！","?c=User&a=login");
}
// 保存登录信息
$_SESSION['username']	= $user['username'];
$_SESSION['uid']        = $user['id'];
$_SESSION['name']        = $user['name'];
// 跳转到管理员页面
header("location:./admin.php");
}

//生成验证码：
public function captcha()
{
//图片生成
$captcha = new \Frame\Vendor\Captcha();
$_SESSION['captcha']=$captcha->getCode();
}

//退出登录
public function logout()
{
//删除登录信息
unset($_SESSION['username']);
unset($_SESSION['uid']);
unset($_SESSION['name']);
//删除session信息
session_destroy();
header("location:admin.php?c=User&a=login");
}

}