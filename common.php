<?php
$topicInterval=2;
$postInterval=2;
/**
  * 是否是数组
  *@param $array
  *@return boolean
  */
function isArray($array)
{
	return(!is_array($array) || !count($array)) ? false : true;
}
/**
	*重定向
	**/
function redirect($url)
{
	header("HTTP/1.1 303 see Other");
	Header("Location: ".$url);
	exit;
}	
/**
	*得到ip
	**/
function getOnlineIp() {
    $onlineip = '';
    if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
        $onlineip = getenv('HTTP_CLIENT_IP');
    } elseif(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
        $onlineip = getenv('HTTP_X_FORWARDED_FOR');
    } elseif(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
        $onlineip = getenv('REMOTE_ADDR');
    } elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
        $onlineip = $_SERVER['REMOTE_ADDR'];
    }
    return $onlineip;
}
function isAuthorized($privilege,$cid)
{
	$id=intval($cid)-1;
	$access = substr($privilege,$id,1);
	return ($access == "1");
}
?>