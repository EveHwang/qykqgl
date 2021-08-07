<?php
//声明命名空间
namespace Frame\Vendor;
use \PDOException;
use \PDO;
//定义最终的PDOwrapper类
class PDOWrapper
{
	//数据库的配置信息
	private $db_type;//数据库类型
	private $db_port;//端口
	private $db_host;//主机名字
	private $db_name;//db名字
	private $db_user;
	private $db_pass;
	private $charset;
	//保存pdo对象
	private $pdo = null;

	// 构造方法
	public function __construct()
	{	
		$this->db_type = $GLOBALS['config']['db_type'];
		$this->db_port = $GLOBALS['config']['db_port'];
		$this->db_host = $GLOBALS['config']['db_host'];
		$this->db_name = $GLOBALS['config']['db_name'];
		$this->db_user = $GLOBALS['config']['db_user'];
		$this->db_pass = $GLOBALS['config']['db_pass'];
		$this->charset = $GLOBALS['config']['charset'];

		$this->createPDO();
		$this->setErrorMode();
	}

	//1、创建PDO对象
	private function createPDO()
	{
		try{
			$dsn = "{$this->db_type}:host={$this->db_host};port={$this->db_port};dbname={$this->db_name};charset={$this->charset}";
			$this->pdo = new PDO($dsn,$this->db_user,$this->db_pass);
		}catch(PDOException $e)
		{
			echo "创建PDO对象失败！";
			echo "<br>错误编号：".$e->getCode();
			echo "<br>错误文件：".$e->getFile();
			echo "<br>错误行号：".$e->getLine();
			echo "<br>错误信息：".$e->getMessage();
			die();
		}
	}
	
	//2、设置相关参数，特别错误模式
	private function setErrorMode()
	{
		$this->pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	}

	//格式化错误显示
	private function showErrorMsg($e)
	{
		echo "执行SQL语句失败，请检查你的SQL语句！";
		echo "<br>错误编号：".$e->getCode();
		echo "<br>错误文件：".$e->getFile();
		echo "<br>错误行号：".$e->getLine();
		echo "<br>错误信息：".$e->getMessage();
		die();
	}
	
	//执行sql语句：insert update delte exec($sql)
	public function exec($sql)
	{
		try{
			return $this->pdo->exec($sql);
		}catch(PDOException $e)
		{
			$this->showErrorMsg($e);
		}
	}

	//fetchOne取一行数据
	public function fetchOne($sql)
	{
		try{
			$PDOStatement = $this->pdo->query($sql);
			return $PDOStatement->fetch(PDO::FETCH_ASSOC);
		}catch(PDOException $e)
		{
			$this->showErrorMsg($e);
		}
	}

	//fetchAll取多行数据
	public function fetchAll($sql)
	{
		try{
			$PDOStatement = $this->pdo->query($sql);
			return $PDOStatement->fetchAll(PDO::FETCH_ASSOC);
		}catch(PDOException $e)
		{
			$this->showErrorMsg($e);
		}
	}

	//rowCount返回查询记录总结
	public function rowCount($sql)
	{
		try{
			$PDOStatement = $this->pdo->query($sql);
			return $PDOStatement->rowCount();
		}catch(PDOException $e)
		{
			$this->showErrorMsg($e);
		}
	}

}