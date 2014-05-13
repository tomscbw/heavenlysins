<?php

/**
 * Wishes Model
 *
 * @author Ravinder K. Pal
 */
class Users extends CI_Model {

       function __construct() 
       {
        parent::__construct();

       }
      function getuserdetail(){
	
	
	}
	public function getuserbyemail($email){
		
		
		
		$query = $this->db->from('user_table')->where('u_emailid' , $email)->get();
		return  $query->result();	
	}
	

        function email_validate($email,$pass='null')
        {
            if($pass=='null'){$query = $this->db->get_where('user_table', array('u_emailid'=>$email));$count = $query->num_rows();}
           else
           {
               $query = $this->db->get_where('user_table', array('u_emailid'=>$email,'u_password'=>$pass));
               $count = $query->num_rows();               
               if($count>0)
                {
					$row = $query->row(); 
					$count=  ($row->u_acitve!='Y'?2:1);
                }else{$query = $this->db->get_where('user_table', array('u_emailid'=>$email));$count = $query->num_rows();
                    $count=($count ==1?3:$count);
                }
            }
                      
           return $count;
        }


	public function adduser($email, $pass,$f_name,$l_name,$login_type,$user_dob)
       {

		$this->load->helper('date');
		$data=array("u_emailid"=>$email,"u_password"=>$pass,"u_username"=>$f_name,"u_acitve"=>"Y","u_login_type"=>$login_type);
		$this->db->set('u_cdate', 'NOW()', FALSE);
		$this->db->insert('user_table',$data);

		$this->db->insert("user_detail_table",array("ud_uid"=>$this->db->insert_id(),"ud_firstname"=>$f_name,"d_lastname"=>$l_name,"ud_dob"=>$user_dob));

		
	}
	
	public function updateuser(){
		
		
	}
	
	public function deleteuser($userid){
	
		$query1 = "update  user_table set u_acitve='D'  WHERE u_id = '$userid'";
		$this->db->query($query1);
		
	}
	
	public function userfriends(){
		
	
	}
	//adding feeds to database
	public function addfeed($feeds){
		$this->db->trans_start();
		$id=$this->db->insert('user_feed', $feeds); 
		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		return $insert_id;
	}


        //getting user details by m
        public function userdetails($user_id){		
                
                $query = $this->db->get_where('user_detail_table', array('ud_uid' => $user_id));
                return  $query->result();
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

	// getting user feeds by m 
	public function getuserfeeds($user_id){
		
		
		
		$query = $this->db->from('user_feed')->where('u_uid' , $user_id)->order_by('u_fid', 'desc')->get();
		return  $query->result();	
	}
	
	public function getfeedbyid($feed_id){
		$query = $this->db->get_where('user_feed', array('u_fid' => $feed_id));
		return  $query->result();
	}
	
	public function getfeedsattachments($feed_id){
		$query = $this->db->get_where('attachments', array('att_type_id' => $feed_id, 'att_type'=>'feed'));
		return  $query->result();
	}
	
	public function isfeedhevean($feed_id,$user_id){
		$query = $this->db->get_where('user_feeds_heaven',array('fl_heaven_by' => $user_id,'fl_uf_id'=> $feed_id));
		if($query->num_rows() == 0){
			return false;
		}else{
			return true;
		}
	}
	
	public function isfeedsins($feed_id,$user_id){
		$query = $this->db->get_where('user_feeds_sin',array('fs_sin_by' => $user_id,'fs_uf_id'=> $feed_id));
		if($query->num_rows() == 0){
			return false;
		}else{
			return true;
		}
	}
	
	public function addheaven($feed_id,$user_id){
		if($this->isfeedsins($feed_id,$user_id)){
			$this->removesins($feed_id,$user_id);
		}
		
		$this->db->insert("user_feeds_heaven",array("fl_heaven_by"=>$user_id,"fl_uf_id"=>$feed_id,"fl_notification"=>'unread'));
		
		$total_heaven=(int)$this->total_h('u_total_heaven',$feed_id);
		$total_heaven=$total_heaven+1;
		
		$data = array('u_total_heaven' => $total_heaven);
		$this->db->where('u_fid', $feed_id);
		$this->db->update('user_feed', $data); 
		
		
	}
	public function removeheaven($feed_id,$user_id){
		
		$query = $this->db->where(array('fl_uf_id'=> $feed_id,'fl_heaven_by'=>$user_id));
		$query = $this->db->delete('user_feeds_heaven');
	
		if($this->db->affected_rows() > 0){
			
			$total_heaven=(int)$this->total_h('u_total_heaven',$feed_id);
			$total_heaven=$total_heaven-1;
			$data = array('u_total_heaven' => $total_heaven);
			$this->db->where('u_fid', $feed_id);
			$this->db->update('user_feed', $data); 
		}
	
	}
	
	public function total_h($type,$feed_id){
		$query = $this->db->get_where('user_feed',array( 'u_fid'=> $feed_id));
		
		if ($query->num_rows() > 0){
			$row=$query->row() ;
			 
			if($type=='u_total_heaven')
				return  $row->u_total_heaven;
			elseif($type=='u_total_sin')
				return  $row->u_total_sin;
			elseif($type=='u_total_comments')
				return  $row->u_total_comments;
			elseif($type=='u_total_share')
				return  $row->u_total_share;
			else
				return 0;
		}else{
			return 0;
		}
	}
	
	
	public function addsins($feed_id,$user_id){
		
		if($this->isfeedhevean($feed_id,$user_id)){
			$this->removeheaven($feed_id,$user_id);
		}
		$this->db->insert("user_feeds_sin",array("fs_sin_by"=>$user_id,"fs_uf_id"=>$feed_id,"fs_notification"=>'unread'));
		
		$total_sin=(int)$this->total_h('u_total_sin',$feed_id);
		$total_sin=$total_sin+1;
		 
		$data = array('u_total_sin' => $total_sin);
		$this->db->where('u_fid', $feed_id);
		$this->db->update('user_feed', $data); 
	}
	public function removesins($feed_id,$user_id){
		$query = $this->db->where(array('fs_uf_id'=> $feed_id,'fs_sin_by' => $user_id ));
		$query = $this->db->delete('user_feeds_sin');
		if($this->db->affected_rows() > 0){
			$total_sin=(int)$this->total_h('u_total_sin',$feed_id);
			$total_sin=$total_sin-1;
			$data = array('u_total_sin' => $total_sin);
			$this->db->where('u_fid', $feed_id);
			$this->db->update('user_feed', $data); 
		}
	}
	
	 
	
	public function userfeedcomments(){
		
	}
	
	 
	 
}
