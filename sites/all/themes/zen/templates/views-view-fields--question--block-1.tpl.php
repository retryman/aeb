<?php
//check the question's status
$node = node_load($row -> nid);
if($node -> field_question_status[0]['value'] == 1){//the question is finish
	$class="finish";
	$status = "<span>[已解决]</span>";
}
else{
	if($node -> field_reward_type[0]['value'] == 1){//悬赏提问
		$class="reward";
		$status = "<span>[悬赏]</span>";
	}
	else{//一般提问
		$class="normal";
		$status = "<span>[提问中]</span>";
	}
}
?>
<?php foreach ($fields as $id => $field): ?>
  <?php if (!empty($field->separator)): ?>
    <?php print $field->separator; ?>
  <?php endif; ?>

  <<?php print $field->inline_html;?> class="views-field-<?php print $field->class; ?> <?php echo $class;?>">
    <?php if ($field->label): ?>
      <label class="views-label-<?php print $field->class; ?>">
        <?php print $field->label; ?>:
      </label>
    <?php endif; ?>
     <?php print $field->content.' '; ?><?php echo $status;?>
  </<?php print $field->inline_html;?>>
<?php endforeach; ?>
