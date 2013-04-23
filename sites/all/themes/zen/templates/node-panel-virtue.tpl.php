<?php 
drupal_add_js(drupal_get_path('theme', 'zen').'/zen-internals/js/jquery-ui.min.js');
drupal_add_js(drupal_get_path('theme', 'zen').'/zen-internals/js/jquery.mCustomScrollbar.js');

?>
<div class="virtue-notice">
	<div class="banner">
		<div class="title"></div>
	</div>
	<div id="virtue-notice">
	  <div class="customScrollBox">
		<div class="container">
			<div class="content">
			<?php echo $node -> body;?>
			</div>
		</div>
		<div class="dragger_container">
	    		<div class="dragger ui-draggable"></div>
		</div>
	  </div>	
	</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
   $("#virtue-notice").mCustomScrollbar("vertical",600,"easeOutCirc",1.25,"fixed","yes","no",0);
}); 
</script>
