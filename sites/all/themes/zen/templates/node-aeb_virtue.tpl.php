<?php global $base_url;?>
<div id="content" class="row">
	<div class="left">
    	<div class="virtueth"></div>
        <div class="ningjiangtai">
	        <div class="awardusers">
	        	<?php
				$block = module_invoke('content_custom', 'block', 'view', 20);
				print $block['content'];		
				?>

			</div> 
        </div>
        
        <div class="box">
        <?php if($uservirtues):?>
        	<div class="box_top"></div>
            
            <div id="list" class="box_content">
            <?php foreach($uservirtues as $item):?>
            	<dl>
                	<dt>
                    	<p class="user"><a href="/user/<?php echo $item["uid"]?>/cover"><?php echo $item['uname'];?></a></p>
                        <p><span class="title"><?php echo $item['title'];?></span><?php echo l('查看全部', 'node/'.$item['nid'])?></p>
                        <?php if($item["image"]):?>
                        <p><img class="commentimg" style="width:100px;cursor:pointer;"  src="/<?php echo $item["image"] ?>"></p>
                        <?php endif;?>
                    </dt>
                    <dd>
                    	<div class="date"><?php echo $item['date'];?></div> 
                    	
                    	<!-- Baidu Button BEGIN -->
						<div id="bdshare" class="bdshare_t bds_tools get-codes-bdshare" data="{'text':'<?php echo $item['title'];?>','pic':'<?php echo $base_url.'/'.$item["image"]; ?>'}">
						<a class="bds_qzone"></a>
						<a class="bds_tsina"></a>
						<a class="bds_tqq"></a>
						<a class="bds_renren"></a>
						<a class="bds_t163"></a>
						<span class="bds_more"></span>
						<a class="shareCount"></a>
						</div>
						<script type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=0" ></script>
						<script type="text/javascript" id="bdshell_js"></script>
						<script type="text/javascript">
						document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date()/3600000)
						</script>
						<!-- Baidu Button END -->
                    	<div class="button">
                    		<?php echo l('评论', 'node/'.$item['nid'],array('attributes' => array('class'=>'comment')));?>
                    		<div class="comcount"><?php if($uservirtues_count[$item['nid']] ->count):?><?echo $uservirtues_count[$item['nid']] ->count; ?><?php else:?>0<?php endif;?></div>
                    		<?php echo $item["vote"];?>
                        </div>
                    </dd>
                </dl>
                
            <?php endforeach;?> 
            </div>
            
            <div class="box_bottom"></div>
            <?php endif;?>
            
			<div class="pagerbox">
			<?php echo theme('pager', array('','','','',''));?>
			<script type="text/javascript">
			$("ul.pager li").hover(function(){$(this).addClass("hover");},function(){$(this).removeClass("hover");});
			</script>
			</div>
			<div class="clear"></div>
        </div>
    </div>
    
    <div class="right">
		<a <?php if($logged_in):?>href="/node/add/daily-virtue"<?php endif;?> ><div class="calendar-top"></div> </a>    
        
        <div class="calendar">   
<div id="cont"></div>
        </div>
        <div class="clear"></div>
        <div class="form">
        	<?php echo drupal_get_form('_cc_custom_virtue_form');?>
        </div>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$(".commentimg").click(function(){
		if($(this).css("width") == '100px'){
			$(this).css("width",'auto').css('max-width','600px');
		}
		else{
			$(this).css("width",'100px').css('max-width','');
		}
	});
});
</script>