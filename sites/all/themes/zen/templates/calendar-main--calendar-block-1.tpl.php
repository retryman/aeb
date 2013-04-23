<?php
// $Id: calendar-main.tpl.php,v 1.2.2.4 2009/01/10 20:04:18 karens Exp $
/**
 * @file
 * Template to display calendar navigation and links.
 * 
 * @see template_preprocess_calendar_main.
 *
 * $view: The view.
 * $calendar_links: Array of formatted links to other calendar displays - year, month, week, day.
 * $calendar_popup: The popup calendar date selector.
 * $display_type: year, month, day, or week.
 * $mini: Whether this is a mini view.
 * $min_date_formatted: The minimum date for this calendar in the format YYYY-MM-DD HH:MM:SS.
 * $max_date_formatted: The maximum date for this calendar in the format YYYY-MM-DD HH:MM:SS.
 * 
 */
//dsm('Display: '. $display_type .': '. $min_date_formatted .' to '. $max_date_formatted);

$urlYear = date('Y', time());

if($_GET['mini']){
	$date_arr = explode('/', $_GET['mini']);
	$yearTemp = explode('-', $date_arr[1]);
	$urlYear = $yearTemp[0];
}

//2011.4.1之前的日期显示message，之后的日期若没创建爱儿帮每日美德跳转到“vitue/date”（一个node）
if($_GET['q'] != 'virtue'){	
	$url_arr = explode('/', $_GET['q']);
	if($url_arr[1]){
		$date_arr = explode('-', $url_arr[1]);
	}
	if(is_numeric($date_arr[0]) && is_numeric($date_arr[1]) && is_numeric($date_arr[2])){
		if(mktime(0, 0, 0, $date_arr[1], $date_arr[2], $date_arr[0]) < mktime(0,0,0,4,1,2011)){
			drupal_set_message('当日没有美德内容，请选择其他日期查看。');
		}
		else{
			drupal_goto('virtue/date');
		}
	}
}

?>

<div class="calendar-calendar">
  <div class="banner">
  	<a name="calendar"><div class="title"></div></a>
  	<span><?php echo $urlYear;?>年</span>
  </div>
  <div class="calendar-inner">
  <?php if (!empty($calendar_popup)) print $calendar_popup;?>
  <?php if (!empty($calendar_add_date)) print $calendar_add_date; ?>
  <?php if (empty($block)) print theme('links', $calendar_links);?>
  <?php print theme('date_navigation', $view) ?> 
  </div> 
</div>