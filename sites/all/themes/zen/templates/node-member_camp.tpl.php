<?php

//dpm($node);
?>

<div id="node-<?php print $node->nid; ?>" class="nodetype_mem_camp clearfix">
	<div class="area_item area_1">
		<h2>环境与交通</h2>
		<div class="dcp-tex">
		<?php echo nl2br($node -> field_content_1[0]['value']);?>
		</div>	
		<?php foreach($node -> field_camp_pic_1 as $item):?>
			<?php if($item['view']):?>
				<?php echo $item['view'];?>
			<?php endif;?>
		<?php endforeach;?>
	</div>
	
	<div class="area_item area_2">
		<h2>硬件设施</h2>
		<div class="dcp-tex">
		<?php echo nl2br($node -> field_content_2[0]['value']);?>
		</div>	
		<?php foreach($node -> field_camp_pic_2 as $item):?>
			<?php if($item['view']):?>
				<?php echo $item['view'];?>
			<?php endif;?>
		<?php endforeach;?>
	</div>
	
	<div class="area_item area_3">
		<h2>软件感受</h2>
		<div class="dcp-tex">
		<?php echo nl2br($node -> field_content_3[0]['value']);?>
		</div>	
		<?php foreach($node -> field_camp_pic_3 as $item):?>
			<?php if($item['view']):?>
				<?php echo $item['view'];?>
			<?php endif;?>
		<?php endforeach;?>
	</div>
	
    <div class="area_item area_4">
		<h2>总体评价</h2>
		<div class="dcp-tex">
		<?php echo nl2br($node -> field_content_4[0]['value']);?>
		</div>	
		<?php foreach($node -> field_camp_pic_4 as $item):?>
			<?php if($item['view']):?>
				<?php echo $item['view'];?>
			<?php endif;?>
		<?php endforeach;?>
	</div>
	
    <div class="area_item area_5">
		<h2>其它</h2>
		<div class="dcp-tex">
		<?php echo nl2br($node -> field_content_5[0]['value']);?>
		</div>	
		<?php foreach($node -> field_camp_pic_5 as $item):?>
			<?php if($item['view']):?>
				<?php echo $item['view'];?>
			<?php endif;?>
		<?php endforeach;?>
	</div>	
	
</div> <!-- /.node -->
