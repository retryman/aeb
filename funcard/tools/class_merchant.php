<?php
require_once('verifi.php');

class my_merchant extends merchant
{
	public function find_my_e_coupon($cid)//find e-coupon by id
	{
		//$coupon = dbconn("select consumption_coupon.cid,consumption_coupon.title,consumption_coupon.score,consumption_coupon.used,consumption_coupon.price,consumption_coupon.mid from consumption_coupon where cid = ".$cid);
		
		$i = $this->check_e_coupon($cid);
		
		$result = array();
		if($i)
		{
			$result = $this->find_e_coupon_by_cid($cid);
		}
		
		return $result;
	}
	
	private function check_e_coupon($cid)//check weather this coupon is an e-coupon
	{
		$try = dbconn("select consumption_coupon.cid from consumption_coupon,extra_coupon_value where consumption_coupon.cid = ".$cid." AND consumption_coupon.cid = extra_coupon_value.cid AND extra_coupon_value.item_id = 8 AND extra_coupon_value.value = 1;");
		
		$i = false;
		while ($line = mysql_fetch_array($try, MYSQL_ASSOC))
		{
			$i = true;
		}
		
		return $i;
	}
	
	private function find_e_coupon_by_cid($cid, $long = true)
	{
		$result = array();
		$des_arr = array();
		if($long)
		{
			$coupon = dbconn("select consumption_coupon.cid,consumption_coupon.title,consumption_coupon.score,consumption_coupon.used,consumption_coupon.price, consumption_coupon.count, consumption_coupon.mid,extra_coupon_value.value FROM consumption_coupon,extra_coupon_value WHERE consumption_coupon.cid = ".$cid." AND consumption_coupon.cid = extra_coupon_value.cid AND extra_coupon_value.item_id = 9;");
			
			$des = dbconn("SELECT value AS des FROM extra_coupon_value WHERE cid = ".$cid." AND item_id = 10");
			while ($line = mysql_fetch_array($des, MYSQL_ASSOC))
			{
				array_push($des_arr, $line);
			}
		}
		else
		{
			$coupon = dbconn("select consumption_coupon.cid, consumption_coupon.title, consumption_coupon.score, consumption_coupon.count, extra_coupon_value.value FROM consumption_coupon,extra_coupon_value WHERE consumption_coupon.cid = ".$cid." AND consumption_coupon.cid = extra_coupon_value.cid AND extra_coupon_value.item_id = 9;");
		}
		
		while ($line = mysql_fetch_array($coupon, MYSQL_ASSOC))
		{
			if($des_arr != null)
			{
				//$result[0]['des'] = $des_str;
				$des_arr = array_merge($line, $des_arr[0]);//add the coupon's describe
				
				array_push($result, $des_arr);
			}
			else
			{
				array_push($result, $line);//if this coupon has no describe, give it a empty one
				$result[0]['des'] = '';
			}
		}
		//print_r($result);
		
		return $result;
	}
	
	public function find_all_e_coupon($limit = 0)
	{
		if($limit == 0)
		{
		$coupon = dbconn("select consumption_coupon.cid from consumption_coupon,extra_coupon_value where consumption_coupon.cid = extra_coupon_value.cid AND extra_coupon_value.item_id = 8 AND extra_coupon_value.value = 1 ORDER BY consumption_coupon.cid DESC;");//all e-coupons
		}
		else
		{
			$coupon = dbconn("select consumption_coupon.cid from consumption_coupon,extra_coupon_value where consumption_coupon.cid = extra_coupon_value.cid AND extra_coupon_value.item_id = 8 AND extra_coupon_value.value = 1 ORDER BY consumption_coupon.cid DESC LIMIT ".$limit);//all e-coupons
		}
		
		//find all e-coupon's pic dir
		
		$result = array();
		while ($line = mysql_fetch_array($coupon, MYSQL_ASSOC))
		{
			$arr = $this->find_e_coupon_by_cid($line['cid'], false);
			array_push($result, $arr[0]);
			//array_push($result, $line['cid']);
		}
		
		return $result;
	}
}