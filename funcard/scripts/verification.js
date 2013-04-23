// JavaScript Document
function alert1()
{
	
var s = document.getElementById("id").value;
	alert(s);
}

function checkInput()
{
	//checkName();
	//checkPW();
	//checkEmail();
	checkPhone();
	checkAdress()
}


function checkInput_user_info()
{
	checkName("baby_name");
	checkName("parent_name");
	checkAdress("adress");
}


function checkName(id)
{
	var s = document.getElementById(id).value;
	var patrn=/^[\u4E00-\u9FA5\uf900-\ufa2d\w]{2,20}$/;
  if (!patrn.exec(s)&&s!="")
  {
	 document.getElementById(id).value='';
    alert("请输入合法名称， 2-20个中英文字符 ");
    document.form1.typeid.value="";
    document.form1.typeid.focus();
    return false;
  }
}

function checkPW(id)
{
	var p = document.getElementById(id).value;
	var patrn_1=/^\S{6,18}$/;
	if (!patrn_1.exec(p)&&p!="")
  {
	  document.getElementById(id).value='';
    alert("请输入合法密码， 6-18位数字，英文或符号");
    document.form1.typeid.value="";
    document.form1.typeid.focus();
    return false;
  }
}

function checkEmail(id)
{
	var p = document.getElementById(id).value;
	var patrn_1= /^[a-zA-Z0-9_]+[@][a-zA-Z0-9]/; // full version: /^[a-zA-Z0-9_]+[@][a-zA-Z0-9]+([\\.com]|[\\.cn])/
	if (!patrn_1.exec(p)&&p!="")
  {
	  document.getElementById(id).value='';
    alert("请输入正确的邮箱，例：YourName@aierbang.org");
    document.form1.typeid.value="";
    document.form1.typeid.focus();
    return false;
  }
}

function checkPhone(id)
{
	var p = document.getElementById(id).value;
	var patrn_1= /^[0-9]{11}$/;// /^\S{6,18}$/
	if (!patrn_1.exec(p)&&p!="")
  {
	  document.getElementById(id).value='';
    alert("请输入正确的手机号，11位数字");
    document.form1.typeid.value="";
    document.form1.typeid.focus();
    return false;
  }
}

function checkAdress(id)
{
	var s = document.getElementById(id).value;
	var patrn=/^[\u4E00-\u9FA5\uf900-\ufa2d\w]{4,50}$/;
  if (!patrn.exec(s)&&s!="")
  {
	 document.getElementById(id).value='';
    alert("请输入完整的地址");
    document.form1.typeid.value="";
    document.form1.typeid.focus();
    return false;
  }
}