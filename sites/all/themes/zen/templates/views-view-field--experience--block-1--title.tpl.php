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
if($row -> node_data_field_experience_type_field_experience_type_value == '反思'){
	$type = '<span class="rethink">[反思]</span>';
}
else{
	$type = '<span class="experience">[经验]</span>';
}

$title = '';
$title_old = trim($row -> node_title);
$node_viewcount = $row -> node_counter_totalcount?$row -> node_counter_totalcount:0;
if(strlen(trim($row -> node_title)) > 20){	
	$title = mb_substr($title_old, 0, 20).'...';
}
else{
	$title = $title_old;	
}
?>
<?php print $type.l($title, 'node/'.$row -> nid, array('attributes' => array('title' => $title_old)));; ?>