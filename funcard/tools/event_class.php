<?php
require_once('function.php');
require_once('DB/db.php');
class events
{
	private $event_ID;
	private $class_content;
	private $stages;
	private $title;
	private $file_root;
	
	public function __construct($ID)
	{
		$this->event_ID = $ID;
		$this->select_current_class();
	}
	
	public function show()
	{
		echo 'ID is:'.$this->event_ID;
	}
	
	private function select_current_class()
	{
		$id = $this->event_ID;
		$result = dbconn("select event_title,file,stage from event where event_id = ".$id) or die("select_current_class failed");
		while($line = mysql_fetch_array($result, MYSQL_ASSOC))
		{
			$this->title = $line['event_title'];
			$this->file_root = 'event/'.$line['file'];
			$this->stages = $line['stage'];
		}
	}
	
	public function get_title()
	{
		return $this->title;
	}
	
	public function get_content()
	{
		@$fp = fopen($this->file_root, 'r'); //read file
  		if(!$fp)
 		 {
	 		echo " file open error ";
	  		echo $this->file_root;
			exit;
  		}
  		else
  		{
	  		while(!feof($fp))
	  		{
	  			$r = fgets($fp);
				$this->class_content .= $r;
	  		}
	  
	  		fclose($fp);
  		}
		return $this->class_content;
	}
	
	public function get_stage()
	{
		$this->stages = explode(";", $this->stages);
		foreach($this->stages as $S)
		{
			echo '<option value="'.$S.'">'.$S.'</option>';
		}
		//return $this->stages;
	}
	
	public function record_user($name, $password, $repassword, $email, $phone, $other)
	{
		if($other == "")
		{
			$other = "na";
		}
		return register($name, $password, $repassword, $email, $phone, $other);
	}
	
	public function event_reg($user_id, $regtime, $stage)//record user for event
	{
		$reuslt = dbconn("insert into event_register (uid, eid, time, stage) values('".$user_id."', '".$this->event_ID."', '".$regtime."', '".$stage."')") or die("event reg failed");
	}
	
	public function record_user_more($user_id, $baby_name, $baby_sex, $baby_birth_YMD, $parent_name, $adress)
	{
		$baby_birth = $this->date_to_time_stamp($baby_birth_YMD);
		$reuslt = dbconn("insert into user_extra_info (uid, baby_name, baby_sex, baby_birth, parent_name, adress) values('".$user_id."', '".$baby_name."', '".$baby_sex."', '".$baby_birth."', '".$parent_name."', '".$adress."')") or die("record_user_more failed");//record more info
		
		//record to the extra value table;
		$R2 = dbconn("insert into extra_item_value ");
	}
	
	public function find_user_id($name)
	{
		return findUserIdbyName($name);
	}
	
	private function date_to_time_stamp($time_YMD)
	{
		$t = explode("-", $time_YMD);
		$stamp = mktime(0, 0, 0, $t[1], $t[2], $t[0]);
		return $stamp;
	}
	
	private function time_stamp_to_date($stamp)
	{
		$t = date("Y-m-d", $stamp);
		return $t;
	}
	
	public function search_reigster()
	{
		$result = dbconn("SELECT coupon_user.uid,coupon_user.name,coupon_user.mail,coupon_user.phone,coupon_user.other, card.card_id, event_register.eid,event_register.time,event_register.stage, user_extra_info.baby_name,user_extra_info.baby_sex,user_extra_info.baby_birth,user_extra_info.parent_name,user_extra_info.adress FROM coupon_user, card, event_register LEFT JOIN user_extra_info ON event_register.uid = user_extra_info.uid WHERE event_register.eid = '".$this->event_ID."' AND coupon_user.uid = event_register.uid AND card.uid = event_register.uid;");
		while ($line = mysql_fetch_array($result, MYSQL_ASSOC))
		{
			//print_r($line);
			echo '<br/>'.
			' '.$line['uid'].
			','.$line['name'].
			','.$line['mail'].
			','.$line['phone'].
			','.$line['other'].
			','.$line['card_id'].
			','.$line['eid'].
			','.$line['time'].
			','.$line['stage'].
			','.$line['baby_name'].
			','.$line['baby_sex'].
			','.$line['baby_birth'].
			','.$line['parent_name'].
			','.$line['adress']
			.'';
		}
	}
	
	public function search_all_title()
	{
		$result = dbconn("select event_id, event_title from event");
	
		echo '<select name="event" id="event">';
		while ($line = mysql_fetch_array($result, MYSQL_ASSOC))
		{
			echo '
			<option value="'.$line['event_id'].'">'.$line['event_title'].'</option>
			';
		}
		echo '</select>';
	}
	
	public function add_event($title, $file, $stage)
	{
		$result = dbconn("insert into event (event_title, file, stage) values ('".$title."', '".$file."', '".$stage."')") or die("add_event error");;
	}
}

class uploader
{
	public function upload_file($filename, $fileTempName, $saveName)
	{
		$upload = new upload("../event/", "txt", $filename, $fileTempName, $saveName);
		$upload->upload_file();
	}
	
	public function update_DB($title, $filename, $stage)
	{
	}
}
?>