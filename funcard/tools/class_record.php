<?php
require_once('verifi.php');
require_once('function.php');

class my_record extends recording
{
	public function find_record()
	{
		$result = dbconn("SELECT consumption_record.time, FROM consumption_record WHERE consumption_record.uid = '".$user_id."' AND consumption_record.cid = ".$cid) or die("my score record error");
		while ($line = mysql_fetch_array($result, MYSQL_ASSOC))
		{
			array_push($r, $line);
		}
	}
	
	public function set_uid($uid)
	{
		$this->uid = $uid;
	}
	
	public function check_used()
	{
		$result = dbconn("SELECT time FROM consumption_record WHERE uid = ".$this->uid." and cid = ".$this->cid);
		$r = array();
		while ($line = mysql_fetch_array($result, MYSQL_ASSOC))
		{
			array_push($r, $line);
		}
		
		return $r;
	}
	
	public function find_card_by_uid()
	{
		return find_card_id_by_uid($this->uid);
	}
}