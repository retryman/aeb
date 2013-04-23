<?php
function _content_custom_register_success(){
	$register_user = user_load(arg(2));
	
	//重新发送激活邮件
	if(arg(3) == 'resend' && $register_user -> uid && $register_user -> access == 0){ 
		drupal_set_message("激活邮件已经发送，请查收"); 
		$password = user_password();
		$register_user -> password = $password;		
		_user_mail_notify('register_no_approval_required', $register_user);
		$userinfo = array('pass' => $password);
		user_save($register_user, $userinfo);
	} 
	
	$email = $register_user -> mail;

	if($email){
		$email = explode('@', $email);
		$emailPage = _content_custom_get_email_login_page($email[1]);
		$linkAttr = 'target="_blank"';
	}
	return '<span>亲爱的'.$register_user -> name.'，	</span><br/>
	<span>我们已将激活邮件发送到您的邮箱<a '.$linkAttr.' href="'.$emailPage.'">'.$register_user -> mail.'</a>，请到邮箱中收信激活</span><br/>
	<span>您的唯一会员编号是:'.$register_user -> uid.'，此会员编号是您参加AEB儿童用品内部交换派对等活动的唯一标识，请您做好记录</span><br/>	
	<span>欢迎加入爱儿帮！分享，交流，共同成长......</span><br/>
	<span>爱儿帮育儿俱乐部</span><br/>	
	<div class="link">'.l('浏览商户点评', 'orgnization/comment').l('返回首页', '').'如果您没有收到邮件，请点击<a href="/register/success/'.arg(2).'/resend">重新发送</a></div>';
}

function _content_custom_user_cover_me(){
	global $user;
	if($user -> uid){
		drupal_goto('user/'.$user -> uid.'/cover');
	}
	else{
		drupal_goto('user/login');
	}
}

function _content_custom_get_email_login_page($email){
	switch($email){
		case '163.com':
		case '126.com':
		case 'qq.com':
		case 'sina.com':
		case 'sohu.com':
		case 'msn.com':
		case '189.cn':
		case 'yahoo.com.cn': 
			return 'http://mail.'.$email;
			break;
		case 'gmail.com':
			return 'http://mail.google.com';
			break;
		case 'hotmail.com':
			return 'http://www.hotmail.com';
			break; 
		default :
			return  ''; 
	}
}

/*
 * another register page
 */
function  _cc_custom_register_form(){
	global $user;

  //get the notice content
  $sql = "select nv.nid,nv.title,nv.body from {node_revisions} nv 
		  inner join {term_node} tn on tn.nid = nv.nid 
		  where tn.tid = %d order by nv.timestamp desc limit 0,1";
  $result = db_fetch_object(db_query($sql, 382));
  

  if($result){
  	$form['topcontent'] = array(
  	 '#value' => $result -> body,
  	);
  	  $form['nid'] = array(
  	  '#type' => 'hidden',
  	 '#value' => $result -> nid,
  	);
  $form['title'] = array(
  	  '#type' => 'hidden',
  	 '#value' => $result -> title,
  	);
  }
  
  $form['amorpm'] = array(
    '#type' => 'select',
  	'#title' => '您预计参加的场次',
    '#options' => array('请选择', 
  						'蓝天城1张'=>'蓝天城1张',
						'蓝天城2张'=>'蓝天城2张',
						'蓝天城3张以上'=>'蓝天城3张以上',
						'蓝天城2大1小'=>'蓝天城2大1小',
						'宝贝当家1张'=>'宝贝当家1张',
						'宝贝当家2张'=>'宝贝当家2张',
						'宝贝当家3张以上'=>'宝贝当家3张以上'),
	  '#default_value' => 0,
	  '#required' => true,
  );
  
    //登录用户
  if($user -> uid){
  $form['submit'] = array(
	    '#type' => 'submit',
	    '#value' => '报名'
		  );
		  return $form;
  }
  
  //未登录用户
	
  $form['toptitle'] = array(
	 '#value' => '<h2>报名参加活动</h2>',
	 );

 $form['register'] = array(
    '#type' => 'radios',
  	'#title' => '用户类型',
  '#options' => array('未注册会员', '已注册会员'),  
 '#default_value' => 0,
  '#required' => true,
  );

  drupal_add_js('
  $(document).ready(function(){
  	$("#edit-register-0").click(function(){
  		$("#no-register").show();
  		$("#yes-register").hide();
	});
  	$("#edit-register-1").click(function(){
  		$("#no-register").hide();
  		$("#yes-register").show();
	});	
	});'
  ,'inline');
	 
  $form['mail'] = array(
    '#type' => 'textfield',
  '#title' => '有效邮箱',
  '#required' => true,
  '#prefix' => '<div id="no-register">',
  );
  $form['name'] = array(
    '#type' => 'textfield',
  '#title' => '用户名',
   '#required' => true,
  );
    _user_password_dynamic_validation();
  $form['pass'] = array(
    '#type' => 'password_confirm',
   '#required' => true,
  );
    $form['cname'] = array(
    '#type' => 'textfield',
  	'#title' => '孩子姓名',
    '#required' => true,
  );
 $form['csex'] = array(
    '#type' => 'radios',
  	'#title' => '孩子性别',
  '#options' => array('男','女'),
    '#required' => true,
  );

  $form['cbirthday'] = array(
    '#type' => 'date_popup',
    '#title' => '宝宝出生日期',
    '#date_format' => 'Y-m-d',
	'#date_year_range' => '-20:+0',
  '#required' => true,
  );
    $form['pname'] = array(
    '#type' => 'textfield',
  	'#title' => '家长姓名',
    '#required' => true,
  );
   $form['address'] = array(
    '#type' => 'textfield',
  	'#title' => '居住区域',    
  );
  $form['des'] = array(
  '#value' => '<div style="float:left;font-size:11px;margin-left:120px;width:500px;">“爱儿帮将以短信或邮件形式发送活动礼品券，请您务必留下有效联系方式！”</div>',
  );
  $form['phone'] = array(
    '#type' => 'textfield',
    '#title' => '手机号码',
  '#required' => true,
  );
  $form['company'] = array(
    '#type' => 'textfield',
   '#title' => 'VIP CODE （公司名称）',
   '#required' => true,
  );
  
    $form['line'] = array(
  '#value' => '<br/><br/><br/>'
  );

  $form['line2'] = array(
  '#value' => '<br/><br/><br/>'
  );
  
  $form['submit'] = array(
    '#type' => 'submit',
    '#value' => '注册并报名',
    '#suffix' => '</div>',
  );
  
    $form['loginbtn'] = array(
    '#value' => '<a href="user?destination=virtue01">登录并报名</a>',
    '#prefix' => '<div id="yes-register" style="display:none;">',
    '#suffix' => '</div>',
    );
  
 
  return $form;
}


/*register page 2*/
function  _cc_custom_register_form_2(){
	global $user;

  //get the notice content
  $sql = "select nv.nid,nv.title,nv.body from {node_revisions} nv 
		  inner join {term_node} tn on tn.nid = nv.nid 
		  where tn.tid = %d order by nv.timestamp desc limit 0,1";//change here
  $result = db_fetch_object(db_query($sql, 382));//change here
  

  if($result){
  	$form['topcontent'] = array(
  	 '#value' => $result -> body,
  	);
  	  $form['nid'] = array(
  	  '#type' => 'hidden',
  	 '#value' => $result -> nid,
  	);
  $form['title'] = array(
  	  '#type' => 'hidden',
  	 '#value' => $result -> title,
  	);
  }
  
    //登录用户
  if($user -> uid){
  $form['submit'] = array(
	    '#type' => 'submit',
	    '#value' => '报名'
		  );
		  return $form;
  }
  
  //未登录用户
	
  $form['toptitle'] = array(
	 '#value' => '<h2>报名参加活动</h2>',
	 );

 $form['register'] = array(
    '#type' => 'radios',
  	'#title' => '用户类型',
  '#options' => array('未注册会员', '已注册会员'),  
 '#default_value' => 0,
  '#required' => true,
  );

  drupal_add_js('
  $(document).ready(function(){
  	$("#edit-register-0").click(function(){
  		$("#no-register").show();
  		$("#yes-register").hide();
	});
  	$("#edit-register-1").click(function(){
  		$("#no-register").hide();
  		$("#yes-register").show();
	});	
	});'
  ,'inline');
	 
  $form['mail'] = array(
    '#type' => 'textfield',
  '#title' => '有效邮箱',
  '#required' => true,
  '#prefix' => '<div id="no-register">',
  );
  $form['name'] = array(
    '#type' => 'textfield',
  '#title' => '用户名',
   '#required' => true,
  );
    _user_password_dynamic_validation();
  $form['pass'] = array(
    '#type' => 'password_confirm',
   '#required' => true,
  );
    $form['cname'] = array(
    '#type' => 'textfield',
  	'#title' => '孩子姓名',
    '#required' => true,
  );
 $form['csex'] = array(
    '#type' => 'radios',
  	'#title' => '孩子性别',
  '#options' => array('男','女'),
    '#required' => true,
  );

  $form['cbirthday'] = array(
    '#type' => 'date_popup',
    '#title' => '宝宝出生日期',
    '#date_format' => 'Y-m-d',
	'#date_year_range' => '-20:+0',
  '#required' => true,
  );
    $form['pname'] = array(
    '#type' => 'textfield',
  	'#title' => '家长姓名',
    '#required' => true,
  );
   $form['address'] = array(
    '#type' => 'textfield',
  	'#title' => '居住区域',    
  );
  $form['des'] = array(
  '#value' => '<div style="float:left;font-size:11px;margin-left:120px;width:500px;">"爱儿帮将以短信及邮件形式发送活动入场券，请您务必留下有效联系方式！"</div>',
  );
  $form['phone'] = array(
    '#type' => 'textfield',
    '#title' => '手机号码',
  '#required' => true,
  );
  
  $form['company'] = array(
    '#type' => 'textfield',
   '#title' => 'VIP CODE （TEST）',
   '#required' => true,
  );
 $form['amorpm'] = array(
    '#type' => 'select',
  	'#title' => '您预计参加的场次',
  '#options' => array('请选择', 'TEST'),
  '#default_value' => 0,
  '#required' => true,
  );

  $form['submit'] = array(
    '#type' => 'submit',
    '#value' => '注册并报名',
    '#suffix' => '</div>',
  );
  
    $form['loginbtn'] = array(
    '#value' => '<a href="user?destination=virtue01">登录并报名</a>',
    '#prefix' => '<div id="yes-register" style="display:none;">',
    '#suffix' => '</div>',
  );
  
 
  return $form;
}

function _cc_custom_register_form_validate($form, &$form_state){
	if($form_state['values']['amorpm'] == '0'){
		 form_set_error('amorpm', '请选择要参加的场次');
	}
	
	if($form_state['values']['submit'] == '报名'){		
		return;
	}
	
	$edit['name'] = $form_state['values']['name'];
	$edit['mail'] = $form_state['values']['mail'];
		
	 // Validate the user name:
    if ($error = user_validate_name($edit['name'])) {
      form_set_error('name', $error);
    }
    else if (db_result(db_query("SELECT COUNT(*) FROM {users} WHERE uid != %d AND LOWER(name) = LOWER('%s')", $uid, $edit['name'])) > 0) {
      form_set_error('name', t('The name %name is already taken.', array('%name' => $edit['name'])));
    }
    else if (drupal_is_denied('user', $edit['name'])) {
      form_set_error('name', t('The name %name has been denied access.', array('%name' => $edit['name'])));
    }
    
	  // Validate the e-mail address:
	  if ($error = user_validate_mail($edit['mail'])) {
	    form_set_error('mail', $error);
	  }
	  else if (db_result(db_query("SELECT COUNT(*) FROM {users} WHERE uid != %d AND LOWER(mail) = LOWER('%s')", $uid, $edit['mail'])) > 0) {
	    form_set_error('mail', t('The e-mail address %email is already registered. <a href="@password">Have you forgotten your password?</a>', array('%email' => $edit['mail'], '@password' => url('user/password'))));
	  }
	  else if (drupal_is_denied('mail', $edit['mail'])) {
	    form_set_error('mail', t('The e-mail address %email has been denied access.', array('%email' => $edit['mail'])));
	  }
}

function _cc_custom_register_form_submit($form, &$form_state){
	global $user;
	if($form_state['values']['submit'] == '报名'){
		db_query("delete from {user_activity} where uid = %d and nid = %d", $user -> uid,  $form_state['values']['nid']);		
		db_query("insert into {user_activity} values (%d, %d, '%s')", $user -> uid,  $form_state['values']['nid'],$form_state['values']['amorpm']);		
		drupal_set_message('爱儿帮VIP员工福利计划会员，您已成功报名“'.$form_state['values']['title'].'”活动，我们将于近期给您发送电子邀请码，请保持手机畅通，或及时查收邮件，谢谢！');
		return;
	}
	
	$account['name'] = $form_state['values']['name'];
	$account['pass'] = $form_state['values']['pass'];
	$account['init'] = $form_state['values']['mail'];
	$account['mail'] = $form_state['values']['mail'];
	$account['status'] = 1;
	


	$account['profile_cname'] =$form_state['values']['cname'];
	$account['profile_csex'] = $form_state['values']['csex'] == 1?'女':'男';
	
	$birth = $form_state['values']['cbirthday'];
	$birth = explode(' ', $birth); 
	$birth = explode('-', $birth[0]); 
	$account['profile_cbirthday'] = array('year' => $birth[0], 'month' => (int)$birth[1], 'day' => (int)$birth[2] );
	
	$account['profile_mobile_phone'] = $form_state['values']['phone'];
	$account['profile_comname'] = $form_state['values']['company'];
	$account['profile_name'] = $form_state['values']['pname'];
	$account['profile_address'] = $form_state['values']['address'];
	//$account['profile_amorpm'] = $form_state['values']['amorpm']; //== '1'?'1月7日 14：00':'1月7日 16：30';
	$account['roles'] = array(4 => 4);
	

	$account_s = user_save('', $account);

	$user = user_load($account_s -> uid);
	profile_save_profile($account, $user, '个人专访');
	
	db_query("delete from {user_activity} where uid = %d and nid = %d", $user -> uid,  $form_state['values']['nid']);		
	db_query("insert into {user_activity} values (%d, %d, '%s')", $user -> uid,  $form_state['values']['nid'], $form_state['values']['amorpm']);		
	
	drupal_set_message('爱儿帮VIP员工福利计划会员，您已成功报名“'.$form_state['values']['title'].'”活动，我们将于近期给您发送电子邀请码，请保持手机畅通，或及时查收邮件，谢谢！');
	drupal_goto('user/'.$user -> uid.'/cover');
}

function _content_custom_node_poll(){
	global $user;
	if(!$user -> uid || !is_numeric(arg(2)) || !is_numeric(arg(3))){
		drupal_goto('experience');
	}
	
	//check whether the user has polled 
	$result = db_fetch_object(db_query("select count(nid) as count from {poll_votes} where nid = %d and uid = %d", arg(2), $user -> uid));
	if($result -> count){
		drupal_set_message("不能重复投票，谢谢您的参与！");
		drupal_goto('experience');
	}

	db_query("insert into {poll_votes} values(%d, %d, %d, '')", arg(2), $user -> uid, arg(3));
	db_query("update {poll_choices} set chvotes = chvotes+1 where nid = %d and chorder = %d", arg(2), arg(3));
	drupal_set_message("投票成功，谢谢您的参与！");
	drupal_goto('experience');
}

function _cc_custom_disney_form(){
  global $user;
  
  //get the notice content
  $sql = "select nv.body from {node_revisions} nv 		  
		  where nv.nid = 1729";
  $result = db_fetch_object(db_query($sql));
 
  $form['topcontent'] = array(
   '#value' => $result -> body,
  );  

	$form['cname'] = array(
	'#type' => 'textfield',
	'#title' => '儿童姓名',
	'#weight' => 4,
	);
	$form['birthday'] = array(
	'#type' => 'date_popup',
	'#title' => '出生日期',
	'#date_format' => 'Y-m-d',
	'#date_year_range' => '-50:+0',		
	'#weight' => 6,
	);
	$form['pname'] = array(
	'#type' => 'textfield',
	'#title' => '家长姓名',
	'#weight' => 9,
	);
	$form['phone'] = array(
	'#type' => 'textfield',
	'#title' => '家长手机',
	'#weight' => 11,
	);
	$form['email'] = array(
	'#type' => 'textfield',
	'#title' => '家长邮箱',
	'#weight' => 13,
	);	
	$form['address'] = array(
	'#type' => 'textfield',
	'#title' => '居住区域',
	'#weight' => 15,
	);				
	$form['button'] = array(
	'#type' => 'submit',
	'#value' => '提交',
	'#weight' => 18,
	);	

	
	return $form;
}

function _cc_custom_disney_form_submit($form, &$form_state){
	if($form_state['values']['birthday']){
		$birth = $form_state['values']['birthday'];
		$birth = explode(' ', $birth); 
		$birth = explode('-', $birth[0]); 
		if(is_numeric($birth[2])){
			$birthday = mktime(0 , 0, 0, $birth[1], $birth[2], $birth[0]);
		}
	}
	
	$node -> type = 'survey';
	$node -> title = '调查'.date('Ymd', time());
	
	global $user;
	$node -> uid = $user -> uid;
	$node -> field_survey_date[0]['value'] = $birthday;
	$node -> field_survey_cname[0]['value'] = $form_state['values']['cname'];
	$node -> field_survey_pname[0]['value'] = $form_state['values']['pname'];
	$node -> field_survey_phone[0]['value'] = $form_state['values']['phone'];
	$node -> field_survey_address[0]['value'] = $form_state['values']['address'];
	$node -> field_survey_email[0]['value'] = $form_state['values']['email'];
	
	node_save($node);

	drupal_set_message("提交成功，谢谢您的参与！");
	drupal_goto('denglish');
}


function _content_custom_usersurvey_export(){
  @ini_set('memory_limit', '750M');
  @set_time_limit(240);
  
   //header('Content-type: text/html; charset=UTF-8');

  header('Content-type: text/csv; charset=gb2312');
  header('Content-Disposition: attachment; filename=usersurvey_' . date('Ymd', time()) . '.csv');
  header('Pragma: no-cache');
  header('Expires: 0');
  
  echo "邮箱,学习英语的重要性,您的宝宝是否已经开始接触英语,您的宝宝就读于哪家英语课外中心,您的宝宝是否喜欢迪士尼形象,您是否有听过迪士尼少儿英语,您离迪士尼的哪家中心更近\n";
	
  $sql = "select nid from {node} where type = 'survey' order by created desc";
  
  $result = db_query($sql);
  
  while($row = db_fetch_object($result)){
  	 $node = node_load($row -> nid);
  	
  	 $uid = $row -> uid;
  	 
  	 echo $row -> uid.",".$author -> name.",";
  }
  
}
//首页
function _content_custom_startpage(){	
	return '';
}
//通知页
function _content_custom_notices(){
	$content = array();
	$content["leftbar"]=taxonomy_get_tree(2);

	$sql = "SELECT node.nid AS nid,
	   node.title AS node_title,
	   node_data_field_sort.field_sort_value AS node_data_field_sort_field_sort_value	  
	 FROM node node 
	 LEFT JOIN content_field_content_type node_data_field_content_type ON node.vid = node_data_field_content_type.vid
	 LEFT JOIN content_field_sort node_data_field_sort ON node.vid = node_data_field_sort.vid
	 WHERE (node_data_field_content_type.field_content_type_value = 2) AND (node.status <> 0) AND (node.type in ('node_gallery_gallery', 'notice'))  
	   ORDER BY node_data_field_sort_field_sort_value DESC, nid DESC";
	$sql_count = "SELECT count(node.nid) AS count  
	 FROM node node 
	 LEFT JOIN content_field_content_type node_data_field_content_type ON node.vid = node_data_field_content_type.vid
	 LEFT JOIN content_field_sort node_data_field_sort ON node.vid = node_data_field_sort.vid
	 WHERE (node_data_field_content_type.field_content_type_value = 2) AND (node.type in ('node_gallery_gallery', 'notice'))  AND (node.status <> 0) 
	   ";
	$res = pager_query($sql,25,0,$sql_count);
	$rows = array();
	while($row = db_fetch_object($res)){
		$rows[] = $row;
	}
	$content['content']=$rows;
	$content['pager'] = theme('pager',array('','','','',''));
	
	$sql = "SELECT node.title AS title,
   f.filepath,
   node_data_field_ad_logo.field_ad_link_value AS link,
   node_data_field_sort.field_sort_value AS node_data_field_sort_field_sort_value
 FROM node node 
 INNER JOIN term_node term_node ON node.vid = term_node.vid
 LEFT JOIN content_type_advertisement node_data_field_ad_logo ON node.vid = node_data_field_ad_logo.vid
 LEFT JOIN content_field_sort node_data_field_sort ON node.vid = node_data_field_sort.vid
 left join files f on f.fid=node_data_field_ad_logo.field_ad_logo_fid 
 WHERE (node.type in ('advertisement')) AND (term_node.tid = 404) and (node.status <> 0) 
   ORDER BY node_data_field_sort_field_sort_value DESC";
	$res = db_query($sql);
	$rows = array();
	while($row = db_fetch_object($res)){
		$row -> image = theme('imagecache', '156_113_scale', $row->filepath);
		$rows[] = $row;
	}

	$content['promotes']=$rows;
	return $content;
}

/**
 * ajax获取优惠短信
 */
function _content_custom_ajax_getcouponmsg(){
	global $user;
	$nid = $_REQUEST['nid'];
	if(!$user->uid || !is_numeric($nid)){
		exit;
	}
	
	$sql = "select phone from coupon_user where name='".$user->name."'";
	$res = db_query($sql);
	if($phone = db_fetch_object($res)){
		require_once('./funcard/mes/mes_utf.php');
		
		$sql = "select n.title,ctc.field_coupon_msg_value as msgbody from content_type_coupon ctc inner join node n on n.nid=ctc.nid where n.nid=".$nid;
		$res = db_query($sql);
		$msgbody = db_fetch_object($res);
		
		//同一个用户同一个优惠券最多能发两条短信
		$sql = "select count(id) as count from user_coupon where uid=".$user->uid." and nid = ".$nid."";
		$res = db_query($sql);
		$count = db_fetch_object($res);
		if($count -> count >= 2){//已经发过短信2次
			echo json_encode(array('status'=>3));exit;
		}

		$code = _content_custom_generateCode();
		
		$msgbody->msgbody = str_replace('#name#',$user->name,$msgbody->msgbody);
		$msgbody->msgbody = str_replace('#code#',$code,$msgbody->msgbody);
		
		$mess = new send_message();//send the reg message
		$res = $mess->sendmess(array($phone->phone), $msgbody->msgbody);
	    if($res === '0'){				
			$res = db_query("insert into user_coupon(uid,uname,mobile,nid,code,msg,coupon,ctime) values(".$user->uid.",'".$user->name."','".$phone->phone."',".$nid.",'".$code."','".$msgbody->msgbody."','".$msgbody->title."',".time().")");
	    	if($res){
	    		echo json_encode(array('status'=>1));exit;//短信发送成功
	    	}
	    }
	}
	echo json_encode(array('status'=>2));exit;
}

/**
 * 生成12位的激活码
 */
function _content_custom_generateCode(){
	$res = db_query("select id from user_coupon order by id desc limit 1");		
	$id = db_fetch_object($res);
	$count = $id->id+1;

	$len = strlen($count);		
	$lastNumLen = 10 - $len;
	$lastNum = _content_custom_RandStr($lastNumLen,0);		
	
	$code = _content_custom_RandStr(2,0).$count.$lastNum;
	return $code;
}	

/**
 *
 * @desc 生成一个随机字符串
 * @param  $len 字符串长度
 * @param  $type 类型 0=数字 1=全小写 2=全大写 3=大小写 4=大小写+数字 其它=4
 * @return string
 * @author alfa@condenast
 * @date 2011-6-22
 */
function _content_custom_RandStr($len,$type=4)
{
	/// 可使用的字符
	$sourceStr= array("0","1","2","3","4","5","6","7","8","9","a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z","A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");
	$typeArr = array(
		0=>array("min"=>0,"max"=>9),	/// 全数字
		1=>array("min"=>10,"max"=>35),	/// 全小写
		2=>array("min"=>36,"max"=>61),	/// 全大写
		3=>array("min"=>10,"max"=>61),	/// 大小写
		4=>array("min"=>0,"max"=>61),	/// 数字+大小写
		);
	/// 如果类型错误默认为4
	if(!isset($typeArr[$type]))
	{
		$type = 4;
	}
	/// 生成随机码
	$randstr="";
	for($i=0;$i<$len;$i++)
	{
		$randstr .= $sourceStr[rand($typeArr[$type]["min"],$typeArr[$type]["max"])];
	}
	return $randstr;
}

function _content_custom_ajax_upload(){
	$filepath = file_directory_path();
	$dest = $filepath;
	if(!isset($_FILES['fileToUpload']['name'])){
		exit;
	}
	
	//检查类型	
	if(!in_array($_FILES['fileToUpload']['type'], array('image/png','image/x-png','image/jpeg','image/pjpeg','image/gif','image/bmp','application/octet-stream'))){
		echo json_encode(array('status' => 0, 'error' => '只能上传图片文件'));exit;
	}
	//检查大小	
	if($_FILES['fileToUpload']["size"] > 1024*1024*2){
		echo json_encode(array('status' => 0, 'error' => '上传图片文件不能超过2M'));exit;
	}
		
	$extension = strstr($_FILES['fileToUpload']['name'],'.');
	
	$dest .= '/ppimages/'.time().$extension;
	
	$status = file_copy($_FILES['fileToUpload']['tmp_name'],$dest);
	
	if($status === 1){
		$sql = "insert into {files} (filename,filepath,filemime,filesize,timestamp) values('".$_FILES['fileToUpload']['name']."','".$dest."','".$_FILES['fileToUpload']['type']."',".$_FILES['fileToUpload']["size"].",".time().")";
		db_query($sql);
		$fid = db_last_insert_id();
		$imageurl = imagecache_create_url('250X250',$dest);
		$imagepath = strstr($imageurl, $filepath);		
		echo json_encode(array('status' => 1, 'image' => $imageurl, 'path' => $imagepath, 'fid'=> $fid));exit;
	}

	echo json_encode(array('status' => 0, 'error' => '图片上传失败'));exit;
}

function _content_custom_virtue(){//成长记录首页
	$breadcrumb[] = l('首页', '');
	$breadcrumb[] = l('儿童成长记录', 'virtue');
    drupal_set_breadcrumb($breadcrumb);	
	$content = array();
  	$sql = "select n.nid,n.title, u.name, u.uid, n.created as date,f.filepath as filepath from {node} n 
  	inner join {content_type_daily_virtue} ctdv on ctdv.nid = n.nid
  	left join {files} f on f.fid=ctdv.field_grow_image_fid 
  	inner join {users} u on n.uid = u.uid order by n.created desc";
  	$sql_count = "select count(n.nid) as count from {node} n 
  	inner join {content_type_daily_virtue} ctdv on ctdv.nid = n.nid order by n.created desc";

  	$pageCount = 6;//页面显示数
  	$result = pager_query($sql, $pageCount, 0, $sql_count);

  	$rows = array();
  	$nids = array();
  	while($row = db_fetch_object($result)){  
  		$nids[] = $row->nid;		
  		$vote = theme('vud_widget', $row->nid, 'node', 'vote', 'alternate', 0, 2);
  		$rows[$row -> nid] = array(
  		'uname' => $row -> name,
  		'nid' => $row -> nid, 
  		'title' => substr($row->title,0,300).'...', 
  		'uid' => $row -> uid, 
  		'date' => date('Y-m-d H:i', $row -> date), 
  		'vote' => $vote,
  		'image' => $row -> filepath,
  		);
  	}
  	
  	$content['uservirtues'] = $rows;
  	$rows = array();
  	if($nids){
  		$sql = "select nid,count(nid) as count from {comments} where nid in (".implode(',', $nids).") group by nid ";

  		$res = db_query($sql);  		
  		while($row = db_fetch_object($res)){
  			$rows[$row->nid] = $row;
  		}  		
  		$content['uservirtues_count'] = $rows;
  	}  
	return $content;
}