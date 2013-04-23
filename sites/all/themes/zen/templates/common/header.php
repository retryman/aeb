<link type="text/css" rel="stylesheet" media="all" href="/sites/all/modules/admin_menu/admin_menu.css?u" /> 
<link href="/sites/all/themes/zen/zen-internals/css/basic.css?20130224" rel="stylesheet" type="text/css" />
<script src="/misc/jquery-1.9.0.min.js" type="text/javascript"></script>
<div class="header">
<a class="logolink" href="/"><div class="logo" ></div></a>
<div class="cloud" ></div>
<div class="cloud2" ></div>
<input type="button" id="searchBtn" class="searchBtn" />
<input type="text" class="searchtext" id="searchtext" />
<span class="headertext">最省力的育儿生活交流平台</span>
<div class="toploginbox">
 <?php if(!$logged_in):?>
 <a href="/user/register">注册</a>	
 <a href="/user?destination=<?php echo $_GET['q'];?>">登录</a>
 <?php else:?>
 <a href="/logout">退出</a>
 <?php endif;?>
</div> 
</div>
<script type="text/javascript">
$(document).ready(function(){
	$("#searchBtn").click(function(){
		var text = $("#searchtext").val();
		if(text == ''){
			alert("请输入关键字");
			return false;
		}

		window.location = '<?php echo $base_url;?>/search/node/'+encodeURIComponent(text);
	});
});
</script>