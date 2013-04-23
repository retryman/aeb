<?php
//dpm($node);
?>
<div id="node-<?php print $node->nid; ?>" class="node<?php echo $node -> type; ?> node<?php if ($sticky) { print ' sticky'; } ?><?php if (!$status) { print ' node-unpublished'; } ?>">

<div class="bigimg">
<?php echo $node -> field_node_gallery_image[0]['view'];?>
<?php echo $node -> content['image_navigator']['#value'];?>
</div>

<div class="img-description">
<?php echo $node -> content['body']['#value'];?>
</div>

<?php echo $node -> content['jcarousel']['#value']?>

</div>
