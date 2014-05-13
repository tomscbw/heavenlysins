$(document).ready(function(){
	

$(".signup-form form,#loginform").submit(function(event){
			
			if(!this.checkValidity())
			{
				
		        event.preventDefault();
                         $(this).addClass('invalid');
			}
                       else
                       {
                        $(this).removeClass('invalid');
                       }
		
			});

	$(".signup-btm .signup-btn").click(function(){$(".signup-form form").submit();});
        $("#loginbutton").click(function(){$("#loginform").submit();});
	
	})


