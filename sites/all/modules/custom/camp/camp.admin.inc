<?php 
function camp_admin_homepage_fourcolomn(){
	$form = array();
	
	$set_value = unserialize(variable_get('camp_admin_homepage_fourcolomn_value', ''));
	//dpm($set_value);
	for($j = 1; $j < 5; $j++){
		
		$form['area'.$j] = array(
		  '#type' => 'fieldset',
		  '#title' => '设置栏目'.$j,
		  '#weight' => $j,
		  '#collapsible' => TRUE,
		  '#collapsed' => TRUE,
		);
		$form['area'.$j]['title'.$j] = array(
			'#type' => 'textfield',
			'#title' => '栏目标题',
			'#default_value' => $set_value['title'.$j],	
			'#prefix' => '<div class="columntitle">',
			'#suffix' => '</div>'
		);
		
		for($i = 1; $i < 7; $i++){
			$form['area'.$j]['camp_title'.$j.$i] = array(
				'#type' => 'textfield',
				'#title' => '标题'.$i,
				'#default_value' =>  $set_value['camp_title'.$j.$i],
				'#prefix' => '<div class="camp_title">',
				'#suffix' => '</div>'				
			);
			$form['area'.$j]['camp_url'.$j.$i] = array(
				'#type' => 'textfield',
				'#title' => '链接'.$i,
				'#default_value' =>  $set_value['camp_url'.$j.$i],
				'#prefix' => '<div class="camp_url">',
				'#suffix' => '</div>'	
			);
//			$form['area'.$j]['camp_views'.$j.$i] = array(
//				'#type' => 'textfield',
//				'#title' => '关注度'.$i,
//				'#default_value' =>  $set_value['camp_views'.$j.$i],
//				'#prefix' => '<div class="camp_views">',
//				'#suffix' => '</div>'				
//			);
		}
	}

    $form['submit'] = array('#type' => 'submit', '#weight' => 8, '#value' => '保存');
    
	drupal_add_css(drupal_get_path('module', 'camp').'/campAdmin.css');
	
	return $form;
}

function camp_admin_homepage_fourcolomn_submit($form, $form_values){
	$data = serialize($form_values['values']);

	variable_set('camp_admin_homepage_fourcolomn_value', $data);
	cache_clear_all('_camp_block_four_columns_output_value', 'cache');
	
	drupal_set_message('保存成功');
}