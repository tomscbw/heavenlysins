<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Untitled Document</title>
<link href="<?php echo base_url('theme/css/style.css');?>" rel="stylesheet">
<script  type="text/javascript"  src="<?php echo base_url('theme/js/jquery.min.js');?>"></script>
<script type="text/javascript"   src="<?php echo base_url('theme/js/login.js');?>"></script>
<script type="text/javascript"   src="<?php echo base_url('theme/js/custom.js');?>"></script>
<script type="text/javascript"   src="<?php echo base_url('theme/js/custom1.js');?>"></script>
<!--HTML 5 + IE HACK--><!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
</head>
<body>
<div class="outer">
	<div class="wrap">
    	<div class="top-box">
        	<div class="logo"><a href="home-page.html"><img alt="logo heare" src="<?php echo base_url();?>theme/images/logo.png"></a></div>
            <?php if(isset($usermail)){ ?>
            <div class="top-middle">
            	<ul>
                	<li><a href="#"><img alt="" src="<?php echo base_url();?>theme/images/shape-1034.png"></a>
                    	<span>29</span>
                    </li>
                    <li><a href="#"><img alt="" src="<?php echo base_url();?>theme/images/home.png"></a></li>
                    <li><a href="#"><img alt="" src="<?php echo base_url();?>theme/images/setting.png"></a></li>
                    <li><a href="#"><img alt="" src="<?php echo base_url();?>theme/images/shape-1165.png"> &nbsp; Invites</a></li>
                </ul>
            </div><!--top-middle closed-->
             
             <div class="top-rt">
             	<span><img alt="" src="<?php echo base_url();?>theme/images/img1.png"></span>
                <div class="search-bar">
                	<input type="text" placeholder="Start typing..." value="" name="">
                    <span>Confessions</span>
                </div>
             </div><!--top-rt closed-->
             <?php } else{ ?>
<form method="post" action="<?php echo base_url();?>index.php/user/user/" id="loginform">
            <div><?php echo (isset($loginerrormessage)?$loginerrormessage:""); ?> </div>
             <div class="rt-login">
                <div class="ibox">
                    <input type="text" tabindex="1" placeholder="Email" name="useremail" id="email" value="<?php echo (isset($loginemail)?$loginemail:''); ?>" required="required">
                    <br>
                    <input type="checkbox" name="keep_me_login" tabindex="4">Keep me logged in
                </div><!--ibox closed-->

                <div class="ibox">
                    <input type="password" tabindex="2" placeholder="Password" name="userpassword" id="password" value=""  required="required">
                    <br>
                    <a title="Forgot Password?" href="#">Forgot Password?</a>
                </div><!--ibox closed-->

                <div class="submit-wrap">
                    <input type="submit" name="submit" tabindex="3" value="Login" id="loginbutton">
                </div><!--submit-wrap closed-->
            </div><!--rt-login closed--> 
</form>            
<?php } ?>
        </div><!--logo closed-->
    </div><!--wrap closed-->
</div>
