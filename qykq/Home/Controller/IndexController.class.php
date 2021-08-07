<?php
namespace Home\Controller;
use Frame\Libs\BaseController;
use Home\Model\IndexModel;


class IndexController extends BaseController
{
	public function index()
	{
	    //最简单的验证
                $this->isLogin1();
                $id = $_SESSION['id'];
                $working = IndexModel::getInstance()->fetchOneWithJoin($id);
                $this->smarty->assign("working",$working);
                $this->smarty->display("index.html");
            }


            //修改数据--显示修改表单
            public function Changepassword()
            {
                $this->isLogin1();
                $id = $_SESSION['id'];//获取id值
                $stus = IndexModel::getInstance()->fetchOne("id={$id}"); //取数据
                $this->smarty->assign("stus",$stus);
                $this->smarty->display('Changepassword.html');
            }

            //修改数据,保存数据
            public function update()
            {

                // 把数据取过来
                $id             = $_SESSION['id'];
                $data['password']    = md5($_POST['password']);

                //记录是否更新
                if(IndexModel::getInstance()->update($data,$id))
                {
                    $this->jump("id={$id}记录更新成功！","?c=Index&index");
                }else
                {
                    $this->jump("id={$id}记录更新失败！","?c=Index&index");
                }
            }

            public function login(){
                $this->smarty->display("login.html");
            }

            //用户登录
            public function loginCheck()
            {
                // 取表单数据
                $id = $_POST['id'];
                $password = md5($_POST['password']);
                $verify   = strtolower($_POST['verify']);

                // 判断验证码
                if($verify!=$_SESSION['captcha'])
                {
                    $this->jump("验证码不一致！","?c=index&a=login");
                }

                // 验证密码
                $stu = IndexModel::getInstance()->fetchOne("id='$id' and password='$password'");
                if(!$stu)
                {
                    $this->jump("用户名或密码不正确！","?c=Index&a=login");
                }

                // 保存用户登录信息
                $_SESSION['id']	= $stu['id'];
                $_SESSION['username']= $stu['username'];

                // 跳到前台zhu界面
                header("location:./index.php");
            }

            //验证码生成：
            public function captcha()
            {
                //生成图片
                $captcha = new \Frame\Vendor\Captcha();
                $_SESSION['captcha']=$captcha->getCode();
            }

            //退出登录
            public function logout()
            {
                //删除登录信息
                unset($_SESSION['id']);
                unset($_SESSION['username']);
                //delete session
                session_destroy();
                header("location:index.php?c=index&a=login");
            }



        }