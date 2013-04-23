<div id="nav" >
<script type="text/javascript">
$(document).ready(function(){
	$("#nav").nav();
});
$.fn.nav=function(){
	var obj=$(this);
	var li=obj.find(">ul >li");
	li.each(function(){
		$(this).hover(function(){
			$(this).find("ul").show().css("left",$(this).offset().left);		   
		},function(){
			$(this).find("ul").hide();
		})				 
	})
};
</script>
	<ul>
    	<li id="n1" class="level1">
        	<a class="topa">育儿点评</a>
        	 <ul>
            	<li><a href="/dianping">帮友点评</a></li>
            	<li><a href="/camp">爱儿帮探营</a></li>
            </ul>
        </li>
    	<li id="n2" class="level1">
        	<a class="topa" href="">育儿护照</a>
            <ul>
            	<li><a href="/funcard/mypage.php">我的护照</a></li>
            	<li><a href="/funcard/coupon.php">育儿优惠</a></li>
            </ul>
        </li>
    	<li id="n3" class="level1">
        	<a class="topa" href="#">趣玩派</a>
            <ul style="display: none; left: 800.5px;">
            	<li><a href="/notices">趣玩活动</a></li>
            	<li><a href="/experience">趣玩分享</a></li>
            	<li><a href="/questions">你问我答</a></li>
            	<li><a href="/virtue">成长记录</a></li>
            </ul>
      </li>
    	<li id="n4" class="level1">
        	<a class="topa" href="#">会员服务</a>
        	<ul>
            	<li><a href="/user/login">登录</a></li>
            	<li><a href="/user/register">注册</a></li>
            </ul>
        </li>
    </ul>
</div>
