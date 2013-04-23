$(document).ready( function() {
	
	//for search box
	$("#edit-search-theme-form-1").click(function(){
		$(this).attr('value', '');
	});
	$("#edit-search-theme-form-1").blur(function(){
		if($(this).val() == ''){
			$(this).attr('value', '站内搜索');
		}
	});
	
	//for add grow experience page
	$("#edit-orgnization").change(function(){		
		var nid = $(this).attr('value');//taxonomy id(term id)	
		if(!isNaN(nid)){			
			//ajax post the tid
	        $.getJSON(getRootPath()+'/organization_ajax',{nid:nid}, function(data){	        	
	        	$("#org-container").html(data);	        
	        });
		}
		else{		
			
		}
	});	
	
	
	$("#edit-taxonomy-21-hierarchical-select-selects-1").change(function(){		
		var tid = $(this).attr('value');//taxonomy id(term id)	
		if(!isNaN(tid)){	
			
			//ajax post the tid
	        $.getJSON(getRootPath()+'/organization_ajax',{Tid:tid}, function(data){        	
	        	$("#edit-orgnization").empty();
	        	$(data).appendTo("#edit-orgnization");       	
	        	
	        });
		}
		else{		
			
		}
	});	
	
	
	
	//for top menu(homepage)
	$("#block-menu-menu-top-menu ul li").mouseover(function(){
		$(this).addClass('mouseover');
	});  
	$("#block-menu-menu-top-menu ul li").mouseout(function(){
		$(this).removeClass('mouseover');
	});
	$("#block-menu-menu-top-menu ul li a").attr('target', '_blank');
	
	
	//for user cover page	
	if(location.pathname.indexOf("user") > 0 && location.pathname.indexOf("cover") >0){
		$('#block-menu-menu-top-menu ul li.last').addClass('active');
	}
	
	//for user info hover
	$("ul li.user-item").mouseover(function(){
		$(this).addClass('mouseover');		
	});  
	$("ul li.user-item").mouseout(function(){
		$(this).removeClass('mouseover');
	});
	$(".views-field-picture").mouseover(function(){
		$(this).addClass('mouseover');		
	});  
	$(".views-field-picture").mouseout(function(){
		$(this).removeClass('mouseover');
	});
	
	//for edit and delete link
	$("#block-views-experience-block_1 .views-field-edit-node a").empty();
	$("#block-views-experience-block_1 .views-field-delete-node a").empty();
	
	$("#block-views-question-block_6 .views-field-edit-node a").empty();
	$("#block-views-question-block_6 .views-field-delete-node a").empty();
	
	$("#block-content_custom-7 .edit-comment a").empty();
	$("#block-content_custom-7 .delete-comment a").empty();
	
	$("#block-views-resource-block_1 .views-field-edit-node a").empty();
	$("#block-views-resource-block_1 .views-field-delete-node a").empty();
	
	//for homepage
	$(".pane-content-custom-1 .logined a").click(function(){
		alert("您已经创建了帐号，并且成功登录。");
		return false;
	});
	
	/*
	//for all the pages	
	var floatlink = $("#floatlink .floatlink-inner");
	var timer = setInterval(blinkLinkBlock,400);
	function blinkLinkBlock()
	{	
	   if(floatlink.css("display") == 'block'){
	      floatlink.hide();
	   }
	   else{
	     floatlink.show();
	   }
	}
	$("#floatlink .floatlink-inner").hover(
	function(){
		clearInterval(timer);
	},
	function(){
		timer = setInterval(blinkLinkBlock,400);
	});
	*/
});
