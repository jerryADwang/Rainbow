<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class updatedetails extends CI_Controller {
	public function index()
	{
        $this->load->model('user_model');
		$data['error']= "";
        $data['username']= "Jerry";
        $data['email']= "Jerry@example.com";
        $data['phonenumber']= "123456";
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->view('template/header');
		if (!$this->session->userdata('logged_in'))//check if user already login
		{	
			if (get_cookie('remember')) { // check if user activate the "remember me" feature  
				$username = get_cookie('username'); //get the username from cookie
				$password = get_cookie('password'); //get the username from cookie
				if ( $this->user_model->login($username, $password) )//check username and password correct
				{
					$user_data = array(
						'username' => $username,
						'logged_in' => true 	//create session variable
					);
					$this->session->set_userdata($user_data); //set user status to login in session
                    redirect('updatedetails');//if user already logined show main page 
					//如果用户logout了需不需要显示login页面 $this->load->view('login', $data); ??????????????????
                }else{
                    redirect('login');	//if username password incorrect, show error msg and ask user to login
                }
			}else{
				redirect('login');	//if username password incorrect, show error msg and ask user to login
			}
		}else{
            $user_data=$this->user_model->fetch_data($this->session->userdata('username'));
            $data['username']= $user_data->username;
            $data['email']= $user_data->email;
            $data['phonenumber']= $user_data->phonenumber;
			$this->load->view('template/updatedetails',$data); //if user already logined show main page
		}
		$this->load->view('template/footer');
	}

    public function update()
	{
        if (!$this->session->userdata('logged_in'))//check if user already login
		{	
			if (get_cookie('remember')) { // check if user activate the "remember me" feature  
				$username = get_cookie('username'); //get the username from cookie
				$password = get_cookie('password'); //get the username from cookie
				if ( $this->user_model->login($username, $password) )//check username and password correct
				{
					$user_data = array(
						'username' => $username,
						'logged_in' => true 	//create session variable
					);
					$this->session->set_userdata($user_data); //set user status to login in session
                    redirect('updatedetails');//if user already logined show main page 
					//如果用户logout了需不需要显示login页面 $this->load->view('login', $data); ??????????????????
                }else{
                    redirect('login');	//if username password incorrect, show error msg and ask user to login
                }
			}else{
				redirect('login');	//if username password incorrect, show error msg and ask user to login
			}
		}else{
            $this->load->model('user_model');
            $this->load->model('likestatus_model');
            $this->load->helper('form');
            $this->load->helper('url');
            $this->load->view('template/header');
            $this->form_validation->set_rules('email', 'Email', 'is_unique[users.email]',array('is_unique' => 'This email address has already been used'));
            $this->form_validation->set_rules('username', 'Username', 'is_unique[users.username]',array('is_unique' => 'This username has already been used'));
            $user_data=$this->user_model->fetch_data($this->session->userdata('username'));
    
            $data['username']= $user_data->username;
            $data['email']= $user_data->email;
            $data['phonenumber']= $user_data->phonenumber;
    
            if($this->form_validation->run()==TRUE){
                if($this->session->userdata('logged_in')){
                    $username = $this->session->userdata('username'); //getting username from session
                    $newusername = $this->input->post('username'); //getting username from register form
                    $phonenumber = $this->input->post('phonenumber'); //getting username from register form
                    $email = $this->session->userdata('email'); //getting password from register form
                    $vcode = $this->input->post('vcode');
                    if ($this->user_model->verify_token($email,$vcode))//判断数据库是否已经存在这个账户以及Vcode是否正确
                    {
                        $this->user_model->UpdateUserDetail($username, $newusername,$email,$phonenumber);
                        $user_data = array(
                            'username' => $newusername,
                            'logged_in' => true 	//create session variable
                        );
                        $this->session->set_userdata($user_data);
                        //set user status to login in session
                        redirect('profile');//返回主界面
                    }else {
                        $data['error']="<div class=\"alert alert-danger\" role=\"alert\"> Incorrect Verification Code!! </div> ";
                    }
                    $this->load->view('template/updatedetails',$data);
                    $this->load->view('template/footer'); 
                }else {
                    redirect('login');
                }
            }else {
                $data['error'] = "";
                $this->load->view('template/updatedetails',$data); 
                $this->load->view('template/footer');
            }
        }

    }

    public function close()
	{
        redirect('profile');
    }

    public function send()
    {
        if (!$this->session->userdata('logged_in'))//check if user already login
		{	
			if (get_cookie('remember')) { // check if user activate the "remember me" feature  
				$username = get_cookie('username'); //get the username from cookie
				$password = get_cookie('password'); //get the username from cookie
				if ( $this->user_model->login($username, $password) )//check username and password correct
				{
					$user_data = array(
						'username' => $username,
						'logged_in' => true 	//create session variable
					);
					$this->session->set_userdata($user_data); //set user status to login in session
                    redirect('updatedetails');//if user already logined show main page 
					//如果用户logout了需不需要显示login页面 $this->load->view('login', $data); ??????????????????
                }else{
                    redirect('login');	//if username password incorrect, show error msg and ask user to login
                }
			}else{
				redirect('login');	//if username password incorrect, show error msg and ask user to login
			}
		}else{
            $this->load->view('template/header');
            $this->form_validation->set_rules('email', 'Email', 'is_unique[users.email]',array('is_unique' => 'This email address has already been used'));
            $email = $this->input->post('email');
            $user_data=$this->user_model->fetch_data($this->session->userdata('username'));
            $data['username']= $user_data->username;
            $data['email']= $user_data->email;
            $data['phonenumber']= $user_data->phonenumber;
            $data['error']="";
            if($this->form_validation->run()==TRUE){
                $config = Array(
                    'protocol' => 'smtp',
                    'smtp_host' => 'mailhub.eait.uq.edu.au',
                    'smtp_port' => 25,
                    'mailtype' => 'html',
                    'charset' => 'iso-8859-1',
                    'wordwrap' => TRUE ,
                    'mailtype' => 'html',
                    'starttls' => true,
                    'newline' => "\r\n"
                    );
                $this->email->initialize($config);
                $this->email->from('s4608756@student.uq.edu.au');
                $this->email->to($email);
                $this->email->subject('Email Verfication');
                $hash = rand(0,999999);
                $this->email->message($hash);
                $this->user_model->insert_token($email,$hash);
                $this->email->send();
                $this->session->set_userdata('email',$email);
                $data['email'] =$email;
            }         
            $this->load->view('template/updatedetails',$data); 
            $this->load->view('template/footer');
        }

    }
}
?>