<?php
Class User extends CI_Controller
{
	public $mail_id;
	function __construct()
	{
		parent::__construct();
         $this->load->model('users','', TRUE);

	}
	function index()
	{ 
	 
	 $data=array();	
         
         if($_POST)
         {
            $this->form_validation->set_rules('useremail', 'Email', 'trim|required|valid_email|xss_clean');
            $this->form_validation->set_rules('userpassword', 'Password', 'trim|required');
            if($this->form_validation->run() !== false)
            {
              $email = $this->input->post('useremail');
              $password = $this->input->post('userpassword');   
              $count=$this->users->email_validate($email,$password);
              if($count===0)
              {$data["loginerrormessage"]="<p class='error'>".$email." is not associated with any Heavenlysins account.</p>";
              }else if($count===2)
               {$data["loginerrormessage"]="<p class='error'>*user has not actived his account!</p>";$data["loginemail"]=$email;}
              else if($count===3){$data["loginerrormessage"]="<p class='error'>*Enter valid password</p>";$data["loginemail"]=$email;}
              else{$this->session->set_userdata("useremail",$email);
$data["usermail"]= $email;                 
header("location:http://heavenlysins.com/heavenlysins/index.php/user/userfeed");
// $this->load->view('user/userfeed.php',$data);
                  }
            }
             else{ $data["loginerrormessage"]=validation_errors('<p class="error">','</p>');}
          }
         if($this->session->userdata("useremail"))
         {
            $data["usermail"]= $this->session->userdata("useremail");                 
            $this->load->view('user/userfeed.php',$data);

         }
           $this->load->view('user/user_sign_up',$data);
        }
        function login_by_facebook()
        {
         $fb_config = array(
            'appId'  => '1409807429279591',
            'secret' => 'f77fe56a0e2bd383f3ee391e4a016503');
         $this->load->library('facebook', $fb_config);
         $user = $this->facebook->getUser();
       if ($user) 
       {
            try {
                $data['user_profile'] = $this->facebook
                    ->api('/me?fields=name,birthday,hometown,first_name,last_name,gender,email,link,likes,age_range,home,feed');

              $this->session->set_userdata("facebookemail",$data['user_profile']['email']);
            } catch (FacebookApiException $e) 
             {
                $user = null;
            }
        }
       if ($user) {
            $data['logout_url'] = $this->facebook->getLogoutUrl(array('next' => site_url().'index.php/user/user/url_session/'.urlencode($this->session->userdata("facebookemail")).''));
        } else {
            $data['login_url'] = $this->facebook->getLoginUrl();

        }
       if($user)
      {
       $count=$this->users->email_validate($data['user_profile']['email']);

       if((int)$count===0)
       {
$this->users->adduser($data['user_profile']['email'], '',$data['user_profile']['first_name'],$data['user_profile']['last_name'],'facebook',$data['user_profile']["birthday"]);
        }
      $config = array(
	    'apikey' => '1b1e7b94e1efee0b811c600aee90012a-us3' ,     // Insert your api key
            'secure' => FALSE   // Optional (defaults to FALSE)
	);
     $this->load->library('MCAPI', $config, 'mail_chimp');
      if($this->mail_chimp->listSubscribe("a6fe1cf885", $data['user_profile']['email'])) 
      {
            // $email is now subscribed to list with id: $list_id
      }
    $this->session->sess_destroy();
    $this->facebook->destroySession();
    session_destroy();
    redirect($data['logout_url'], 'refresh');
     }
    else
    {
    redirect($data['login_url'], 'refresh');
    }


 }

function url_session($email)
{
$this->session->set_userdata("useremail",$email);
$data["usermail"]= $email;                 
redirect(site_url().'index.php/user/userfeed', 'refresh');
}
function user_sineup()
	{ 
	 $data=array();	
         if($_POST)
         {
            $this->form_validation->set_rules('useremail', 'Email', 'trim|required|valid_email|xss_clean');
            $this->form_validation->set_rules('userpassword', 'Password', 'trim|required');
            if($this->form_validation->run() !== false)
            {
              $email = $this->input->post('useremail');
              $password = $this->input->post('userpassword');   
              $count=$this->users->email_validate($email,$password);
              if($count===0)
              {
                $this->users->adduser($email, $password,"","",'normal','Y',date('d:m:Y; H:m:s', time()));
                $config = array(
	    'apikey' => '1b1e7b94e1efee0b811c600aee90012a-us3' ,     // Insert your api key
            'secure' => FALSE   // Optional (defaults to FALSE)
	     );
              $this->load->library('MCAPI', $config, 'mail_chimp');
              if($this->mail_chimp->listSubscribe("a6fe1cf885",$email)) 
              {
            // $email is now subscribed to list with id: $list_id
              }
             }
             else{$data["errormessage"]="*Use already exist!";}
            }
             else{ $data["errormessage"]=validation_errors('<p class="error">','</p>');}
          }
           $this->load->view('user/user_sign_up',$data);
        } 
}

?>
