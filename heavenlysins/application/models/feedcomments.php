<?php

/**
 * Wishes Model
 *
 * @author Ravinder K. Pal
 */
class Feedcomments extends CI_Model {

	
	function __construct(){
		parent::__construct();
		
	}
	public function addcomment($feed_id,$comment,$user_id){
		$this->db->trans_start();
		$comment=array(
				'fc_uf_id' => $feed_id,
				'fc_comment_by' => $user_id,
				'fc_comment' => $comment,
				'fc_notification' => 'unread',
			);
		$id=$this->db->insert('user_feeds_comments', $comment); 
		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();
		
		$total_comments=(int)$this->total_h('u_total_comments',$feed_id);
		$total_comments=$total_comments+1;
		
		$data = array('u_total_comments' => $total_comments);
		$this->db->where('u_fid', $feed_id);
		$this->db->update('user_feed', $data); 
		
		return $insert_id;
	}    
	public function total_h($type,$feed_id){
		$query = $this->db->get_where('user_feed',array( 'u_fid'=> $feed_id));
		
		if ($query->num_rows() > 0){
			$row=$query->row() ;
			 
			 if($type=='u_total_comments')
				return  $row->u_total_comments;
			 else
				return 0;
		}else{
			return 0;
		}
	}
	public function getcommentbycommentid($comment_id){
		$query = $this->db->get_where('user_feeds_comments',array( 'fc_id'=> $comment_id));
		return  $query->row();	
	}
	public function getcommentsbyfeedid($feed_id){
		$query = $this->db->get_where('user_feeds_comments',array( 'fc_uf_id'=> $feed_id));
		return  $query->result();	
	}
	public function iscommenthevean($comment_id,$user_id){
		$query = $this->db->get_where('user_comments_heaven',array('heaven_by' => $user_id,'comment_id'=> $comment_id));
		if($query->num_rows() == 0){
			return false;
		}else{
			return true;
		}
	}
	
	public function iscommentsins($comment_id,$user_id){
		$query = $this->db->get_where('user_comments_sin',array('sin_by' => $user_id,'comment_id'=> $comment_id));
		if($query->num_rows() == 0){
			return false;
		}else{
			return true;
		}
	}
	
	public function addheaven($comment_id,$user_id){
		if($this->iscommentsins($comment_id,$user_id)){
			$this->removesins($comment_id,$user_id);
		}
		
		$this->db->insert("user_comments_heaven",array("heaven_by"=>$user_id,"comment_id"=>$comment_id,"notification"=>'unread'));
		
		$total_heaven=(int)$this->total_comments('fc_total_heaven',$comment_id);
		$total_heaven=$total_heaven+1;
		
		$data = array('fc_total_heaven' => $total_heaven);
		$this->db->where('fc_id', $comment_id);
		$this->db->update('user_feeds_comments', $data); 
		
		return $total_heaven;
	}
	public function removeheaven($comment_id,$user_id){
		
		$query = $this->db->where(array('heaven_by'=>$user_id,'comment_id'=> $comment_id));
		$query = $this->db->delete('user_comments_heaven');
	
		if($this->db->affected_rows() > 0){
			
			$total_heaven=(int)$this->total_comments('fc_total_heaven',$comment_id);
			$total_heaven=$total_heaven-1;
			$data = array('fc_total_heaven' => $total_heaven);
			$this->db->where('fc_id', $comment_id);
			$this->db->update('user_feeds_comments', $data); 
		}
		return $total_heaven;
	}
	
	public function total_comments($type,$comment_id){
		$query = $this->db->get_where('user_feeds_comments',array( 'fc_id'=> $comment_id));
		
		if ($query->num_rows() > 0){
			$row=$query->row() ;
			 
			if($type=='fc_total_heaven')
				return  $row->fc_total_heaven;
			elseif($type=='fc_total_sin')
				return  $row->fc_total_sin;
			else
				return 0;
		}else{
			return 0;
		}
	}
	
	
	public function addsins($comment_id,$user_id){
		
		if($this->iscommenthevean($comment_id,$user_id)){
			$this->removeheaven($comment_id,$user_id);
		}
		$this->db->insert("user_comments_sin",array("sin_by"=>$user_id,"comment_id"=>$comment_id,"notification"=>'unread'));
		
		$total_sin=(int)$this->total_comments('fc_total_sin',$comment_id);
		$total_sin=$total_sin+1;
		 
		$data = array('fc_total_sin' => $total_sin);
		$this->db->where('fc_id', $comment_id);
		$this->db->update('user_feeds_comments', $data); 
		return $total_sin;
	}
	public function removesins($comment_id,$user_id){
		$query = $this->db->where(array('sin_by'=>$user_id,'comment_id'=> $comment_id));
		$query = $this->db->delete('user_comments_sin');
		if($this->db->affected_rows() > 0){
			$total_sin=(int)$this->total_comments('fc_total_sin',$comment_id);
			$total_sin=$total_sin-1;
			$data = array('fc_total_sin' => $total_sin);
			$this->db->where('fc_id', $comment_id);
			$this->db->update('user_feeds_comments', $data); 
		}
		return $total_sin;
	}
	
	
}
