<?php
//声明命名空间
namespace Frame\Vendor;

//定义最终的Pager类
final class Pager
{
	//私有的成员属性
	private $records;	//总记录数
	private $pages;		//总页数
	private $pagesize;	//每页显示多少条记录
	private $page;		//当前页码
	private $url;		//链接地址
	private $first;		//首页
	private $last;		//尾页
	private $prev;		//上一页
	private $next;		//下一页

	//构造方法
	public function __construct($records,$pagesize,$page,$params=array())
	{
		$this->records	= $records;
		$this->pagesize	= $pagesize;
		$this->pages	= $this->getPages();
		$this->page		= $page;
		$this->url		= $this->getUrl($params); //?c=Article&a=index&page=
		$this->first	= $this->getFirst();//?c=Article&a=index&page=1
		$this->last		= $this->getLast(); //?c=Article&a=index&page=50
		$this->prev		= $this->getPrev(); //?c=Article&a=index&page=5
		$this->next		= $this->getNext();//?c=Article&a=index&page=7
	}

	//链接地址
	private function getUrl($params=array())
	{
		foreach($params as $key=>$value)
		{
			$arr[] = "$key=$value";
		}
		return "?".implode("&",$arr)."&page=";
		//?c=Article&a=index&page=
	}

	//总页数
	private function getPages()
	{
		return ceil($this->records/$this->pagesize);
	}

	//首页
	private function getFirst()
	{
		if($this->page==1){
			return "[首页]";
		}else{
			return "[<a href='{$this->url}1'>首页</a>]";
		}
	}

	//尾页
	private function getLast()
	{
		if($this->page==$this->pages){
			return "[尾页]";
		}else{
			return "[<a href='{$this->url}{$this->pages}'>尾页</a>]";
		}
	}

	//上一页
	private function getPrev()
	{
		if($this->page==1)
		{
			return "[上一页]";
		}else
		{
			return "[<a href='{$this->url}".($this->page-1)."'>上一页</a>]";
		}
	}

	//下一页
	private function getNext()
	{
		if($this->page==$this->pages)
		{
			return "[下一页]";
		}else
		{
			return "[<a href='{$this->url}".($this->page+1)."'>下一页</a>]";
		}
	}
	//分页
	public function showPage()
	{
		if($this->pages>1)
		{
			$str = "共有{$this->records}条记录，每页显示{$this->pagesize}条记录，";
			$str .= "当前{$this->page}/{$this->pages} ";
			$str .= "{$this->first} {$this->prev} {$this->next} {$this->last}";
			return $str;
		}else
		{
			return "共有{$this->records}条记录";
		}
	}
}