

var sMax;	// 最大数量的星星即最大评分值
var holder; // 鼠标停留的评分控件
var preSet; // 保存了评分值（通过单击来进行评分）
var rated; //是否评分过，并保存了结果（注意此值一旦设为空，就不能再评分）

// 鼠标停留事件
function rating(num){
	sMax = 0;	// 默认值为0
	for(n=0; n<num.parentNode.childNodes.length; n++){
		if(num.parentNode.childNodes[n].nodeName == "A"){
			sMax++;	
		}
	}
	
	if(!rated){
		s = num.id.replace("_", ''); // 获取选中的星星的索引，这里使用_1,_2,_3,_4,_5来做为评分控件的ID，当然也有其他的方式。
		a = 0;
		for(i=1; i<=sMax; i++){		
			if(i<=s){
				document.getElementById("_"+i).className = "on";
				document.getElementById("rateStatus").innerHTML = num.title;	
				holder = a+1;
				a++;
			}else{
				document.getElementById("_"+i).className = "";
			}
		}
	}
}

// 离开事件
function off(me){
	if(!rated){
		if(!preSet){	
			for(i=1; i<=sMax; i++){		
				document.getElementById("_"+i).className = "";
				document.getElementById("rateStatus").innerHTML = me.parentNode.title;
			}
		}else{
			rating(preSet);
			//document.getElementById("rateStatus").innerHTML = document.getElementById("ratingSaved").innerHTML;
		}
	}
}

// 点击进行评分
function rateIt(me, cid){
	if(!rated){
		//document.getElementById("rateStatus").innerHTML = me.title;//document.getElementById("ratingSaved").innerHTML + " :: "+
		preSet = me;
		rated=1;  //设为1以后，就变成了最终结果，不能再修改评分结果
		sendRate(me, cid);
		rating(me);
	}
}

var xmlHttp;

function sendRate(str ,cid)
{ 
xmlHttp=GetXmlHttpObject();
if (xmlHttp==null)
 {
 alert ("Browser does not support HTTP Request");
 return;
 }
var url="./tools/rate.php?cid="+cid+"&score="+str;

xmlHttp.onreadystatechange=stateChanged;
xmlHttp.open("GET",url,true);
xmlHttp.send(null);
}

function stateChanged() 
{ 
if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 { 
 document.getElementById("txtHint").innerHTML=xmlHttp.responseText ;
 } 
}

function GetXmlHttpObject()
{
var xmlHttp=null;
try
 {
 // Firefox, Opera 8.0+, Safari
 xmlHttp=new XMLHttpRequest();
 }
catch (e)
 {
 //Internet Explorer
 try
  {
  xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
  }
 catch (e)
  {
  xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
 }
return xmlHttp;
}
/*//使用Ajax或其他方式发送评分结果 
function sendRate(sel){
	//alert("评分结果: "+sel.title);
	var o=createObj();//创建ajax对象
	sel.toString();
 	var url="../tools/rate.php?cid=1&score="+sel;//===============你请求的url，参数为qid，你的answer.php需要的
 	o.open("get",url,true);//=========================
 	o.onreadystatechange=function(){
   if(o.readyState==4){
     if(o.status==200)$("taAnswer").value=o.responseText;
     else alert("发生错误！\n\n"+o.responseText);
   }
 }
 o.send(null);//发送请求
}

function $(id){return document.getElementById(id);}
function createObj()
{
  var o=null;
  if(typeof(XMLHttpRequest)!="undefined") return new XMLHttpRequest();  
  if(window.ActiveXObject){
    var MSXML=["MSXML2.XMLHttp.5.0","MSXML2.XMLHttp.4.0","MSXML2.XMLHttp.3.0","MSXML2.XMLHttp","Microsoft.XMLHTTP"];
    for(var i=0;i<MSXML.length;i++){
       try{
         o= new ActiveXObject(MSXML[i]);return o;
       }
       catch(e){}
    }
  }
  return null;
}*/
