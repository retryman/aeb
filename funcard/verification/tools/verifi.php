<?php
//include_once("../verification/tools/phpmailer/class.phpmailer.php");
//include_once("DB/db.php");

require_once(dirname(__FILE__).'/../../tools/function.php');

class user
{
	public $uid;
	public $username;
	public $password;
	private $log_in;
	public $card_ID;
	public $phone;
	
	public function Encode($str)
	{
		$code = md5($str);
		return $code;
	}
	
	public function user_login()
	{
		$password = Encode($this->password);
		$result = dbconn("select password from consumption_merchant where merchant_name = '".$this->username."'") or die("user_login failed");
	
	 // Printing results in HTML 
   // print "<table>\n"; 
    while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) 
	{ 
        //print "\t<tr>\n"; 
        foreach ($line as $col_value) 
		{
			if($col_value == $password)
			{
				//echo 'password correct';
				return true;
			}
			/*$i = 0;
			$user[$i] = $col_value;
			
			echo $user[$i]; //0 = id, 1 = name, 2 = password
			$i += 1;*/
            //print "\t\t<td>$col_value</td>\n";
        }
       // print "\t</tr>\n"; 
    } 
   // print "</table>\n";
	
    /* Free resultset */ 
    mysql_free_result($result);
	return false; 
	}
	
	public function find_merchant_id()
	{
		$this->uid = findMerchantIDbyName($this->username);
		return $this->uid;
	}
	
	public function verification_funcard()
	{
		return verification($this->card_ID, $this->phone);
	}
}

class merchant
{
	public $mid;
	public $name;
	public $cid;
	public $score;
	public $counts;
	public $title;
	public $password;
	public $used;
	public $price;
	public $fullname;
	
	public $fileName;
	public $fileTempName;
	private $manual_dir;
	
	public function find_my_coupon()
	{
		$coupon = dbconn("select consumption_coupon.cid, consumption_coupon.title from consumption_coupon, extra_coupon_value where mid = ".$this->mid." and extra_coupon_value.value = 0 and extra_coupon_value.item_id = 8 and extra_coupon_value.cid = consumption_coupon.cid;");
		$i = 1;
		$cid = 0;
		$score = 0;
		$count = 0;
		echo '<ul class="verifi_my_coupon">我的优惠券：';
		while ($line = mysql_fetch_array($coupon, MYSQL_ASSOC))
		{
			//print_r($line);
			/*echo '</br>score is '.$score.'; count is '.$count.'; title is'. $title.'|||';
			echo '<a href="show_coupon.php?cid='.$cid.'">go to coupon</a>';*/
			echo '<li><a href="show_coupon.php?cid='.$line["cid"].'">'.$line["title"].'</a></li>';
		}
	}
	
	public function find_coupon_by_cid_mid()
	{
		$result = dbconn("select * from consumption_coupon where cid = '".$this->cid."' and mid = '".$this->mid."'") or die("find_coupon_by_cid_mid failed");
		//$type = dbconn();//search the coupon type
		if(mysql_num_rows($result) == 0)
		{
			$R = array("result" => 0);
			return $line;
		}
		
		while ($line = mysql_fetch_array($result, MYSQL_ASSOC))
		{
			$R = array("result" => 1);
			$line = array_merge($R, $line);
			mysql_free_result($result);
			return $line;
    	}
	}
	
	public function add_new()
	{
		if($this->check_merchant_name($this->name))
		{
			$this->mid = checkID("merchant_id", "consumption_merchant");
			$result = dbconn("insert into consumption_merchant values('".$this->name."', '".$this->mid."', '".md5($this->password)."', '".$this->fullname."')")
			or die("insert merchant failed");
		}
		else
		{
			echo "same name ";
		}
	}
	
	private function check_merchant_name($name)
	{
		$result = dbconn("SELECT merchant_name FROM consumption_merchant WHERE merchant_name = '".$name."'");
		$R = true;
		while($line = mysql_fetch_array($filedir, MYSQL_ASSOC))
		{
			$R = false;
		}
		return $R;
	}
	
	public function show_logout()
	{
		if(isset($_COOKIE['MerchantName']))
		{
			echo '<div class="verifi_logout">'.$_COOKIE['MerchantName'].'，<a href="merchant.php"> 首页</a>，<a href="manual.php">查看手册</a>，<a href="tools/logout.php">商户登出</a></div>';
		}
	}
	
	private function find_manual_dir()
	{
		$filedir = dbconn("select extra_merchant_value.state from extra_merchant_value,extra_item where extra_merchant_value.mid = '".$this->mid."' and extra_item.item_name = 'merchant_manual' and extra_merchant_value.item_id = extra_item.item_id") or die ("find_manual failed");
		$i = false;
		while($line = mysql_fetch_array($filedir, MYSQL_ASSOC))
		{
			$file_name = $line['state'];
			$i = true;
		}
		mysql_free_result($filedir);
		
		if($i)
		{
			$dir = "manual/".$file_name;
			return $dir;
		}
		else
		{
			return 'can not find file';
		}
	}
	
	public function read_manual()
	{
		@$fp = fopen($this->find_manual_dir(), 'r'); //read file
	  if(!$fp)
	  {
		  echo " file open error ";
		  echo $file_name;
		  exit;
	  }
	  else
	  {
		  while(!feof($fp))
		  {
		  	$r = fgets($fp);
			echo $r;
		  }
		  
	  	fclose($fp);
  	  }
	}
	
	public function upload_manual($filename, $fileTempName, $name)
	{
		$upload = new upload("../manual/", "txt", $filename, $fileTempName, $name);
		$upload->upload_file();
		$this->upload_manual_to_db($name.".txt");
	}
	
	private function upload_manual_to_db($name)
	{
		$result = dbconn("insert into extra_merchant_value (mid, item_id, state) values ('".$this->mid."', (select item_id from extra_item where item_name = 'merchant_manual'), '".$name."')") or die("uplad_manual failed");
	}
}

class recording
{
	public $shop_time;
	public $card_id = 0;
	public $mid = 0;
	public $price = 0;
	public $cid = 0;
	public $used;

	private $uid = 0;
	public $score = 0;
	public $counts = 0;
	public $title;
	
	private function find_uid()
	{
		$result = dbconn("SELECT uid FROM card WHERE card_id=".$this->card_id);
		while($line = mysql_fetch_array($result, MYSQL_ASSOC))
		{
			$this->uid = $line['uid'];
		}
	}
	
	private function find_score()
	{
		$result = dbconn("SELECT score FROM consumption_coupon WHERE cid=".$this->cid);
		while($line = mysql_fetch_array($result, MYSQL_ASSOC))
		{
			$this->score = $line['score'];
		}
	}
	
	public function record()
	{
		//echo 'card'.$this->card_id;
		$this->find_uid();
		//echo 'mid'.$this->mid;
		//$this->find_score();
		//echo 'record() this score'.$this->score;
		record_shopping($this->uid, $this->cid, $this->mid, $this->card_id, $this->score, $this->shop_time, $this->price);
		if($this->counts > 0)
		{
			decrease_count($this->cid, $this->counts);
		}
		$this->record_total_score();
	}
	
	private function record_total_score()
	{
		//echo 'id and socre is '.$this->uid.$this->score;
		record_total_score($this->uid, $this->score);
	}
	
	public function search_all()
	{
	}
	
	public function check_used()
	{
		$this->cid;
		$this->used;
	}
}

class coupon
{
	public $mid;
	public $cid;
	public $score;
	public $counts;
	public $title;
	public $merchant_name;
	public $used;
	public $price;
	public $type;
	public $e_coupon;
	public $upload_file_name;
	public $upload_file_temp_name;
	public $describe;
	
	public function add_coupon()
	{
		//$this->mid = search_from_table("merchant_id", "consumption_merchant", "merchant_name", $this->merchant_name);
		$this->cid = checkID("cid", "consumption_coupon");
		//echo 'cid is '.$this->cid.'mid is'.$this->mid.'price is '.$this->price.' score is'.$this->score.' count is'.$this->counts.'title is '.$this->title.'used is '.$this->used;
		
		$result = dbconn("insert into consumption_coupon (cid, mid, price, score, count, title, used) values('".$this->cid."', '".$this->mid."', '".$this->price."', '".$this->score."', '".$this->counts."', '".$this->title."', '".$this->used."')") or die("add_coupon insert failed");
		//echo 'here';
		$result2 = dbconn("insert into extra_coupon_value (cid, item_id, value) values('".$this->cid."', '5', '".$this->type."')")//add the coupon type
			or die("insert coupon failed");
			
		$result3 = dbconn("insert into extra_coupon_value (cid, item_id, value) values('".$this->cid."', '8', '".$this->e_coupon."')")//is the coupon a e_coupon or not
			or die("insert coupon failed");
			
			//echo 'here';
		if($this->e_coupon == 1)//is the coupon a e_coupon or not
		{
			//echo 'here';
			$upload = new upload("../../Mpic/epass/", array("jpg", "png"), $this->upload_file_name, $this->upload_file_temp_name, $this->cid);
			$upload->upload_file();
			
			$result3 = dbconn("insert into extra_coupon_value (cid, item_id, value) values('".$this->cid."', '9', '".$this->cid.'.'.$upload->get_type()."')")//is the coupon a e_coupon or not
			or die("insert coupon failed");
			
			$result3 = dbconn("insert into extra_coupon_value (cid, item_id, value) values('".$this->cid."', '10', '".$this->describe."')")//add the coupon's describe
			or die("insert coupon failed");
		}
	}
	
	public function switch_coupon_type()
	{
		$type_R = dbconn("select value from extra_coupon_value where cid = '".$this->cid."' and item_id = '5';") or die("switch_coupon_type failed");
		while ($line = mysql_fetch_array($type_R, MYSQL_ASSOC)) 
		{
			$type = $line['value'];
		}
		
		mysql_free_result($type_R);
		
		switch($type)
		{
			case "A":
			{
				echo "<label for=\"price\">本次消费金额：".$this->price."</label><input type=\"text\" id=\"price\" name=\"price\" value=\"".$this->price."\" onblur=\"javascript:checkPrice();\" readonly=\"readonly\"/><br/>";
				echo "<label for=\"price\">本次消费积分：".$this->score."</label><input type=\"text\" id=\"score\" name=\"score\" value=\"".$this->score."\" onblur=\"javascript:checkScore();\" readonly=\"readonly\"/>";
				break;
			}
			case "B":
			{
				echo "<label for=\"price\">本次消费金额</label><input type=\"text\" id=\"price\" name=\"price\" value=\"\" onblur=\"javascript:checkPrice();\"/><br/>";
				echo "<label for=\"price\">本次消费积分：".$this->score."</label><input type=\"hidden\" id=\"score\" name=\"score\" value=\"".$this->score."\" onblur=\"javascript:checkScore();\" readonly=\"readonly\"/>";
				break;
			}
			case "C":
			{
				echo "<label for=\"price\">本次消费金额：".$this->price."</label><input type=\"hidden\" id=\"price\" name=\"price\" value=\"".$this->price."\" onblur=\"javascript:checkPrice();\" readonly=\"readonly\"/><br/>";
				echo "<label for=\"price\">本次消费积分</label><input type=\"text\" id=\"score\" name=\"score\" value=\"\" onblur=\"javascript:checkScore();\"/>";
				break;
			}
			case "D":
			{
				echo "<label for=\"price\">本次消费金额</label><input type=\"text\" id=\"price\" name=\"price\" value=\"\" onblur=\"javascript:checkPrice();\" /><br/>";
				echo "<label for=\"price\">本次消费积分</label><input type=\"text\" id=\"score\" name=\"score\" value=\"\" onblur=\"javascript:checkScore();\"/>";
				break;
			}
		}
	}
}
?>