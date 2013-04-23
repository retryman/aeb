<?php 
/**
 * 导出用户积分
 * @return unknown_type
 */
function _userpoints_admin_points_export(){
	header("Content-type:application/vnd.ms-excel; ");
	header("Content-Disposition: attachment; filename=用户积分".date('Ymd', time()).".xls");
	$sql = 'SELECT p.uid, u.name, p.points FROM {userpoints} p INNER JOIN {users} u on u.uid = p.uid ORDER BY  p.points DESC';
	$result = db_query($sql);
	
		echo   mb_convert_encoding("姓名", "gb2312")."\t";   
		echo   mb_convert_encoding("用户ID", "gb2312")."\t";       
		echo   mb_convert_encoding("积分", "gb2312")."\t";     
		echo   "\n";  
	
	while($row = db_fetch_object($result)){
 
		echo   mb_convert_encoding($row -> name, "gb2312")."\t";   
		echo   $row -> uid."\t";       
		echo   $row -> points."\t";    
		echo   "\n"; 	
	}
	
}


function _content_custom_reports_errors_delete(){
	if(!is_numeric(arg(3))){
		drupal_access_denied();
	}
	$nid = arg(3);
	$sql1 = "delete from {flag_counts} where content_id = %d and fid = 4";
	$sql2 = "delete from {flag_content} where content_id = %d and fid = 4";
	db_query($sql1, $nid);
	db_query($sql2, $nid);
	drupal_set_message('删除成功');
	drupal_goto('admin/reports/errors');
}

//报错统计页面
function _content_custom_reports_errors(){
	$content = '';
	$header = array('标题', '报错总数', '编辑', '删除');
	$sql = 'SELECT distinct node.nid AS nid,
		    node.title AS title,
			fcount.count as count
		 	FROM node node 
			INNER JOIN flag_counts fcount on fcount.content_id = node.nid
		 	WHERE node.status > 0 and fcount.fid = 4 order by fcount.count desc';
	$sql_count = "SELECT count(distinct node.nid)
			 	FROM node node 
				INNER JOIN flag_counts fcount on fcount.content_id = node.nid
			 	WHERE node.status > 0 and fcount.fid = 4";
	$result = pager_query($sql, 20, 0, $sql_count);
	$rows = array();
	while($row = db_fetch_object($result)){
		$rows[] =array( l($row -> title, 'node/'.$row -> nid), $row -> count, l('编辑', 'node/'.$row -> nid.'/edit'), l('删除', 'report/error/delete/'.$row -> nid));		
	}
	$content = theme('table', $header, $rows);
	$content .= theme('pager', '', 20, 0);
	return $content;
}

/**
 *  Implement of "admin/settings/userpromote",设置首页用户
 */
function userpromote_set(){	
	$form = array();
	
	$form['group1'] = array(
	  '#type' => 'fieldset',
	  '#title' => '爱儿帮首页用户推荐设置',
	  '#weight' => 5,
	  '#collapsible' => TRUE,
	  '#collapsed' => FALSE,
	);
	$form['group1']['homepage'] = array(
	  '#type' => 'textfield',
	  '#title' => t('用户ID'),
      '#maxlength' => 255,
      '#size' => 100,
	  '#description' => t('填写用户ID，用逗号隔开'),
  	  '#default_value' => variable_get('homepage_user', ''),
	);
	
	$form['group2'] = array(
	  '#type' => 'fieldset',
	  '#title' => '每日美德首页获奖用户设置',
	  '#weight' => 6,
	  '#collapsible' => TRUE,
	  '#collapsed' => TRUE,
	);
	$form['group2']['homevirtue'] = array(
	  '#type' => 'textfield',
	  '#title' => t('用户ID'),
      '#maxlength' => 255,
      '#size' => 100,
	  '#description' => t('填写用户ID，用逗号隔开'),
  	  '#default_value' => variable_get('homevirtue_user', ''),
	);
	
	$form['group3'] = array(
	  '#type' => 'fieldset',
	  '#title' => '每日美德页获奖用户设置',
	  '#weight' => 7,
	  '#collapsible' => TRUE,
	  '#collapsed' => TRUE,
	);
	$form['group3']['virtue'] = array(
	  '#type' => 'textfield',
	  '#title' => t('用户ID'),
      '#maxlength' => 255,
      '#size' => 100,
	  '#description' => t('填写用户ID，用逗号隔开'),
  	  '#default_value' => variable_get('virtue_user', ''),
	);
	
	$form['submit'] = array(
	  '#type' => 'submit',
	  '#value' => t('保存'),	 
	  '#weight' => 100,
	);

	return $form;
}

function userpromote_set_submit($form, $form_values){
		
	variable_set('homepage_user', $form_values['values']['homepage']);
	variable_set('homevirtue_user', $form_values['values']['homevirtue']);
	variable_set('virtue_user', $form_values['values']['virtue']);
	
	//清除前台显示的block缓存
	cache_clear_all('cache_homepage_user_block', 'cache');
	cache_clear_all('cache_homevirtue_user_block', 'cache');
	cache_clear_all('cache_virtue_user_block', 'cache');
	
	drupal_set_message('保存成功');
}

//统计用户评论数页面
function _content_custom_comments_statistic(){
	$content = '';
	$header = array('用户', '评论总数');
	$sql = "select u.name,u.uid,count(c.uid) as count from {comments} c 
			inner join {node} n on c.nid = n.nid 
			inner join {users} u on u.uid = c.uid 
			where n.type = 'orgnization' group by c.uid order by count(c.uid) desc";
	$sql_count = "select count(distinct c.uid) as count from {comments} c 
					inner join {node} n on c.nid = n.nid 
					inner join {users} u on u.uid = c.uid 
					where n.type = 'orgnization'";
	$result = pager_query($sql, 20, 0, $sql_count);
	$rows = array();
	while($row = db_fetch_object($result)){
		$rows[] =array( l($row -> name, 'user/'.$row -> uid), $row -> count);		
	}
	$content = theme('table', $header, $rows);
	$content .= theme('pager', '', 20, 0);
	return $content;
}

/**
 * 导出每日美德
 * @return unknown_type
 */
function _cc_admin_dailyvirtue_export(){
	header("Content-type:application/vnd.ms-excel; ");
	header("Content-Disposition: attachment; filename=每日美德".date('Ymd', time()).".xls");
	$sql = 'select n.title, n.uid, u.name, n.created from {node} n inner join {users} u on u.uid = n.uid 
			where n.type="daily_virtue" order by n.created desc';
	$result = db_query($sql);
	
		echo   mb_convert_encoding("时间", "gb2312")."\t";
		echo   mb_convert_encoding("美德内容", "gb2312")."\t";   
		echo   mb_convert_encoding("用户名", "gb2312")."\t";       
		echo   mb_convert_encoding("用户ID", "gb2312")."\t";     
		echo   "\n";  
	
	while($row = db_fetch_object($result)){
 		echo   date("Y-m-d H:i",$row -> created)."\t";
 		echo   mb_convert_encoding($row -> title, "gb2312")."\t";  
		echo   mb_convert_encoding($row -> name, "gb2312")."\t";   
		echo   $row -> uid."\t";  		    
		echo   "\n"; 	
	}
}

function _admin_sendsms_form(){	
	require_once('./funcard/mes/mes_utf.php');
	$mess = new send_message();//send the reg message
	$leftmoney = $mess->getBalance();
	$eachfee = $mess -> getEachFee();

	$form['leftmoney'] = array(
	'#value' => '<span style="background-color:yellow;margin:2px 0px;">短信账户余额：'.$leftmoney.'￥，每条短信费用：'.$eachfee.'￥</span>'
	  );

	$form['mobiles'] = array(
    '#type' => 'textarea',
	  '#title' => '手机号(多个以英文逗号,隔开)',
	//'#value' => $formvalues["post"]["mobiles"],
	  '#required' => true
	  );
  $form['smsbody'] = array(
    '#type' => 'textarea',
  '#title' => '短信内容',
  //'#value' => $formvalues["post"]["smsbody"],
   '#required' => true,
  );
	
  $form['submit'] = array(
	    '#type' => 'submit',
	    '#value' => '发送'
		  );

	return $form;
}


function _admin_sendsms_form_submit($form, $form_values){
	require_once('./funcard/mes/mes_utf.php');
	$mobiles = explode(',', $form_values['values']['mobiles']);
	$smsbody = $form_values['values']['smsbody'];

	$mess = new send_message();//send the reg message
	$res = $mess->sendmess($mobiles, $smsbody);
    if($res === '0'){				
		drupal_set_message('发送成功');
    }
    else{    	
    	form_set_error('','发送失败');
    }
}
