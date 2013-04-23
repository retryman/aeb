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
$author = user_load($row -> uid);
$image = theme('imagecache', 'home_block_top', $author -> picture);
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
  			
  			<ul class="user-info">
				<li>会员：<a href="<?php echo base_path().'user/'.$author -> uid?>"><?php echo $author->name;?></a></li>
				<li><span class="user-level">会员等级:<?php echo $author -> level;?>级</span></li>
				<li>会员积分:<?php echo $author -> points?></li>
				<li class="last">会员好友:<?php echo $author -> friends_count;?>人</li>
			  </ul>
  
  </<?php print $field->inline_html;?>>
  
<?php endforeach; ?>


			  