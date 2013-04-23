<?php
/**
 * 添加或编辑积分兑换礼品
 */
function _content_custom_pp_present_add_form(){
	$pid = arg(4);

	if(is_numeric($pid)){
		$sql = "select * from {consumption_present} where pid=%d";
		$res = db_query($sql, $pid);
		$present = db_fetch_object($res);
		global $base_url;
		$image = '<img width="200px" src="'.$base_url.'/'.$present->pic.'" />';		
	}
	
	$form = array();
	$form['pid'] = array(
	  '#type' => 'hidden',	 
	 '#default_value' => $present->pid, 
	);
	$form['title'] = array(
	  '#type' => 'textfield',
	  '#title' => '赠品名称',
	  '#default_value' => $present->title, 
	'#size' => 100,
	'#required' => true,
	);
	$form['des'] = array(
	  '#type' => 'textarea',
	  '#title' => '简介',
		'#required' => true,
	 '#default_value' => $present->des, 
	);
	$form['method'] = array(
	  '#type' => 'textarea',
	  '#title' => '兑换方法',
	 '#default_value' => $present->des2, 
	);
	$form['price'] = array(
	  '#type' => 'textfield',
	  '#title' => '礼品价值',
	  '#size' => 10,
		'#required' => true,
	 '#default_value' => $present->price, 
	);
	$form['points'] = array(
	  '#type' => 'textfield',
	  '#title' => '兑换所需积分',
	  '#size' => 10,
		'#required' => true,
	 '#default_value' => $present->score, 
	);
	$form['count'] = array(
	  '#type' => 'textfield',
	  '#title' => '数量',
	  '#size' => 10,
		'#required' => true,
	 '#default_value' => $present->count, 
	);

	$form['weight'] = array(
	  '#type' => 'textfield',
	  '#title' => '排序权重（越大排序越靠前）',
	  '#size' => 10,
	  '#default_value' => 1,
		'#required' => true,
	 '#default_value' => $present->weight, 
	);	
	
	$form['#attributes']['enctype'] = 'multipart/form-data';
	$form['imagepath'] = array(
	  '#type' => 'hidden',
	 '#default_value' => $present->pic, 
	);
	global $base_url;
	$form['attachments']= array(	       
        '#value' => '
        <script type="text/javascript" src="'.$base_url.'/misc/swfupload/swfupload.js"></script>
		<script type="text/javascript" src="'.$base_url.'/misc/swfupload/handlers.js"></script>
		<script type="text/javascript">
		var swfu;
		window.onload = function () {
			swfu = new SWFUpload({
				upload_url: "'.$base_url.'/swfupload/upload",
				post_params: {"PHPSESSID": "<?php echo session_id(); ?>"},

				file_size_limit : "2 MB",	// 2MB
				file_types : "*.jpg;*.png;*.gif",
				file_upload_limit : "0",

				file_queue_error_handler : fileQueueError,
				file_dialog_complete_handler : fileDialogComplete,
				upload_progress_handler : uploadProgress,
				upload_error_handler : uploadError,
				upload_success_handler : uploadSuccess,
				upload_complete_handler : uploadComplete,

				button_image_url : "images/SmallSpyGlassWithTransperancy_17x18.png",
				button_placeholder_id : "spanButtonPlaceholder",
				button_width: 50,
				button_height: 18,
				button_text : \'<span class="button">上传图片</span>\',
				button_text_top_padding: 0,
				button_text_left_padding: 0,
				button_window_mode: SWFUpload.WINDOW_MODE.TRANSPARENT,
				button_cursor: SWFUpload.CURSOR.HAND,
				
				flash_url : "'.$base_url.'/misc/swfupload/swfupload.swf",

				custom_settings : {
					upload_target : "divFileProgressContainer"
				},				
				debug: false
			});
		};
		</script>
		<div style="display: inline; border: solid 1px #7FAAFF; background-color: #C5D9FF; padding: 2px;">
			<span id="spanButtonPlaceholder"></span>
		</div>
		<div id="divFileProgressContainer" style="height:75px;display:none;"></div>
		<div id="thumbnails">'.$image.'</div><input id="imageremove" type="button" value="删除图片" /><br/><br/><br/><br/><br/><br/>
		',
      );

	$form['submit'] = array(
	  '#type' => 'submit',
	  '#value' => '保存'
	);
	return $form;
}

function _content_custom_pp_present_add_form_validate($form, $value){
	
	if(!is_numeric($value['values']['price'])){
		form_set_error('price','礼品价值只能为正整数');
	}
	if(!is_numeric($value['values']['points'])){
		form_set_error('points','兑换所需积分只能为正整数');
	}
	if(!is_numeric($value['values']['count'])){
		form_set_error('count','数量只能为正整数');
	}
	if(!is_numeric($value['values']['weight'])){
		form_set_error('weight','排序权重只能为正整数');
	}

}

function _content_custom_pp_present_add_form_submit($form, $value){
	$pic = $value["values"]["imagepath"];
	$title = $value["values"]["title"];
	$des = $value["values"]["des"];
	$score = $value["values"]["points"];
	$price = $value["values"]["price"];
	$count = $value["values"]["count"];
	$des2 = $value["values"]["method"];
	$weight = $value["values"]["weight"];
	$pid = $value["values"]["pid"];

	if(is_numeric($pid)){
		$sql = "update {consumption_present} set pic = '%s',title = '%s',des='%s',score=%d,price=%d,count=%d,des2='%s',weight=%d where pid=%d";
		$status = db_query($sql,$pic,$title,$des,$score,$price,$count,$des2,$weight,$pid);
	}
	else{
		$sql = "insert into {consumption_present} (pic,title,des,score,price,count,des2,weight,ctime) values('%s','%s','%s',%d,%d,%d,'%s',%d,%d)";
		$status = db_query($sql,$pic,$title,$des,$score,$price,$count,$des2,$weight,time());
	}
	
	if($status){
		drupal_set_message("操作成功");
		drupal_goto('admin/content/passport/present/list');
	}
}

function _content_custom_pp_present_list(){
	$sql = "select * from {consumption_present} order by pid desc";
	$sql_count = "select count(*) as count from {consumption_present}";
	$result = pager_query($sql, 10, 0, $sql_count);
	$rows = array();
	global $base_url;
	while($item = db_fetch_object($result)){		
		$image = '<img width="200px"  src="'.$base_url.'/'.$item->pic.'" >';
		$rows[] = array($item->pid,$item->title,$image,$item->des,$item->score,$item->price,$item->count,$item->des2,$item->weight,l('编辑', 'admin/content/passport/present/'.$item->pid.'/edit'));
	}
	$header = array('ID', '名称','图片', '简介', '兑换所需积分', '价格', '数量', '兑换规则', '权重','操作');
	
	$output = theme('table', $header, $rows);
	
	$output .= theme('pager');
	
	return $output;
}
