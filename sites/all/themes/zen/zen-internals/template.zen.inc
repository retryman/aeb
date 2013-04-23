<?php
// $Id: template.zen.inc,v 1.3 2009/08/24 09:16:01 johnalbin Exp $

/**
 * @file
 * Add stylesheets that are only needed when Zen is the enabled theme.
 *
 * Don't do something this dumb in your sub-theme. Stylesheets should be added
 * using your sub-theme's .info file. If you desire styles that apply
 * conditionally, you can conditionally add a "body class" in the
 * preprocess_page function. For example, see how wireframes.css is handled in
 * zen_preprocess_page() and wireframes.css.
 */

/**
 * If the user is silly and enables Zen as the theme, manually add some stylesheets.
 */
function _zen_preprocess_page(&$vars, $hook) {
  $directory = _zen_path() . '/zen-internals/css';

  // Add default styles.
  if (theme_get_setting('zen_layout') == 'zen-columns-fixed') {
    drupal_add_css($directory . '/zen-fixed.css', 'theme', 'all');
  }
  else {
    drupal_add_css($directory . '/zen-liquid.css', 'theme', 'all');
  }
  
    //只输出当前页面需要的css
  $vars['styles'] = _zen_preprocess_page_load_css();


  // Add IE styles.
  $query_string = '?'. substr(variable_get('css_js_query_string', '0'), 0, 1);
  $base_path = base_path() . $directory;
  $vars['styles'] .= <<< IE_STYLES
<!--[if IE]><link type="text/css" rel="stylesheet" media="all" href="$base_path/ie.css$query_string" /><![endif]-->
<!--[if lte IE 6]><link type="text/css" rel="stylesheet" media="all" href="$base_path/ie6.css$query_string" /><![endif]-->

IE_STYLES;

 
  $vars['scripts'] = _zen_preprocess_page_load_js();

  
}

function _zen_preprocess_page_load_js(){
	$allJs = drupal_add_js();
	if(arg(0) == 'orgnization' || arg(0) == 'virtue'){//only the org comment page
		$arr_temp = $allJs['core'];
		//dpm($arr_temp);
		unset($allJs['core']['misc/jquery.js']);
		unset($allJs['core']['misc/drupal.js']);
		unset($allJs['core']['sites/default/files/languages/zh-hans_542193bf377d2e7aee72caec280b2517.js']);
		
		$allJs['core']['misc/jquery-new.js'] = $arr_temp['misc/jquery.js'];
		$allJs['core']['misc/drupal.js'] = $arr_temp['misc/drupal.js'];
		$allJs['core']['sites/default/files/languages/zh-hans_542193bf377d2e7aee72caec280b2517.js'] = $arr_temp['sites/default/files/languages/zh-hans_542193bf377d2e7aee72caec280b2517.js'];
		
		unset($allJs['module']['sites/all/modules/jquery_ui/jquery.ui/ui/minified/ui.core.min.js']);
		unset($allJs['module']['sites/all/modules/jquery_ui/jquery.ui/ui/minified/effects.core.min.js']);
		unset($allJs['module']['sites/all/modules/jquery_ui/jquery.ui/ui/minified/effects.drop.min.js']);
		unset($allJs['module']['sites/all/modules/lightbox2/js/lightbox.js']);
	}

	
	return drupal_get_js('header', $allJs);
}

function _zen_preprocess_page_load_css(){
	$styles['all']['theme']['sites/all/themes/zen/zen-internals/css/zen-fixed.css'] = true;
	
	if($_GET['q'] == 'home'){//首页
		$styles['all']['module']['sites/all/modules/custom/content_custom/scroll.css'] = true;
	}
	else if(arg(0) == 'virtue'){//每日美德首页
		$styles['all']['module']['sites/all/modules/calendar/calendar.css'] = true;
		$styles['all']['module']['sites/all/modules/date/date.css'] = true;
		$styles['all']['module']['sites/all/modules/custom/content_custom/scroll.css'] = true;		
	}
	else if($_GET['q'] == 'camp'){
		$styles['all']['module']['sites/all/modules/panels/plugins/layouts/twocol_stacked/twocol_stacked.css'] = true;
		$styles['all']['module']['modules/system/defaults.css'] = true;		
		//dpm(drupal_add_css());
	}
	else{
		$styles = drupal_add_css();				
	}
	
	//为管理员用户添加admin_menu.css
	if(user_access('access administration menu')){
		$styles['all']['module']['sites/all/modules/admin_menu/admin_menu.css'] = true;
	}
	
	//为管理员用户添加view.css
	if(user_access('administer views')){		
		$styles['all']['module']['sites/all/modules/views/css/views.css'] = true;
		$styles['all']['module']['sites/all/modules/panels/css/panels.css'] = true;
	}
	

	return drupal_get_css($styles);
}
