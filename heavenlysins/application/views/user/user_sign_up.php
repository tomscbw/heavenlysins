<?php 
include(APPPATH.'/views/templates/header.php');
?>
<div class="wrap">
	<div class="main-container">
    	<div class="signup">
        	<div class="signup-heading">
            	<h1>Sign up, its free!</h1>
            </div><!--signup-heading closed-->
            
            <div class="signup-content">
            	<div class="signup-lt">
                	<div class="signup-title"><p>New User Sign up</p></div>
<div><?php echo (isset($errormessage)?$errormessage:""); ?></div>
                    <div class="signup-form">
                    		<form method="post" action="<?php echo base_url();?>index.php/user/user/user_sineup">

                            	<input type="email"  placeholder="Email" name="useremail" id="email" value="<?php echo (isset($email)?$email:''); ?>" required="required" />
                                <input type="password"  placeholder="Password" name="userpassword" id="password" value=""  required="required" />
                            </form>
                    </div><!--signup-form closed-->
                    <div class="signup-btm">
                        <a href="#" class="signup-btn">Sign Up</a>
                        <p>Use of HeavenlySins constitutes acceptance of our <a href="#">Terms of Use</a> and <a href="#">Privacy Policy</a>.</p>
                    </div><!--signup-btm closed-->
                </div><!--signup-lt closed-->
                
                <div class="signup-rt">
                	<div class="connect-fb">
                    	<a href="<?php echo base_url();?>index.php/user/user/login_by_facebook">Connect with Facebook</a>
                        <p>Don’t worry we do not post anything on your wall.</p>
                    </div><!--connect-fb closed-->
                    <span class="circle-or">or</span>
                </div><!--signup-rt closed-->
            </div><!--signup-heading closed-->
        </div><!--signup closed-->
    </div><!--main-container closed-->
</div>
<?php 
	include(APPPATH.'/views/templates/footer.php');
?>
