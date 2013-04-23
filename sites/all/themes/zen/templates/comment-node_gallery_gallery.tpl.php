<?php 
global $user;
$editlink = l('编辑', '/comment/edit/'.$comment -> cid);
$deletelink = l('删除', '/comment/delete/'.$comment -> cid);
?>

<div class="camp-comment <?php print $classes; ?> clearfix">
<div class="comment-author">
<?php echo l($comment -> name, 'user/'.$comment -> uid);?>
发表于:<span><?php echo date('Y-m-d H:i:s', $comment -> timestamp);?></span> <?php echo $user ->uid == $comment -> uid?$editlink.$deletelink:'';?>
</div>
<div class="cmt-content">
<?php echo $comment -> comment;?></div>	  
</div> <!-- /.comment -->
