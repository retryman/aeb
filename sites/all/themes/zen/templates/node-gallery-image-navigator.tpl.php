<?php
// $Id: node-gallery-image-navigator.tpl.php,v 1.1.2.3 2010/11/23 15:30:56 justintime Exp $

/**
 * @file
 * Default theme implementation to show a 6 column table containing the image navigator.
 *
 * Available variables:
 * @todo: fill this in
 *
 * @see theme_preprocess_gallery_image_navigator()
 */
?>
<div id="camp-image-nav" class="image-navigator">

<div class="count-nav">
    <?php print t("%current of %total", array('%current' => $navigator['current'], '%total' => $navigator['total'])); ?>
	</div>
	<div class="pre-link">
	        <?php print isset($prev_link) ? '<a nid="'.$navigator['prev_nid'].'" href="'. $prev_link .'"></a>' : '&nbsp;'; ?>
	</div>
	
	<div class="next-link">
	        <?php print isset($next_link) ? '<a  nid="'.$navigator['next_nid'].'" href="'. $next_link .'"></a>' : '&nbsp;'; ?>
	</div>	
</div>
