$(document).ready(function(){
	$("#submit_feed").on('click',function(){
		var feed_text=$("#feed_text").val();
		$.ajax({
			type: 'POST',
			url: site_url+"index.php/user/userfeed",
			data: {feed_text:feed_text},
			success: function(res){
				$('.container-lt').prepend(res).fadeIn('200');
				$('#feed_text').val('');
			}
		}).done(function(){
			
		}); 	
	});
	
	
});

function sins(feed_id){
	$.ajax({
		type: 'POST',
		url: site_url+"index.php/user/userfeed/sins/",
		data: {feed_id:feed_id},
		success: function(res){
			 
			$('#sin_'+feed_id).html('<a href="Javascript:void(0)" onclick=\'return unsin("'+feed_id+'")\'><span><img src="'+site_url+'theme/images/dot.png" alt=""/></span><img alt="" src="'+site_url+'theme/images/img19.png"></a>');
			$('#heaven_'+feed_id).html('<a href="Javascript:void(0)" onclick=\'return heaven("'+feed_id+'")\'>Heavenly</a>');
		}
	}).done(function(){
		
	}); 
}

function heaven(feed_id){
	$.ajax({
		type: 'POST',
		url: site_url+"index.php/user/userfeed/heaven/",
		data: {feed_id:feed_id},
		success: function(res){
			
			$('#heaven_'+feed_id).html('<a href="Javascript:void(0)" onclick=\'return unheaven("'+feed_id+'")\'><img alt="" src="'+site_url+'theme/images/img14.png"></a>');
			$('#sin_'+feed_id).html('<a href="Javascript:void(0)" onclick=\'return sins("'+feed_id+'")\'><span><img src="'+site_url+'theme/images/dot.png" alt=""/></span>&nbsp; Sinful</a>');
		}
	}).done(function(){
		
	}); 
}


function unheaven(feed_id){
	$.ajax({
		type: 'POST',
		url: site_url+"index.php/user/userfeed/unheaven/",
		data: {feed_id:feed_id},
		success: function(res){
			$('#heaven_'+feed_id).html('<a href="Javascript:void(0)" onclick=\'return heaven("'+feed_id+'")\'>Heavenly</a>');
		}
	}).done(function(){
		
	}); 
}

function unsin(feed_id){
	$.ajax({
		type: 'POST',
		url: site_url+"index.php/user/userfeed/unsin/",
		data: {feed_id:feed_id},
		success: function(res){
			
			$('#sin_'+feed_id).html('<a href="Javascript:void(0)" onclick=\'return sins("'+feed_id+'")\'><span><img src="'+site_url+'theme/images/dot.png" alt=""/></span>&nbsp; Sinful</a>');
			
		}
	}).done(function(){
		
	}); 
}


function comment_heaven(comment_id){
	$.ajax({
		type: 'POST',
		url: site_url+"index.php/user/feedcomment/comment_heaven/",
		data: {comment_id:comment_id},
		dataType: "json",
		success: function(res){
			var d='<a href="Javascript:void(0)" onclick="comment_unheavean(\''+ comment_id +'\')" class="tooltip bottom animate blue" data-tool="Heavenly"> <img src="'+site_url+'theme/images/img17.png" alt="" title="Heavenly"/></a>';
			 
			$('#comment_heaven_'+comment_id).html(d);
			
			var d='<a href="Javascript:void(0)" onclick="comment_sins(\''+comment_id+'\')"><img alt="" src="'+site_url+'theme/images/img18.png"></a>' 
			$('#comment_sin_'+comment_id).html(d);
			$(".comment_heavan_"+comment_id).html(res.total_heaven);
			$(".comment_sins_"+comment_id).html(res.total_sin);
		}
	}).done(function(){
		
	}); 
}


function comment_unheaven(comment_id){
	$.ajax({
		type: 'POST',
		url: site_url+"index.php/user/feedcomment/comment_unheaven/",
		data: {comment_id:comment_id},
		dataType: "json",
		success: function(res){
			 var d='<a href="Javascript:void(0)" onclick="comment_heaven(\''+comment_id+'\')" class="tooltip bottom animate blue" data-tool="Heavenly"><img alt="" src="'+site_url+'theme/images/img20.png"></a>'
			$('#comment_heaven_'+comment_id).html(d);
			
			
			$(".comment_heavan_"+comment_id).html(res.total_heaven);
			$(".comment_sins_"+comment_id).html(res.total_sin);
		}
	}).done(function(){
		
	}); 
}

function comment_sins(comment_id){
	$.ajax({
		type: 'POST',
		url: site_url+"index.php/user/feedcomment/comment_sins/",
		data: {comment_id:comment_id},
		dataType: "json",
		success: function(res){
			 
			 var d='<a href="Javascript:void(0)" onclick="comment_unsins(\''+comment_id+'\')"><img alt="" src="'+site_url+'theme/images/img19.png"></a>'
			$('#comment_sin_'+comment_id).html(d);
			
			 var d='<a href="Javascript:void(0)" onclick="comment_heaven(\''+comment_id+'\')" class="tooltip bottom animate blue" data-tool="Heavenly"><img alt="" src="'+site_url+'theme/images/img20.png"></a>'
			 $('#comment_heaven_'+comment_id).html(d);
			 
			 
			$(".comment_heavan_"+comment_id).html(res.total_heaven);
			$(".comment_sins_"+comment_id).html(res.total_sin);
		}
	}).done(function(){
		
	}); 
}

function comment_unsins(comment_id){
	$.ajax({
		type: 'POST',
		url: site_url+"index.php/user/feedcomment/comment_unsins/",
		data: {comment_id:comment_id},
		dataType: "json",
		success: function(res){
			var d='<a href="Javascript:void(0)" onclick="comment_sins(\''+comment_id+'\')"><img alt="" src="'+site_url+'theme/images/img18.png"></a>' 
			$('#comment_sin_'+comment_id).html(d);
			
			
			$(".comment_heavan_"+comment_id).html(res.total_heaven);
			$(".comment_sins_"+comment_id).html(res.total_sin);
		}
	}).done(function(){
		
	}); 
}


function post_comment(feed_id){
	var comment=$('#comment_box_'+feed_id).val();
	if($.trim(comment)==''){
		alert("Please Write comment");
		return false;
	}
	var user_id=$('#login_user_id').val();
	$.ajax({
		type: 'POST',
		url: site_url+"index.php/user/feedcomment/addcomment/",
		data: {comment:comment,feed_id:feed_id,user_id:user_id},
		success: function(res){
			$('.comment_'+feed_id).append(res);
			$('#comment_box_'+feed_id).val('')
		}
	}).done(function(){
		
	}); 
}
function show_comment_box(comment_box_id){
	
}


