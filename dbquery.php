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
			die("���ܴ������". mysql_error());
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
			die("���ܴ������". mysql_error());
		}

$query="CREATE TABLE  consuchannel
		(
			sid int NOT NULL,
			cid int NOT NULL
	    )ENGINE=MyISAM DEFAULT CHARSET=gb2312";
        if(! mysql_query($query))
		{
			die("���ܴ������". mysql_error());
		}
		$query="CREATE TABLE channel
		(
			cid int NOT NULL AUTO_INCREMENT,
			primary key (cid),
			cname varchar(100)
		) ENGINE=MyISAM DEFAULT CHARSET=gb2312";
		if(! mysql_query($query))
		{
			die("���ܴ������". mysql_error());
		}*/
/*echo $db->insertDB("person",array( 'employeenum'=>'2',
								   'name'=>'������',
								   'pwd'=>md5('123456')));
								   */
//$result=$db->queryFullDB("person");

//echo $result[0]['name'];
//echo $result[1]['pwd'];
//$qryValue=array('1','1','������');
//$operator=array('=','=','=');
//$qryField=array('employeenum','id','name');
//$rltField="*";
//$qryField=array('cid');
//$qryOperator=array('=');
//$qryValue=array(2);

//$count=$db->queryCountDB('post',$qryField,$qryOperator,$qryValue);
//echo $count;
//�˴��ش�����м�,rltField���˴�*�ŵģ���ҪŪ��array��ʽ
 // ͬ��$qryField $qryOperator,$qryValueһ��Ҫ��array��ʽ
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
$updateValue=array('�¿�','3');
echo $db->SingleUpdateDB('person',$updateField,$updateValue,$qryField,$operator,$qryValue);*/
//echo $db->SingleDeleteDB('person',$qryField,$operator,$qryValue);

class database{
	static $DB = "ABC";
    var $sql = 0;
	//�Ժ���չ�� mysql_pconnect()
	var $pconnect = 0;
	var $usr;
	var $pwd;
	//���캯��
    function __construct()
	{
		$this->usr = 'root';
		$this->pwd = 'root';
		
		$this->connect();
	}
	//���Ӻ��������캯���ڵ���
	function connect()
	{
		$this->sql = @mysql_connect("localhost",$this->usr,$this->pwd,true);
		if(!$this->sql)
			{
				die('�������ӵ����ݿ⣺'.mysql_error());
			}
	}
	//�������ݿ�
    function select()
	{
		if($this->sql == 0)
			die('��Ӧ�����������ݿ�');
		mysql_select_db($DB) or die(mysql_error());
	}
	//�ر�����
	function close()
	{
		($this->sql !== 0) && mysql_close($this->sql);
	}
	function getId()
	{
		return mysql_insert_id($this->sql);
	}
    /**
	  *���ܺ�����������ʱ������ת����sql���Ե�һ����
	  *@params $tabelName �������
	  *        $content ����
	  *@return ����ɹ�(...)VALUES(...) ���� false
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

	//�������ݣ������û�ʹ��
	//$tableName:������ƣ��Ѵ��ڣ�
	//$content:�������� 'key'=>'value'
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
		*@param $tableName �������
		*@param $query ��ѯ���
		*@return false ���� ��ά����
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
		*���ر��з��������ĸ��������صĲ������飬������
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
		*���ر�������
		*@param $tableName �������
		*		$start     ��ʼλ��
		*       $interval  ���
		*@result           �ɹ��������������ݣ�ʧ�ܣ�false
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
		*parseSingleQuery:��������֣������������ѯ����������������ѯֵ ת���ɵ���sql���
		*@param $tableName �����
		*       $rltField  �������
		*       $qryField  ��ѯ����
		*       $operator  ������
		*       $qryValue  ��ѯֵ
		*@result          ��ά����
		**/
	public function parseSingleQuery($tableName,$rltField,$qryField,$operator,$qryValue,$start=0,$interval=30,$orderid=array(),$seq="")
	{
		
		$result=$this->parseSingleQueryNoLimit($tableName,$rltField,$qryField,$operator,$qryValue,$orderid,$seq);
		$result = $result." limit ".$start." , ".$interval;
		
		return $result;
		
	}
	//��������:
	//$tableName:�������(�Ѵ���)
	//$update:�������
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
		*deleteDB:�����ݿ���ɾ����¼
		*@param	$tableName ���ݿ�����
		*		$delete		ɾ�����
		*@return �ɹ� true, ʧ��false
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
	//�������������ǲ��������ݿ���
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
	//��������ֶ��ǲ��Ǳ���е��ֶ�
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

	//��ʼ�������ݿ⼰��ر��
	public  static function createDB($usr,$pwd)
	{
		$con = mysql_connect("localhost",$usr,$pwd);
		if(!$con){
			die('�������ӵ����ݿ⣺'.mysql_error());
		}
		//�������ݿ�ABC
		
		$query="CREATE DATABASE ".database::$DB;
		if(! mysql_query($query,$con))
		{
			die( "���ܴ������ݿ⣺". mysql_error());
		}
		//�������ݿ�ABC
        mysql_select_db(database::$DB) or die(mysql_error());

		//���������Ա�����ӣ���������Դ�����
		//ְ����id, ���ţ����֣����룬Ȩ�ޣ���½ip������״̬
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
			die("���ܴ������". mysql_error());
		}
        
        //���ӱ�����id(tid),������id(id),ģ��id(cid),���ӱ���(tname)
		//        ��������(tcontent),���ӻ�����Ŀ(tcount),����ʱ��(tdate)
		//        ����ip(tip)
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
			die("���ܴ������". mysql_error());
		}
        //����������id(pid),����id(tid),������id(id),��������(pname)
		//        ����ʱ��(pname),��������(pcontent),����ʱ��(pdate),
		//        ����ip(pip)
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
			die("���ܴ������". mysql_error());
		}
		//һ��ģ���
		$query="CREATE TABLE suchannel
		(
			sid int NOT NULL AUTO_INCREMENT,
			primary key (sid),
			sname varchar(100)
		) ENGINE=MyISAM DEFAULT CHARSET=gb2312";
		if(! mysql_query($query))
		{
			die("���ܴ������". mysql_error());
		}
        //����������ģ���ģ��id(cid),ģ������(cname)
		$query="CREATE TABLE channel
		(
			cid int NOT NULL AUTO_INCREMENT,
			primary key (cid),
			cname varchar(100)
		) ENGINE=MyISAM DEFAULT CHARSET=gb2312";
		if(! mysql_query($query))
		{
			die("���ܴ������". mysql_error());
		}
		//һ��ģ�������ģ��֮��Ĺ�ϵ
		$query="CREATE TABLE  consuchannel
		(
			sid int NOT NULL,
			cid int NOT NULL
	    )ENGINE=MyISAM DEFAULT CHARSET=gb2312";
        if(! mysql_query($query))
		{
			die("���ܴ������". mysql_error());
		}
		//����ģ��������ģ��֮��Ĺ�ϵ


		//��Դ��
		$query="CREATE TABLE resource
		(
			rid long NOT NULL AUTO_INCREMENT,
			primary key (rid),
			rname varchar(100),
			rurl varchar(200)
		) ENGINE=MyISAM DEFAULT CHARSET=gb2312";
		if(! mysql_query($query))
		{
			die("���ܴ������". mysql_error());
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
			die("���ܴ������". mysql_error());
		}
		$query="CREATE TABLE forum
		(
			fid int NOT NULL AUTO_INCREMENT,
			primary key (fid),
			cid int NOT NULL
		) ENGINE=MyISAM DEFAULT CHARSET=gb2312";
		if(! mysql_query($query))
		{
			die("���ܴ������". mysql_error());
		}
		//readctl�������ο͵Ķ�Ȩ��
		//�ο�Ĭ���ǲ���д�ģ�����Ҫ����
		$query="CREATE TABLE readctl
		(
			rcid int NOT NULL AUTO_INCREMENT,
			primary key (rcid),
			cid int NOT NULL
		) ENGINE=MyISAM DEFAULT CHARSET=gb2312";
		if(! mysql_query($query))
		{
			die("���ܴ������". mysql_error());
		}
		//introduction������Щ���ֻ��һƪ�����
		$query="CREATE TABLE introduction
		(
			iid int NOT NULL AUTO_INCREMENT,
			primary key (iid),
			cid int NOT NULL,
			tid int NOT NULL
		) ENGINE=MyISAM DEFAULT CHARSET=gb2312";
		if(! mysql_query($query))
		{
			die("���ܴ������". mysql_error());
		}
		

	}
    

}

?>