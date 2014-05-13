<?php
Class Feedcomment extends CI_Controller
{
	public $mail_id;
	public $login_user_id;
	
	function __construct()
	{
		 parent::__construct();
         $this->load->model('users','', TRUE);
         $this->load->model('feedcomments','', TRUE);
		 $data["usermail"]= $this->session->userdata("useremail");  
		 $tt=$this->users->getuserbyemail($data["usermail"]);
		 $this->login_user_id=$tt['0']->u_id;
	}
	function addcomment(){
		if($_POST){
			$comment_id=$this->feedcomments->addcomment($_POST['feed_id'],$_POST['comment'],$_POST['user_id']);
			echo $this->comment_detail($comment_id);
		}
	}
	
	function updatecomment(){
		
	}
	
	function deletecomment(){
	
	}
	function comment_heaven(){
		if($_POST) {	 
			$res=$this->feedcomments->addheaven($_POST['comment_id'],$this->login_user_id);
			$arr['total_sin']=$this->feedcomments->total_comments('fc_total_sin',$_POST['comment_id']);
			$arr['total_heaven']=$this->feedcomments->total_comments('fc_total_heaven',$_POST['comment_id']);
			echo json_encode($arr);
		}
		die;
	}
    function comment_sins(){
		if($_POST) {	 
			$res=$this->feedcomments->addsins($_POST['comment_id'],$this->login_user_id);
			$arr['total_sin']=$this->feedcomments->total_comments('fc_total_sin',$_POST['comment_id']);
			$arr['total_heaven']=$this->feedcomments->total_comments('fc_total_heaven',$_POST['comment_id']);
			echo json_encode($arr);
		}
		die;
	}
    function comment_unheaven(){
		if($_POST) {	 
			$res=$this->feedcomments->removeheaven($_POST['comment_id'],$this->login_user_id);
			$arr['total_sin']=$this->feedcomments->total_comments('fc_total_sin',$_POST['comment_id']);
			$arr['total_heaven']=$this->feedcomments->total_comments('fc_total_heaven',$_POST['comment_id']);
			echo json_encode($arr);
		}
		die;
	}
    function comment_unsins(){
		if($_POST) {	 
			$res=$this->feedcomments->removesins($_POST['comment_id'],$this->login_user_id);
			$arr['total_sin']=$this->feedcomments->total_comments('fc_total_sin',$_POST['comment_id']);
			$arr['total_heaven']=$this->feedcomments->total_comments('fc_total_heaven',$_POST['comment_id']);
			echo json_encode($arr);
		}
		die;
	}
	
	
	function getallcomments($feed_id=''){
		$res='';
		if($feed_id!=''){
			$data['comments']=$this->feedcomments->getcommentsbyfeedid($feed_id);
			foreach($data['comments'] as $comments){
				$res.=$this->comment_detail($comments->fc_id);
			}
		}
		return $res;
	
	}
	
	function comment_detail($comment_id=''){
		if($comment_id!=''){
			$data['comment']=$this->feedcomments->getcommentbycommentid($comment_id);
			if($data['comment']->fc_comment_by!=''){
				$user_detail=$this->users->userdetails($data['comment']->fc_comment_by);
				$data['user_detail']=$user_detail['0']->ud_firstname. ' ' .$user_detail['0']->ud_lastname;
				return $this->getcomment($data);
			}
		}else{
			return false;
		}
	}
	
	function getcomment($data){
		
		
		$site_url  = base_url();
		$res='<div class="main-col gray-bg" id="commment_show_'.$data['comment']->fc_id.'">
					<div class="inner">
						<div class="comment-2 img15"></div>
						<!--inner-lt closed-->
						<div class="inner-rt comment-middle">
							<p>
								<span>'.$data['user_detail'].'</span> 
								<div class="comment2-rt"><p>'.date('D M, Y',strtotime($data['comment']->fc_comment_time)).'</p></div>
							</p>
							<p class="time">'.$data['comment']->fc_comment.'</p>
						</div>
						<!--comment-middle closed-->
					</div>
					<!--inner closed-->
					<div class="middle-236">
						<div class="heave">
							<ul>';
		
							$res.='<li><a href="#"><span class="comment_heavan_'.$data['comment']->fc_id.'">'.$data['comment']->fc_total_heaven.'</span> Heavenly</a></li>';
							
							$res.='<li><a href="#"><span class="comment_sins_'.$data['comment']->fc_id.'"><img src="'.$site_url.'theme/images/dot.png" alt=""/> &nbsp;'.$data['comment']->fc_total_sin.'</span>&nbsp; Sinful</a></li>
							</ul>
						</div>
						<!--heave closed-->
						<div class="share"> ';
						
						if($this->feedcomments->iscommenthevean($data['comment']->fc_id,$this->login_user_id))
							$res.='<span id="comment_heaven_'.$data['comment']->fc_id.'" ><a href="Javascript:void(0)" onclick="comment_unheaven('.$data['comment']->fc_id.')">
									<img title="Heavenly" alt="" src="'.$site_url.'theme/images/img17.png">
								</a></span> &nbsp;';
						else
							$res.='<span id="comment_heaven_'.$data['comment']->fc_id.'" >
							<a href="Javascript:void(0)" onclick="comment_heaven('.$data['comment']->fc_id.')" class="tooltip bottom animate blue" data-tool="Heavenly">
								<img src="'.$site_url.'theme/images/img20.png" alt="" title="Heavenly"/>
							</a></span> &nbsp; ';
						
						if($this->feedcomments->iscommentsins($data['comment']->fc_id,$this->login_user_id))
							$res.='<span id="comment_sin_'.$data['comment']->fc_id.'" ><a href="Javascript:void(0)" onclick="comment_unsins('.$data['comment']->fc_id.')">
								<img src="'.$site_url.'theme/images/img19.png" alt=""/>
							</a></span>';
						else
							$res.='<span id="comment_sin_'.$data['comment']->fc_id.'" ><a href="Javascript:void(0)" onclick="comment_sins('.$data['comment']->fc_id.')">
								<img alt="" src="'.$site_url.'theme/images/img18.png">
							</a> </span>';	
						$res.=' 
						
						</div>
						<!--share closed-->
					</div>
					<!--white-bg closed-->
				</div>';
		return $res;
	}
	
	 
}

?>
