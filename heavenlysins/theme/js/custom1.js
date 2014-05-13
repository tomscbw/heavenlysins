function share(feed_id){
//alert(feed_id)
//return false;
	$.ajax({
		type: 'POST',
		url: site_url+"index.php/user/userfeed1/feedshare/",
		data: {feed_id:feed_id},
		success: function(res){
			 
			
		                      }
	}).done(function(){
		
	}); 
}	






