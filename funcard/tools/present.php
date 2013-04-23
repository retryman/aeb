<?php
require_once('function.php');
class present
{
	public $pid;
	public $counts;
	public $score;
	public $mid;
	public $pic;
	public $describe;
	public $title;
	
	public $upload_file_name;//$_FILES['file']['name']
	public $upload_file_temp_name;//$_FILES['file']['tmp_name']
		//record the pic name and ID into database
		//require_once('function.php');

		/*设置文件保存目录 注意包含*/
		private $uploaddir = "../Mpic/present/";

		/*设置允许上传文件的类型*/
		private $type=array("jpg","gif","bmp","jpeg","png");

		/*程序所在路径*/
		//$patch="http://www.dreamdu.com/cr_downloadphp/upload/files/";
		
		private $db;
		
		public function __construct(){
			global $db_G;
			$this ->db = $db_G;
		}

		/*获取文件后缀名函数*/
		public function fileext($filename)
		{
		        return substr(strrchr($filename, '.'), 1);
		}
		
		public function upload_present()
		{
			$a = strtolower($this->fileext($this->upload_file_name));

			/*判断文件类型*/
			if(!in_array($a, $this->type))
			{
		        $text=implode(",",$this->type);
		        echo "您只能上传以下类型文件: ",$text,"<br>";
			}
			else
			{
				$this->pic = $this->pic.'.'.$a;
				$uploadfile = $this->uploaddir.$this->pic;
				file_exists($uploadfile);
				$this->upload_present_data();//record merchant data to DB;

    	    	if (move_uploaded_file($this->upload_file_temp_name,$uploadfile))
        		{
					echo "<center>您的文件已经上传完毕 上传图片预览: </center><br><center><img src='$uploadfile'></center>";
                    echo"<br><center><a href='javascript:history.go(-1)'>继续上传</a></center>";
				}
				else
				{
					echo "pic name is same, try again please";
				}
        	}
		}
		
		private function upload_present_data()//need to set mid, title, describe, score and count.
		{
			connect_DB("insert into consumption_present (pid, mid, pic, title, des, score, price, count) value('".$this->pid."', '".$this->mid."', '".$this->pic."', '".$this->title."', '".$this->describe."', '".$this->score."', '".$this->price."', '".$this->counts."')");
			$this->pid = ppdb_get_insertID();
		}

		public function exchange($uid)//exchange score to present
		{
			//检查礼品数量是否足够
			$res = $this -> db -> fetchOne("select count from consumption_present where pid=$this->pid");
			if(!$res || $res['count'] < 0){
				return false;
			}
			//生成兑换码
			$exchangeCode = $this -> createExchangeCode();
			$mid = $this -> getMidbyPid($this->pid);
			$time = time();
			if($exchangeCode && $mid){
				 $this ->db -> query("insert into consumption_exchange(pid,uid,date,send,code,mid) values(".$this->pid.", ".$uid.", ".$time.", 0, '".$exchangeCode."', ".$mid.")");//insert into exchange table

				 $this ->db -> query("update consumption_present set count=count-1 where pid = '".$this->pid."'");//update present table;
				return true;
			}
			return false;
		}
		
		public function getMidbyPid($pid){
			if(!is_numeric($pid)){
				return false;
			}
			$res = $this -> db -> fetchOne("select mid from consumption_present where pid=$pid");

			return $res["mid"]?$res["mid"]:false;
		}

		/*
		 * 生成兑换码
		 */
		public function createExchangeCode(){
			$res = $this -> db -> fetchOne("select id from consumption_exchange order by id desc limit 1");		
			$count = $res['id']+1;
	
			$len = strlen($count);		
			$lastNumLen = 10 - $len;
			$lastNum = String::RandStr($lastNumLen,0);		
			
			$code = String::RandStr(2,0).$count.$lastNum;
			return $code;
		}
		
		
		public function find_present_by_id($id)
		{
			$result = connect_DB("SELECT * FROM consumption_present WHERE pid = ".$id);//pid, cid, title, score, count, des
			$arr = array();
			while ($line = mysql_fetch_array($result, MYSQL_ASSOC))
			{
				array_push($arr, $line);
			}
			
			mysql_free_result($result);
			return $arr;
		}
		
		public function find_all_present($limit = 0)
		{
			if($limit == 0)
			{
				$result = connect_DB("select pid,pic,title,score,count from consumption_present where status=1 order by weight desc,pid desc");//pid, cid, title, score, count
			}
			else
			{
				$result = connect_DB("select pid,pic,title,score,count from consumption_present where status=1 order by weight desc,pid desc LIMIT ".$limit);
			}
			$arr = array();
			while ($line = mysql_fetch_array($result, MYSQL_ASSOC))
			{
				array_push($arr, $line);
			}
			
			mysql_free_result($result);
			return $arr;
		}
}
?>