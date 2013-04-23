<?php
// $Id: views-view-field.tpl.php,v 1.1 2008/05/16 22:22:32 merlinofchaos Exp $
 /**
  * This template is used to print a single field in a view. It is not
  * actually used in default Views, as this is registered as a theme
  * function which has better performance. For single overrides, the
  * template is perfectly okay.
  *
  * Variables available:
  * - $view: The view object
  * - $field: The field handler object that can process the input
  * - $row: The raw SQL result that can be used
  * - $output: The processed output that will normally be used.
  *
  * When fetching output from the $row, this construct should be used:
  * $data = $row->{$field->field_alias}
  *
  * The above will guarantee that you'll always get the correct data,
  * regardless of any changes in the aliasing that might happen if
  * the view is modified.
  */
$title = '';
$title_old = trim($row -> node_title);
$node_viewcount = $row -> node_counter_totalcount?$row -> node_counter_totalcount:0;

if(strlen($title_old) > 18){	
	$title = mb_substr($title_old, 0, 18, 'utf-8').'...('.$node_viewcount.'人阅读，'.$row -> node_comment_statistics_comment_count.'人评论)';
}
else{	
	$title = $title_old.'('.$node_viewcount.'人阅读，'.$row -> node_comment_statistics_comment_count.'人评论)';	
}

//for the taxonomy
$term = '';
if($row -> term_data_name){
	$term = '['.l($row -> term_data_name, 'taxonomy/term/'.$row -> term_data_tid, array('attributes' => array('class' => 'term-link'))).']';
}
?>
<?php print $term.l($title, 'node/'.$row -> nid, array('attributes' => array('title' => $title_old))); ?>