<?php
require_once('common.php');
//database::createDB("root","root");

$db = new database();

mysql_select_db(database::$DB) or die(mysql_error());



/*$query="CREATE TABLE forum
		(
			fid int NOT NULL AUTO_INCREMENT,
			primary key (fid),
			cid int NOT NULL
		) ENGINE=MyISAM DEFAULT CHARSET=gb2312";
		if(! mysql_query($query))
		{
			die("不能创建表格：". mysql_error());
		}*/

/*$content=array('name'=>'sheq');
$db->insertDB('example',$content);

echo $db->getId();*/
/*mysql_select_db(database::$DB) or die(mysql_error());
$query="CREATE TABLE suchannel
		(
			sid int NOT NULL AUTO_INCREMENT,
			primary key (sid),
			sname varchar(100)
		) ENGINE=MyISAM DEFAULT CHARSET=gb2312";
		if(! mysql_query($query))
		{
			die("不能创建表格：". mysql_error());
		}

$query="CREATE TABLE  consuchannel
		(
			sid int NOT NULL,
			cid int NOT NULL
	    )ENGINE=MyISAM DEFAULT CHARSET=gb2312";
        if(! mysql_query($query))
		{
			die("不能创建表格：". mysql_error());
		}
		$query="CREATE TABLE channel
		(
			cid int NOT NULL AUTO_INCREMENT,
			primary key (cid),
			cname varchar(100)
		) ENGINE=MyISAM DEFAULT CHARSET=gb2312";
		if(! mysql_query($query))
		{
			die("不能创建表格：". mysql_error());
		}*/
/*echo $db->insertDB("person",array( 'employeenum'=>'2',
								   'name'=>'沈世卿',
								   'pwd'=>md5('123456')));
								   */
//$result=$db->queryFullDB("person");

//echo $result[0]['name'];
//echo $result[1]['pwd'];
//$qryValue=array('1','1','沈世卿');
//$operator=array('=','=','=');
//$qryField=array('employeenum','id','name');
//$rltField="*";
//$qryField=array('cid');
//$qryOperator=array('=');
//$qryValue=array(2);

//$count=$db->queryCountDB('post',$qryField,$qryOperator,$qryValue);
//echo $count;
//此处重大错误切忌,rltField除了带*号的，都要弄成array形式
 // 同样$qryField $qryOperator,$qryValue一定要是array形式
/*$rltField = "*";
	$qryField = array("cid");
	$qryOperator = array("=");
	$qryValue =array(1);
	$result = $db->singleQueryDB('topic',$rltField,$qryField,$qryOperator,$qryValue,0,30,array('tid'),"1");
	var_dump($result);*/

/*$rltField=array('name','pwd','ip');
echo $db->parseSingleQuery('person',$rltField,$qryField,$operator,$qryValue);
$result=$db->SingleQueryDB('person',$rltField,$qryField,$operator,$qryValue);
echo $result[0]['name'];
echo $result[0]['pwd'];
echo $result[0]['ip'];
$updateField=array('name','employeenum');
$updateValue=array('陈科','3');
echo $db->SingleUpdateDB('person',$updateField,$updateValue,$qryField,$operator,$qryValue);*/
//echo $db->SingleDeleteDB('person',$qryField,$operator,$qryValue);

class database{
	static $DB = "ABC";
    var $sql = 0;
	//以后扩展用 mysql_pconnect()
	var $pconnect = 0;
	var $usr;
	var $pwd;
	//构造函数
    function __construct()
	{
		$this->usr = 'root';
		$this->pwd = 'root';
		
		$this->connect();
	}
	//连接函数，构造函数内调用
	function connect()
	{
		$this->sql = @mysql_connect("localhost",$this->usr,$this->pwd,true);
		if(!$this->sql)
			{
				die('不能连接到数据库：'.mysql_error());
			}
	}
	//连接数据库
    function select()
	{
		if($this->sql == 0)
			die('你应该先连接数据库');
		mysql_select_db($DB) or die(mysql_error());
	}
	//关闭连接
	function close()
	{
		($this->sql !== 0) && mysql_close($this->sql);
	}
	function getId()
	{
		return mysql_insert_id($this->sql);
	}
    /**
	  *功能函数：将插入时候数组转换成sql语言的一部分
	  *@params $tabelName 表格名字
	  *        $content 数组
	  *@return 如果成功(...)VALUES(...) 否则 false
	  */
	private function parseInsertDB($tableName,$content)
	{
		$field="(";
		$fldValue="(";
		if(!isArray($content))
			return false;
		if(!$this->checkTable($tableName))
			return false;
		foreach($content as $key => $value)
		{
			if(!$this->checkField($tableName,$key))
				return false;
			else
			{
				$field = $field.$key.",";
				$fldValue = $fldValue."'".$value."',";
			}
		}
		$field=substr_replace($field,')',-1);
		$fldValue=substr_replace($fldValue,')',-1);
		return $field." VALUES ".$fldValue;
	}

	//插入数据：方便用户使用
	//$tableName:表格名称（已存在）
	//$content:数组类型 'key'=>'value'
	public function insertDB($tableName,$content)
	{
		if(!$this->sql)
			$this->connect();
		$query = $this->parseInsertDB($tableName,$content);
		
		if($query)
		{
			$query = "INSERT INTO ".$tableName." ".$query;
			
			mysql_query("SET NAMES 'GB2312'"); 
			mysql_query($query) or die (mysql_error());
		}
	}
	/**
		*queryDB select
		*@param $tableName 表格名字
		*@param $query 查询语句
		*@return false 或者 二维数组
		*/
	public function queryDB($tableName,$query)
	{
		if(!$this->sql)
			$this->connect();
		if(!$this->checkTable($tableName))
			return false;
		if(!$query)
			return false;
		mysql_query("SET NAMES 'GB2312'"); 
		$qryresult = mysql_query($query) or die(mysql_error());
        $result=array();
		while($row = mysql_fetch_array($qryresult))
		{
			array_push($result,$row);
		}
		return $result;

	}
	/**
		*返回表中符合条件的个数，返回的不是数组，是数字
		**/
	public function queryCountDB($tableName,$qryField,$operator,$qryValue)
	{
		if(!$this->sql)
			$this->connect();
		$query=$this->parseSingleQueryNoLimit($tableName,"count(*)",$qryField,$operator,$qryValue);
		$qryresult = mysql_query($query) or die(mysql_error());
		$row = mysql_fetch_array($qryresult);
		return $row['count(*)'];
	}
	/**
		*返回表中数据
		*@param $tableName 表格名称
		*		$start     开始位置
		*       $interval  间隔
		*@result           成功：表中所有数据，失败：false
		**/

	public function queryFullDB($tableName,$start,$interval)
	{
		if(!$this->sql)
			$this->connect();
		$query = "select * from ".$tableName." limit ".$start." , ".$interval;
		return $this->queryDB($tableName,$query);
	}
	public function singleQueryDB($tableName,$rltField,$qryField,$operator,$qryValue,$start=0,$interval=30,$orderid=array(),$seq="")
	{
       if(!$this->sql)
		   $this->connect();
	   $query=$this->parseSingleQuery($tableName,$rltField,$qryField,$operator,$qryValue,$start,$interval,$orderid,$seq);
	   return $this->queryDB($tableName,$query);

	}
	
	public function parseSingleQueryNoLimit($tableName,$rltField,$qryField,$operator,$qryValue,$orderid=array(),$seq="")
	{
        $result = "select ";
		$count1 = 0;$count2=0;$count3=0;
		$count1= count($qryField);
		$count2= count($operator);
		$count3= count($qryValue);
		if(($count1!= $count2)|| ($count1!=$count3)||($count2!=$count3))
		{
			return false;
		}
		
		$ops=array("=",">","<",">=","<=","!=","like");
		//var_dump($operator);
		foreach($operator as $key=>$op)
		{
			
			if(!in_array($op,$ops))
				return false;
		}
		
        if(isArray($rltField) )
		{
			foreach($rltField as $key=>$field)
			{
				
				if(!$this->checkField($tableName,$field))
					return false;
				else
					$result = $result.$field.", ";
			}
			$result = substr_replace($result," ",-2);
		}
		else
		{
			$result=$result." ".$rltField." ";
		}
		if(!$this->checkTable($tableName))
			return false;
		$result = $result." from ".$tableName." where ";
		
	    $count=0;
		foreach($qryField as $key=>$field)
		{
			
			
			if(!$this->checkField($tableName,$field))
				return false;
			$result = $result.$field." ".$operator[$count]." "."'".$qryValue[$count]."' and ";
			$count++;
			
		}
		
		$result = substr_replace($result," ",-4);
        if(isArray($orderid))
		{
			foreach($orderid as $key=>$field)
			{
				if(!$this->checkField($tableName,$field))
					return $result;
			}
			$result= $result." order by ";
			foreach($orderid as $key=>$field)
				$result = $result.$field.",";
			$result = substr_replace($result," ",-1);
			if($seq == "1")
				$result = $result." desc ";
		}

		return $result;
	}
	/**
		*parseSingleQuery:将表格名字，结果段名，查询段名，操作符，查询值 转化成单条sql语句
		*@param $tableName 表格名
		*       $rltField  结果段名
		*       $qryField  查询段名
		*       $operator  操作符
		*       $qryValue  查询值
		*@result          二维数组
		**/
	public function parseSingleQuery($tableName,$rltField,$qryField,$operator,$qryValue,$start=0,$interval=30,$orderid=array(),$seq="")
	{
		
		$result=$this->parseSingleQueryNoLimit($tableName,$rltField,$qryField,$operator,$qryValue,$orderid,$seq);
		$result = $result." limit ".$start." , ".$interval;
		
		return $result;
		
	}
	//更新数据:
	//$tableName:表格名称(已存在)
	//$update:更新语句
	public function updateDB($tableName,$update)
	{
		if(!$this->sql)
			return false;
		if(!$this->checkTable($tableName))
			return false;
		mysql_query($update) or die(mysql_error());
		return true;
	}
	public  function singleUpdateDB($tableName,$updateField,$updateValue,$conField,$conOperator,$conValue)
	{
         if(!$this->sql)
		   $this->connect();
		 $result=$this->parseSingleUpdate($tableName,$updateField,$updateValue,$conField,$conOperator,$conValue);
		 return $this->updateDB($tableName,$result);
	}
	public function parseSingleUpdate($tableName,$updateField,$updateValue,$conField,$conOperator,$conValue)
	{
		if(!$this->checkTable($tableName))
			return false;
		$result = "update ";
		$count1 = 0;$count2=0;$count3=0; $count4=0;$count5=0;
		$count1= count($conField);
		$count2= count($conOperator);
		$count3= count($conValue);
		if(($count1!= $count2)|| ($count1!=$count3)||($count2!=$count3))
		{
			return false;
		}
		$count4= count($updateField);
		$count5= count($updateValue);
		if($count4!=$count5)
			return false;
		///////////////////////////////////////////////////////////////////
		$ops=array("=",">","<",">=","<=","!=");
		foreach($conOperator as $key=>$op)
		{
			
			if(!in_array($op,$ops))
				return false;
		}
		$result = $result.$tableName." set";
		$count=0;
		foreach($updateField as $key=>$field)
		{
			if(!$this->checkField($tableName,$field))
				return false;
			$result= $result." ".$field." =  '".$updateValue[$count]."',";
			$count++;
		}
		$result= substr_replace($result," ",-1)."where";
		$count=0;
		foreach($conField as $key=>$field)
		{
			if(!$this->checkField($tableName,$field))
				return false;
			$result=$result." ".$field." ".$conOperator[$count]." '".$conValue[$count]."' and";
			$count++;
		}
		$result = substr_replace($result," ",-3);
		return $result;

	}
	public  function addTable($tableName,$segment)
	{
		
	}
	public function emptyTable($tableName)
	{
		if(!$this->sql)
			return false;
		if(!$this->checkTable($tableName))
			return false;
		$empty = "TRUNCATE TABLE ".$tableName;
		mysql_query("SET NAMES 'GB2312'"); 
		mysql_query($empty) or die(mysql_error());
		
	}
	/**
		*deleteDB:从数据库中删除记录
		*@param	$tableName 数据库名字
		*		$delete		删除语句
		*@return 成功 true, 失败false
		**/
	public function deleteDB($tableName,$delete)
	{
		if(!$this->sql)
			return false;
		if(!$this->checkTable($tableName))
			return false;
		mysql_query("SET NAMES 'GB2312'"); 
		mysql_query($delete) or die(mysql_error());
		return true;
	}
	public function singleDeleteDB($tableName,$conField,$conOperator,$conValue)
	{
		if(!$this->sql)
			return false;
		$delete=$this->parseSingleDelete($tableName,$conField,$conOperator,$conValue);
		return $this->deleteDB($tableName,$delete);
		
	}
	public function parseSingleDelete($tableName,$conField,$conOperator,$conValue)
	{
		$result = "delete from ";
		if(!$this->checkTable($tableName))
			return false;
		$result= $result.$tableName." where";
		$count1 = 0;$count2=0;$count3=0;
		$count1= count($conField);
		$count2= count($conOperator);
		$count3= count($conValue);
		if(($count1!= $count2)|| ($count1!=$count3)||($count2!=$count3))
		{
			return false;
		}
		
		///////////////////////////////////////////////////////////////////
		$ops=array("=",">","<",">=","<=","!=","not in");
		foreach($conOperator as $key=>$op)
		{
			
			if(!in_array($op,$ops))
				return false;
		}
		$count=0;
		foreach($conField as $key=>$field)
		{
			if(!$this->checkField($tableName,$field))
				return false;
			$result= $result." ".$field." ".$conOperator[$count]." '".$conValue[$count]."' and";
			$count++;
		}
		$result = substr_replace($result,"",-3);
		return $result;
	}
	//查验给定表格名是不是在数据库中
	public function checkTable($tableName)
	{
		if(!$this->sql)
		{
			$this->connect();
		}
		$result = mysql_list_tables(database::$DB,$this->sql);
		
		if(!$result)
		{
			return false;
		}
		while($row = mysql_fetch_row($result))
		{
			
			if($row[0] == $tableName)
			{
				mysql_free_result($result);
				return true;
			}
		}
		mysql_free_result($result);
		return false;
	}
	//查验给定字段是不是表格中的字段
	public function checkField($tableName,$field)
	{
		if(!$this->sql)
		{
			$this->connect();
		}
		$result = mysql_list_fields(database::$DB,$tableName,$this->sql);
        
		if(!$result)
		{
			return false;
		}
		$columns = mysql_num_fields($result);
		
		for($i = 0; $i < $columns; $i++)
		{
			$temField = mysql_field_name($result,$i);
			if($temField == $field)
			{
				mysql_free_result($result);
				return true;
			}
		}
		mysql_free_result($result);
		return false;

	}

	//初始创建数据库及相关表格
	public  static function createDB($usr,$pwd)
	{
		$con = mysql_connect("localhost",$usr,$pwd);
		if(!$con){
			die('不能连接到数据库：'.mysql_error());
		}
		//创建数据库ABC
		
		$query="CREATE DATABASE ".database::$DB;
		if(! mysql_query($query,$con))
		{
			die( "不能创建数据库：". mysql_error());
		}
		//连接数据库ABC
        mysql_select_db(database::$DB) or die(mysql_error());

		//创建表格：人员，帖子，回帖，资源，板块
		//职工表：id, 工号，名字，密码，权限，登陆ip，申请状态
		$query="CREATE TABLE person
		(
			id int NOT NULL AUTO_INCREMENT,
			primary key (id),
			employeenum varchar(15) NOT NULL UNIQUE,
			name varchar(30) NOT NULL,
			pwd varchar(32) NOT NULL,
			wprivilege varchar(50),
			rprivilege varchar(50),
			ip varchar(16),
            checked tinyint(3)
			) ENGINE=MyISAM DEFAULT CHARSET=gb2312";
		if(! mysql_query($query))
		{
			die("不能创建表格：". mysql_error());
		}
        
        //帖子表：帖子id(tid),发帖人id(id),模块id(cid),帖子标题(tname)
		//        帖子内容(tcontent),帖子回帖数目(tcount),发帖时间(tdate)
		//        发帖ip(tip)
		$query="CREATE TABLE topic
		(
            tid int NOT NULL AUTO_INCREMENT,
			primary key (tid),
			id int NOT NULL,
			cid int NOT NULL,
			tname varchar(100),
			tcontent mediumtext,
			tcount int,
			tdate DATETIME,
			tip varchar(16)
		) ENGINE=MyISAM DEFAULT CHARSET=gb2312";
        if(! mysql_query($query))
		{
			die("不能创建表格：". mysql_error());
		}
        //回帖表：回帖id(pid),帖子id(tid),回帖人id(id),回帖标题(pname)
		//        回帖时间(pname),回帖内容(pcontent),回帖时间(pdate),
		//        回帖ip(pip)
		$query="CREATE TABLE post
		( 
			pid int NOT NULL AUTO_INCREMENT,
			primary key (pid),
			tid int NOT NULL,
			id int NOT NULL,
			cid int NOT NULL,
			pname varchar(100),
			pcontent mediumtext,
			pdate DATETIME,
			pip varchar(16)
		) ENGINE=MyISAM DEFAULT CHARSET=gb2312";
		if(! mysql_query($query))
		{
			die("不能创建表格：". mysql_error());
		}
		//一级模块表：
		$query="CREATE TABLE suchannel
		(
			sid int NOT NULL AUTO_INCREMENT,
			primary key (sid),
			sname varchar(100)
		) ENGINE=MyISAM DEFAULT CHARSET=gb2312";
		if(! mysql_query($query))
		{
			die("不能创建表格：". mysql_error());
		}
        //二级或三级模块表：模块id(cid),模块名字(cname)
		$query="CREATE TABLE channel
		(
			cid int NOT NULL AUTO_INCREMENT,
			primary key (cid),
			cname varchar(100)
		) ENGINE=MyISAM DEFAULT CHARSET=gb2312";
		if(! mysql_query($query))
		{
			die("不能创建表格：". mysql_error());
		}
		//一级模块与二级模块之间的关系
		$query="CREATE TABLE  consuchannel
		(
			sid int NOT NULL,
			cid int NOT NULL
	    )ENGINE=MyISAM DEFAULT CHARSET=gb2312";
        if(! mysql_query($query))
		{
			die("不能创建表格：". mysql_error());
		}
		//二级模块与三级模块之间的关系


		//资源表
		$query="CREATE TABLE resource
		(
			rid long NOT NULL AUTO_INCREMENT,
			primary key (rid),
			rname varchar(100),
			rurl varchar(200)
		) ENGINE=MyISAM DEFAULT CHARSET=gb2312";
		if(! mysql_query($query))
		{
			die("不能创建表格：". mysql_error());
		}
		$query="CREATE TABLE hotnews
		(
			hid int NOT NULL AUTO_INCREMENT,
			primary key (hid),
			hurl varchar(100),
            tid  int
		) ENGINE=MyISAM DEFAULT CHARSET=gb2312";
		if(! mysql_query($query))
		{
			die("不能创建表格：". mysql_error());
		}
		$query="CREATE TABLE forum
		(
			fid int NOT NULL AUTO_INCREMENT,
			primary key (fid),
			cid int NOT NULL
		) ENGINE=MyISAM DEFAULT CHARSET=gb2312";
		if(! mysql_query($query))
		{
			die("不能创建表格：". mysql_error());
		}
		//readctl表格控制游客的读权限
		//游客默认是不能写的，不需要控制
		$query="CREATE TABLE readctl
		(
			rcid int NOT NULL AUTO_INCREMENT,
			primary key (rcid),
			cid int NOT NULL
		) ENGINE=MyISAM DEFAULT CHARSET=gb2312";
		if(! mysql_query($query))
		{
			die("不能创建表格：". mysql_error());
		}
		//introduction控制哪些板块只有一篇进版词
		$query="CREATE TABLE introduction
		(
			iid int NOT NULL AUTO_INCREMENT,
			primary key (iid),
			cid int NOT NULL,
			tid int NOT NULL
		) ENGINE=MyISAM DEFAULT CHARSET=gb2312";
		if(! mysql_query($query))
		{
			die("不能创建表格：". mysql_error());
		}
		

	}
    

}

?>