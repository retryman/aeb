<?php
/**
 *@filename debug.class.php
 *@desc 调试类，主要用于调试方便，方便以后线上有问题调试用
 * 根据之前代码里面的记录，调用FirePHP来在终端显示相应的信息
 *
 * 使用方式：
 * Debug::log($key,$value);	/// 设置要打印的值
 *
 * /// 这些一般会在公用程序里面设置好，不用设置
 * Debug::start(); /// 先设置开始
 * Debug::show();	/// 显示高信息
 *@author alfa@condenast
 *@date 2011-6-22
 *
 * update
 * 改善了Html页面显示的显示方式
 * @author alfa@condenast
 * @date 2012-02-15
 */

class Debug
{

	/**
	 * @desc 是否使用开关
	 * @var boolean
	 */
	static $debug = false;
	/**
	 * @desc 保存要显示的内容
	 * @var array
	 */
	static $debuginfoArr = array();
	/**
	 * @desc 保存起始时间
	 * @var array
	 */
	static $begin_time = array();


	/**
	 * @desc 开启调试功能
	 * @author alfa@condenast
	 * @return true
	 * @date 2011-6-22
	 */
	static public function start()
	{
		self::$debug = true;	/// 设置为开启状态
		self::$begin_time =  explode(" ", microtime());	/// 保存启动时间
		return true;
	}

	/**
	 * @desc 记录相应的信息
	 * @param  $name Key值 string
	 * @param  $info	对应的Value mixed
	 * @param  $groupName 分类显示名称，默认为 default
	 * @author alfa@condenast
	 * @date 2011-6-22
	 */
	static public function log($name,$info,$groupName = "default")
	{
		/// 如果没有开启就直接返回
		if(!self::$debug)
		{
			return true;
		}
		/// 如果组名为空则设置为默认“default”
		$groupName = trim($groupName);
		if($groupName == "")
		{
			$groupName = "default";
		}
		/// 如果是第一次设置，就加上标头
		if(!isset(self::$debuginfoArr[$groupName]))
		{
			self::$debuginfoArr[$groupName] = array();
			array_push(self::$debuginfoArr[$groupName], array("id","nowtime","used","key","value","caller"));
		}
		/// 调用此函数的相应文件，行数，及对应的函数
		$trace = debug_backtrace();
		$traceinfo = array();
		foreach ($trace as $value)
		{
			/// 如果使用register_shutdown_function调用的函数里面调用此函数，是读取不到File的，所以在这里判断一下
			if(!isset($value['file']))
			{
				$value['file'] = "unkown";
				$value['line'] = 0;
			}
			array_push($traceinfo,$value["file"].":".$value["line"]." => ".$value["function"]);
		}
		/// 得到当前时间，用于计算总运行时间
		$nowtime = explode(" ",microtime());
		/// 设置相应的时间
		$tempArr = array(
		count(self::$debuginfoArr[$groupName]),	/// 序号
		date("Y-m-d H:i:s",$nowtime[1]),	/// 当前时间
		(float)($nowtime[1] - self::$begin_time[1])+(float)($nowtime[0] - self::$begin_time[0]),	///从开始到现在的运行时间
		array($name),	/// 对应 的Key值
		$info,	/// 对应的Value
		$traceinfo	/// 调用信息
		);

		/// 保存到数据，方便以后显示
		array_push(self::$debuginfoArr[$groupName], $tempArr);
	}

	/**
	 *
	 * @desc 显示输出内容,调用FirePHP,通过FirePHP来显示内容
	 * @return true
	 * @author alfa@condenast
	 * @date 2011-6-22
	 */
	static public function show()
	{
		if(!self::$debug)
		{
			return true;
		}
		self::log("End", "Program end ","Progran");
		self::log("load files", get_included_files(),"Source Used");
		self::log("Mem Used", round(memory_get_usage()/1024/1024,2) . "M","Source Used");
				
		/// 如果设置为HTML方式，则显示为HTML方式
		if(Input::getInput("debugtype")=="html")
		{
		//	echo <<<ENDJS
		?>
<script>
function CondeNastPHPDebugBase64() {  
   
    // private property  
    _keyStr = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";  
   
    // public method for encoding  
    this.encode = function (input) {  
        var output = "";  
        var chr1, chr2, chr3, enc1, enc2, enc3, enc4;  
        var i = 0;  
        input = _utf8_encode(input);  
        while (i < input.length) {  
            chr1 = input.charCodeAt(i++);  
            chr2 = input.charCodeAt(i++);  
            chr3 = input.charCodeAt(i++);  
            enc1 = chr1 >> 2;  
            enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);  
            enc3 = ((chr2 & 15) << 2) | (chr3 >> 6);  
            enc4 = chr3 & 63;  
            if (isNaN(chr2)) {  
                enc3 = enc4 = 64;  
            } else if (isNaN(chr3)) {  
                enc4 = 64;  
            }  
            output = output +  
            _keyStr.charAt(enc1) + _keyStr.charAt(enc2) +  
            _keyStr.charAt(enc3) + _keyStr.charAt(enc4);  
        }  
        return output;  
    }  
   
    // public method for decoding  
    this.decode = function (input) {  
        var output = "";  
        var chr1, chr2, chr3;  
        var enc1, enc2, enc3, enc4;  
        var i = 0;  
        input = input.replace(/[^A-Za-z0-9\+\/\=]/g, "");  
        while (i < input.length) {  
            enc1 = _keyStr.indexOf(input.charAt(i++));  
            enc2 = _keyStr.indexOf(input.charAt(i++));  
            enc3 = _keyStr.indexOf(input.charAt(i++));  
            enc4 = _keyStr.indexOf(input.charAt(i++));  
            chr1 = (enc1 << 2) | (enc2 >> 4);  
            chr2 = ((enc2 & 15) << 4) | (enc3 >> 2);  
            chr3 = ((enc3 & 3) << 6) | enc4;  
            output = output + String.fromCharCode(chr1);  
            if (enc3 != 64) {  
                output = output + String.fromCharCode(chr2);  
            }  
            if (enc4 != 64) {  
                output = output + String.fromCharCode(chr3);  
            }  
        }  
        output = _utf8_decode(output);  
        return output;  
    }  
   
    // private method for UTF-8 encoding  
    _utf8_encode = function (string) {  
        string = string.replace(/\r\n/g,"\n");  
        var utftext = "";  
        for (var n = 0; n < string.length; n++) {  
            var c = string.charCodeAt(n);  
            if (c < 128) {  
                utftext += String.fromCharCode(c);  
            } else if((c > 127) && (c < 2048)) {  
                utftext += String.fromCharCode((c >> 6) | 192);  
                utftext += String.fromCharCode((c & 63) | 128);  
            } else {  
                utftext += String.fromCharCode((c >> 12) | 224);  
                utftext += String.fromCharCode(((c >> 6) & 63) | 128);  
                utftext += String.fromCharCode((c & 63) | 128);  
            }  
   
        }  
        return utftext;  
    }  
   
    // private method for UTF-8 decoding  
    _utf8_decode = function (utftext) {  
        var string = "";  
        var i = 0;  
        var c = c1 = c2 = 0;  
        while ( i < utftext.length ) {  
            c = utftext.charCodeAt(i);  
            if (c < 128) {  
                string += String.fromCharCode(c);  
                i++;  
            } else if((c > 191) && (c < 224)) {  
                c2 = utftext.charCodeAt(i+1);  
                string += String.fromCharCode(((c & 31) << 6) | (c2 & 63));  
                i += 2;  
            } else {  
                c2 = utftext.charCodeAt(i+1);  
                c3 = utftext.charCodeAt(i+2);  
                string += String.fromCharCode(((c & 15) << 12) | ((c2 & 63) << 6) | (c3 & 63));  
                i += 3;  
            }  
        }  
        return string;  
    }  
}  
<?
echo <<<ENDJS
function CondeNastPHPDebugShow(id)
{
	debugbase64 = new CondeNastPHPDebugBase64();
	name="CNPDebug_"+id;
	tempstr=debugbase64.encode(unescape(document.getElementById(id).innerHTML));
	document.getElementById(id).innerHTML=debugbase64.decode(eval(name));
	tempstr = name+'="'+tempstr+'";';
	eval(tempstr);
}

function CondeNastPHPDebugShowAll(key,len)
{
	for(i=0;i<=len;i++)
	{
		for(j=1;j<=6;j++)
		{
			tempkey=key+"_"+i+"_"+j;
			tempkey=tempkey.replace(/ /g,"_");
			if(document.getElementById(tempkey)!=null)
			{
				CondeNastPHPDebugShow(tempkey);
			}
		}
	}
}
</script>
ENDJS;
			foreach (self::$debuginfoArr as $key =>$value)
			{
				echo "<table border=\"1\">\n";
				echo " <tr>\n";
				echo "  <td colspan = \"6\">".$key." <a href=\"javascript:CondeNastPHPDebugShowAll('".$key."',".count($value).");\">全部展开</a></td>\n";
				echo " </tr>\n";

				$i=0;
				foreach ($value as  $debuginfo)
				{
					$i++;
					echo " <tr>\n";
					$j=0;
					foreach ($debuginfo as $debugvalue)
					{
						$j++;
						if(is_array($debugvalue))
						{
							$debugvalue = var_export($debugvalue,true);
						}
						if(strlen($debugvalue)>50)
						{
							$idname = str_replace(" ","_",$key."_".$i."_".$j);
							echo "  <td><div id=\"".$idname."\" ondblclick=\"javascript:CondeNastPHPDebugShow('".$idname."')\";>".substr($debugvalue,0,50)."...</div>(<a href=\"javascript:javascript:CondeNastPHPDebugShow('".$idname."');\">more</a>) </td>\n";
							$debugvalue = str_replace("\n", "<br>\n", $debugvalue,$count);
							$count *=16;
							//$debugvalue = htmlentities($debugvalue);
							$debugvalue = str_replace("\"", "\\\"", $debugvalue);
							echo "<script>\n";
							echo "CNPDebug_".$idname."=\"".base64_encode($debugvalue)."\";";
							echo "</script>\n";
													}
						else 
						{
							echo "  <td>".$debugvalue."</td>\n";
						}
					}
					echo " </tr>\n";

				}
				echo "</table>\n";
			}
				
		}
		else
		{
			$firephpobj = new FirePHP();
			foreach (self::$debuginfoArr as $key => $value)
			{
				$firephpobj->table($key, $value);
			}
		}
	}



}
?>
