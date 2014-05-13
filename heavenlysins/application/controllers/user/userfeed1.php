<?php
Class Userfeed1 extends CI_Controller
{
	public $mail_id;
	public $login_user_id;
	function __construct()
	{
		parent::__construct();
        $this->load->model('users','', TRUE);
        
        $data["usermail"]= $this->session->userdata("useremail");  
		$tt=$this->users->getuserbyemail($data["usermail"]);
		$this->login_user_id=$tt['0']->u_id;
	}
	function empty_post(){
		 $res[]='<div class="container-inner">
				<div class="main-col">
					<div class="inner">
						<div class="inner-lt"></div>
						<div class="inner-rt">
							<p>No post.  </p>
						</div>
					</div>
				</div>
			</div>';
		return $res; 
	}
	function index($user_id=''){
		 $data["usermail"]= $this->session->userdata("useremail");  
        if(empty($data["usermail"])){
			header("location:http://heavenlysins.com/heavenlysins/index.php");
			die;
		}
		if($user_id=='')
			$user_id=$this->login_user_id;
		
		 if($_POST) {	 
			$res=$this->addfeed($_POST,$user_id);
			die($res);
		 }
		 
		 $data['feeds']=$this->getfeeds($user_id);
		 if(count($data['feeds'])<1){
			$data['feeds']=$this->empty_post();
		 }
	     $this->load->view('user/userfeed',$data);
    }
    
    function heaven(){
		if($_POST) {	 
			$res=$this->users->addheaven($_POST['feed_id'],$this->login_user_id);
		}
		die;
	}
    function sins(){
		if($_POST) {	 
			$res=$this->users->addsins($_POST['feed_id'],$this->login_user_id);
		}
		die;
	}
    function unheaven(){
		if($_POST) {	 
			$res=$this->users->removeheaven($_POST['feed_id'],$this->login_user_id);
		}
		die;
	}
    function unsin(){
		if($_POST) {	 
			$res=$this->users->removesins($_POST['feed_id'],$this->login_user_id);
		}
		die;
	}
    function getfeeds($user_id){
		$data["user_details"]  =  $this->users->userdetails($user_id);
		$data["user_feeds"]  =  $this->users->getuserfeeds($user_id);
		 
		$res=array();
		if(count($data["user_feeds"])>0){
			foreach($data["user_feeds"] as $feed){
				$data["user_feeds_attachments"] = $this->users->getfeedsattachments($feed->u_fid);
				if(isset($data["user_feeds_attachments"]['0'])){
					$res[]=$this->singlefeed($feed,$data["user_details"]['0'],$data["user_feeds_attachments"]['0']);
					unset($data["user_feeds_attachments"]);
				}else{
					$data["user_feeds_attachments"]['0']='';
					$res[]=$this->singlefeed($feed,$data["user_details"]['0'],$data["user_feeds_attachments"]['0']);
				}
			}
		}
		return $res;
	}
	
    function addfeed($_POST, $user_id){
		
		$add_feed = array(
		   'u_uid' => $user_id,
		   'u_text' => $_POST['feed_text']		   
		); 				
		$response = $this->users->addfeed($add_feed);
		//$response=3;
		$data["user_details"]  =  $this->users->userdetails($user_id);
		$data["user_feeds"]  =  $this->users->getfeedbyid($response);
		$data["user_feeds_attachments"]  =  $this->users->getfeedsattachments($response);
		 
		$res='';
		if($response){
			if(isset($data["user_feeds_attachments"]['0'])){
				$res=$this->singlefeed($data["user_feeds"]['0'],$data["user_details"]['0'],$data["user_feeds_attachments"]['0']);
			}else{
				$data["user_feeds_attachments"]['0']='';
				$res=$this->singlefeed($data["user_feeds"]['0'],$data["user_details"]['0'],$data["user_feeds_attachments"]['0']);
			}
		}
		return  $res;
			
	}
        
    function singlefeed($feed,$user_detail,$user_feeds_attachment){
		$user_id=$user_detail->ud_uid;
		$feed_id=$feed->u_fid;
		$date=date('h:i A',strtotime($feed->u_feed_time));				
		$site_url  = base_url();
		$res='<div class="container-inner">
				<div class="main-col">
					<div class="inner">
						<div class="inner-lt"></div>
						<div class="inner-rt"><p><span>'.$user_detail->ud_firstname.' '.$user_detail->ud_lastname.'</span> has post.  </p><p class="time">Today at '.$date.'</p>
						</div>
					</div>';
		if($feed->u_text!='')
		$res.='<p class="color">'.$feed->u_text.'</p>';
		
		$res.='</div>';	
		
		if(!is_array($user_feeds_attachment) && $user_feeds_attachment!='')			 
			$res.='<div class="bannar"><img src="'.$site_url.'theme/images/bannar.png" alt="" /></div>';		
					  
		$res.='<div class="main-col bannar-btm">
					<div class="heave">
						<ul>';
		
					
		if($this->users->isfeedhevean($feed_id,$this->login_user_id))
			$res.='<li id="heaven_'.$feed_id.'" ><a href="Javascript:void(0)" onclick=\'return unheaven("'.$feed_id.'")\'><img alt="" src="'.$site_url.'theme/images/img14.png"></a></li>';
		else
			$res.='<li id="heaven_'.$feed_id.'"><a href="Javascript:void(0)" onclick=\'return heaven("'.$feed_id.'")\'>Heavenly</a></li>';
		
		if($this->users->isfeedsins($feed_id,$this->login_user_id))
			$res.='<li>
						<a href="#">
							<span><img src="'.$site_url.'theme/images/dot.png" alt=""/></span>
							<img alt="" src="'.$site_url.'theme/images/img19.png">
						</a>
					</li>';
		else
			$res.='<li id="sin_'.$feed_id.'">
					<a href="Javascript:void(0)" onclick=\'return sins("'.$feed_id.'")\'>
						<span><img src="'.$site_url.'theme/images/dot.png" alt=""/></span>&nbsp; Sinful
					</a>
				   </li>';
			
			
			
		$res.='<li><a href="#"><span><img src="'.$site_url.'theme/images/dot.png" alt=""/></span>&nbsp; Comment</a></li>';
		
		
		
		$res.='</ul>
					</div>
					<div class="share" id="share">
						<a href="Javascript:void(0)" onclick="
share(\''.$feed_id.'\')"><img src="'.$site_url.'theme/images/share-icon.png" alt=""/> &nbsp;share</a>
					</div>
				</div>';
				
		/*** For add and list all Comments ***/ 
		$res.= $this->addcomment($feed->u_fid);		
		
		$res.= $this->getcomments($feed->u_fid);		
		
		
		$res.='</div>';   
		return $res;
	}
	function addcomment($feed_id){
		$site_url  = base_url(); 
		$res='<div class="main-col">
					<div class="inner">
						<div class="inner-lt comment"></div>
						<div class="write-comment"><textarea  class="comment_box"  name="comment_box_'.$feed_id.'" id="comment_box_'.$feed_id.'" placeholder="Write Comment"></textarea></div>
						<div class="camara"><img src="'.$site_url.'theme/images/camara.png" alt=""/></div>
						<div class="camara"><input type="button" onclick="post_comment(\''.$feed_id.'\')"></div>
					</div>
					<!--<div class="inner comment-img"> <span></span><p>Mention person or brand with “@” in your comment.</p></div>-->
				</div>';
		return $res;
	}
	function getcomments($feed_id){
		$site_url  = base_url();
		$res='<div class="main-col gray-bg" id="commment_show_'.$feed_id.'">
					<div class="inner">
						<div class="comment-2 img15"></div>
						<!--inner-lt closed-->
						<div class="inner-rt comment-middle">
							<p>
								<span>Katrina Pollock</span> 
								<div class="comment2-rt"><p>2 hours ago</p></div>
							</p>
							<p class="time">No doubt it’s an amazing movie! simply loved it.</p>
						</div>
						<!--comment-middle closed-->
					</div>
					<!--inner closed-->
					<div class="middle-236">
						<div class="heave">
							<ul>
								<li><a href="#"><span class>236</span> Heavenly</a></li>
								<li><a href="#"><span><img src="'.$site_url.'theme/images/dot.png" alt=""/> &nbsp;0&nbsp;</span>Sinful</a></li>
							</ul>
						</div>
						<!--heave closed-->
						<div class="share"> 
							<a href="#" class="tooltip bottom animate blue" data-tool="Heavenly">
								<img src="'.$site_url.'theme/images/img17.png" alt="" title="Heavenly"/>
							</a> &nbsp; 
							<a href="#"><img src="'.$site_url.'images/img18.png" alt=""/></a> 
						</div>
						<!--share closed-->
					</div>
					<!--white-bg closed-->
				</div>';
		return $res;
	}
	
	 
}


?>
