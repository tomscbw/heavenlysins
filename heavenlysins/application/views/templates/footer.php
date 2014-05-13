<div class="footer-outer">
	<div class="wrap">
    	<div class="footer-lt">
        	<div class="copy-right"><p>Copyrights &copy; 2013 HeavenlySins INC, All rights reserved</p></div>
        	 <span><a href="#"><img alt="" src="<?php echo base_url();?>theme/images/dot.png">terms</a> <a href="#">privacy</a></span>
            
        </div><!--footer-lt closed-->
        
        <div class="footer-rt">
        	<ul>
            	<li><a href="#">about</a></li>
                <li><a href="#">contact</a></li>
                <li><a href="#">careers</a></li>
                <li><a href="#">feedback</a></li>
            </ul>
        </div><!--footer-rt closed-->
    </div><!--wrap closed-->
</div>

<input type="hidden" name="login_user_id" id="login_user_id" value="<?php echo isset($login_user_id)?$login_user_id:'';?>">
<input type="hidden" name="user_id" id="user_id" value="<?php echo isset($user_id)?$user_id:'';?>">
<script src="<?php echo base_url();?>theme/js/jquery.min.js"></script>
         
            
<script>
	function upload_img(){
			  $("#fileupload").trigger('click');
		}
    // When the server is ready...
    $(function () {
        'use strict';
        
        // Define the url to send the image data to
        var url = site_url+"index.php/user/userfeed/upload_photo/";
        
        // Call the fileupload widget and set some parameters
        $('#fileupload').fileupload({
            url: url,
            success:function (data) {
                // Add each uploaded file name to the #files list
                    $('#show_cover').html('<img src="<?php echo base_url();?>theme/dragimages/'+ data +'" style="max-width:350px" >');
					$("#c_image_name").val( data );
            },
            progressall: function (e, data) {
                // Update the progress bar while files are being uploaded
                var progress = parseInt(data.loaded / data.total * 100, 10);
				$('.bar,.progress').css('display','block');
                $('.bar').css(
                    'width',
                    progress + '%'
                );
				if(progress=='100'){
					$('.bar,.progress').css('display','none');
					$("#continue_step2,.upload_buton").css('display','block');
				}else{
					$("#continue_step2,.upload_buton").css('display','none');
				}
            }
        });
    });
    
  </script>
<script src="http://www.collageheadz.com/js/jquery.ui.widget.js"></script>
<script src="http://www.collageheadz.com/js/jquery.fileupload.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>theme/css/dragimages.css">
<script src="<?php echo base_url();?>theme/js/simple-slider.js"></script>
</body>
</html>
