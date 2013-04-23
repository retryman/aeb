<?php
/*
About: 这是DJ写的BluePage分页类的默认配置文件，请不要删除
　　　 你可以照这个文件拷贝一分
       请根据你的需要保存相应的编码格式，如ansi或utf-8
　　　 在使用的时候将路径加入到 $pBP->getHTML( $aPDatas , '相对路径与此文件名' );
*/

// 以下标签名称，可以任意组合，以|隔开
// t  记录总数
// f  首页
// pg 上一组页码
// p  上一页
// bar  分页条
// ng 下一组页码
// n  下一页
// m  总页数
// sl 下拉选页
// i  Input表单

/***  以下为HTML格式配置，需要有一定HTML知识  ***/
//请自行修改为自己需要的链接形式，请勿数字键名
//
//$PA['t']   = '<a class="BPtotal"><span style="margin:0 8px 0 8px">%d</span></a>' ;     //记录总数
$PA['f']   = '<a href="%s" class="BPside" title="第一页">1</a>' ;                      //首页
$PA['pg']  = '<a href="%s" class="BPside" title="上一组页码">&lsaquo;&lsaquo;</a>' ;   //上一组页码
$PA['p']   = '<a href="%s" class="BPside" title="上一页">&lsaquo;</a>' ;               //上一页
$PA['bar'] = '<a href="%1$s" class="BPnum">%2$d</a>' ;                                 //分页条
$PA['bar_cur'] = '<a class="BPcur" >%d</a>';                                           //当前页
$PA['ng']  = '<a href="%s" class="BPside" title="下一组页码">&rsaquo;&rsaquo;</a>' ;   //下一组页码
$PA['n']   = '<a href="%s" class="BPside" title="下一页">&rsaquo;</a>' ;               //下一页
$PA['m']   = '<a href="%s" class="BPside" title="最末页">%d</a>' ;                     //总页



//跳转表单
//$PA['i'] = '<input class="BPinput" type="text" name="toPage" onkeydown="if(event.keyCode==13) {window.location=\'?%s%s=%s\'+this.value+\'%s\'; return false;}">' ;



//$PA['sl']  = '<option value="?%s%s=%s%5$d%s">%5$d</option>\n' ;                        //下拉表单页码,
//下拉表单头部 不需要修改
//$PA['sl_head'] =  "<select name=\"goPage\" onchange=\"window.location=this.value\">\n" ; 
//下拉表单尾部 不需要修改
//$PA['sl_end'] =  "</select>" ; 



//这会出现在分页输出前面,可以留空
$PA['head'] = '<div class="BPbar">' ;
//这会出现在分页输出后面
$PA['end'] = '</div>' ;
?>