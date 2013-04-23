<?php
// $Id: views-view-fields.tpl.php,v 1.6 2008/09/24 22:48:21 merlinofchaos Exp $
/**
 * @file views-view-fields.tpl.php
 * Default simple view template to all the fields as a row.
 *
 * - $view: The view in use.
 * - $fields: an array of $field objects. Each one contains:
 *   - $field->content: The output of the field.
 *   - $field->raw: The raw data for the field, if it exists. This is NOT output safe.
 *   - $field->class: The safe class id to use.
 *   - $field->handler: The Views field handler object controlling this field. Do not use
 *     var_export to dump this object, as it can't handle the recursion.
 *   - $field->inline: Whether or not the field should be inline.
 *   - $field->inline_html: either div or span based on the above flag.
 *   - $field->separator: an optional separator that may appear before a field.
 * - $row: The raw result object from the query, with all data it fetched.
 *
 * @ingroup views_templates
 */
global $user;
$flag = array();
if(function_exists('flag_get_flags')){
	$flags = flag_get_flags('user');
	foreach($flags as $item){
		if($item -> name == 'follow'){
			$flag = $item;
		}
	}
}
$row_user = user_load($row -> uid);
$image = $row_user -> picture?$row_user -> picture:$row_user -> picture_default;
$image = theme('imagecache', 'home_user_right', $image);
?>
<?php foreach ($fields as $id => $field): ?>
  <?php if (!empty($field->separator)): ?>
    <?php print $field->separator; ?>
  <?php endif; ?>

  <<?php print $field->inline_html;?> class="views-field-<?php print $field->class; ?>">
    <?php if ($field->label): ?>
      <label class="views-label-<?php print $field->class; ?>">
        <?php print $field->label; ?>:
      </label>
    <?php endif; ?>
      <?php
      // $field->element_type is either SPAN or DIV depending upon whether or not
      // the field is a 'block' element type or 'inline' element type.
      ?>
      <<?php print $field->element_type; ?> class="field-content"><a href="<?php echo base_path().'user/'.$row -> uid?>"><?php print $image; ?></a></<?php print $field->element_type; ?>>
  </<?php print $field->inline_html;?>>
<?php endforeach; ?>

<?php if($row_user -> profile_cname ):?>
<div class="mon"><span><?php echo $row_user -> profile_cname ?>的妈妈</span></div>
<?php endif;?>

<?php if($user -> uid && $user -> uid != $row -> uid):?>
   <div class="add">
	<?php echo l("加为好友", "relationship/{$row->uid}/request/1", array(
																	      'query' => drupal_get_destination(),
																	      'html'  => TRUE,
																	      'attributes' => array('class' => 'user_relationships_popup_link'),
																	    )
	);?>
	
	<?php if($flag){
		echo $flag->theme($flag->is_flagged($row->uid) ? 'unflag' : 'flag', $row->uid);
	}
	
	?>
   </div>

<?php endif;?>
<div class="clear"></div>
<div class="more-link"><?php echo l('+ 更多', 'users');?></div>