<?php
//声明命名空间
namespace Frame\Libs;

abstract class BaseModel
{
	// 受保护的PDO对象
	protected $pdo = null;
	// 构造方法
	public function __construct()
	{
		//创建PDOWrapper类的对象
		$this->pdo = new \Frame\Vendor\PDOWrapper();
	}
	
	//公共的静态的创建模型类对象的方法
	public static function getInstance()
	{
		//获取静态化方式调用的类名：
		$modelClassName = get_called_class();
		return new $modelClassName();
	}


	//取所有数据的方法
	public function fetchAll($orderby="id desc")
	{
		//sql语句
		$sql = "select * from {$this->table} order by id desc";
		//结果返回给控制器
		return $this->pdo->fetchAll($sql);	
	}


	public function delete($id)
	{
		//执行并返回结果
		$sql = "delete from {$this->table} where id ={$id}";
		return $this->pdo->exec($sql);
	}

	public function insert($data)
	{
		$keys = "";
		$values ="";
		foreach($data as $key=>$value)
		{
			$keys .= $key.",";
			$values .= "'".$value."',";
		}
		$keys = rtrim($keys,',');
		$values = rtrim($values,',');	
		$sql = "insert into {$this->table}($keys) values($values)";
		//echo $sql;
		//die();
		return $this->pdo->exec($sql);
	}

	public function fetchOne($where="2>1")
	{
		//取db的第一条记录
		$sql = "select * from {$this->table} where {$where}";
		//echo $sql;
		//die();
		return $this->pdo->fetchOne($sql);
	}

	//数据更新
	public function update($data,$id)
	{
		$str = "";
		foreach($data as $key=>$value)
		{
			$str .= "{$key}='{$value}',";
		}
		$str = rtrim($str,",");
		$sql = "update {$this->table} set {$str} where id={$id}";	
		return $this->pdo->exec($sql);
	}

	//记录总数
	public function rowCount($where="3>1")
	{
		$sql = "select * from {$this->table} where {$where}";
		return $this->pdo->rowCount($sql);
	}

}