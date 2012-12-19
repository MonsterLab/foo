$(function(){
	//1.本部分给导航条的每个li分配宽度, 即导航条宽度除以li的个数 
	var $node = $("#header>ul>li");
	var head_width = $("#header > ul").width();  //获得导航条的长度
	var head_li_width=head_width/$node.length-3; //导航条宽度除以li的个数 
	$node.css('width',head_li_width);
	
	//导航栏最后一个li没有底边框 
	$("#header li.main ul li:last-child").css("border-bottom", "none");
	
	//2.这一段时实现导航条的弹出收回 
	$("#header li.main").hover(function(){
		$(this).children("ul").show();
		$(this).css("border-top", "1px solid #ccc");
	},function(){
		$(this).css("border", "none");
		$(this).css("border-right", "1px solid #ccc");
		$(this).children("ul").hide();
	});
	
	
});