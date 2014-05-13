<?php

/**
 * Wishes Model
 *
 * @author Ravinder
 */
class Friends extends CI_Model {

       function __construct() 
       {
        parent::__construct();

       }
      function getallfriends(){
		  
	  }
	

        function email_validate($email)
      {
	    $query = $this->db->get_where('heaven_user', array('email'=>$email));
            $count = $query->num_rows();  
          return $count;
      }


	public function adduser($email, $pass,$f_name,$l_name,$login_type,$user_data)
       {
		
		$this->db->insert('heaven_user',array("email"=>$email,"password"=>$pass,"f_name"=>$f_name,"l_name"=>$l_name,"login_type"=>$login_type,"user_data"=>$user_data));
		
	}
	
	public function updateuser(){
		
		
	}
	
	public function deleteuser($userid){
	
		$query1 = "update  user_table set u_acitve='D'  WHERE u_id = '$userid'";
		$this->db->query($query1);
		
	}
	
	public function userfriends(){
		
	
	}
	
	public function addfeed(){
		
		
	}
	
	public function updatefeed(){
		
		
	}
	
	public function deletefeed($userid,$feed_id){
		$this->deletefeedlikes($feed_id);
		$this->deletefeedcomments($feed_id);
		$this->deletefeedshare($feed_id);
		
		$query1 = "delete from user_feed  WHERE u_id = '$userid' and u_fid='$feed_id'";
		$this->db->query($query1);
	}
	
	public function getuserfeeds(){
	
	}
	
	public function  userfeedlikes(){
		
	}
	
	public function userfeedcomments(){
		
	}
	
	public function deletefeedlikes($feed_id){
		$query1 = "delete from user_feeds_likes   WHERE  fl_uf_id='$feed_id'";
		$this->db->query($query1);
	}
	
	public function deletefeedcomments($feed_id){
		$query1 = "delete from user_feeds_comments   WHERE  fc_uf_id='$feed_id'";
		$this->db->query($query1);
	}
	
	public function deletefeedshare($feed_id){
		$query1 = "delete from user_feeds_share   WHERE  fs_uf_id='$feed_id'";
		$this->db->query($query1);
	}
}
