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
$title_old = trim($row->node_title);
if(mb_strlen($title_old, 'utf-8') > 8){	
	$title = mb_substr($title_old, 0, 8, 'utf-8').'...';
}else{
  $title = $title_old;
}

$query = db_query("SELECT nid FROM content_type_node_gallery_gallery WHERE field_org_name_nid = %d", $row->nid);
if ($gid = db_result($query)){
  $nid = $gid;
}else{
  $nid = $row->nid;
}


print l($title, 'node/'.$nid, array('attributes' => array('title' => $title_old))); 
?>
