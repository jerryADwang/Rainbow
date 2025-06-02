<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class login extends CI_Controller {
	public function index()
	{
		$data['error']= "";
		$data['username'] ="";
		$this->load->model('likestatus_model');
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->view('template/header');
		if (!$this->session->userdata('logged_in'))//check if user already login
		{	
			$data['username']= $this->session->userdata('username');
			if (get_cookie('remember')) { // check if user activate the "remember me" feature  
				$username = get_cookie('username'); //get the username from cookie
				$password = get_cookie('password'); //get the username from cookie
				if ($this->user_model->login($username, $password))//check username and password correct
				{
					$user_data = array(
						'username' => $username,
						'logged_in' => true 	//create session variable
					);
					$this->session->set_userdata($user_data); //set user status to login in session
					redirect('home');//if user already logined show main page 
					//如果用户logout了需不需要显示login页面 $this->load->view('login', $data); ??????????????????
				}else {	
					$this->load->view('login', $data);
				}
			}else{
				$this->load->view('login', $data);	//if username password incorrect, show error msg and ask user to login
			}
		}else{
			redirect('home'); //if user already logined show main page
		}
		$this->load->view('template/footer');
	}

	public function check_login()
	{
		$this->load->model('user_model');//load user model
		$data['error']= "<div class=\"alert alert-danger\" role=\"alert\"> Incorrect username or passwrod!! </div> ";
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->view('template/header');
		$username = $this->input->post('username'); //getting username from login form
		$password = $this->input->post('password'); //getting password from login form
		$remember = $this->input->post('remember'); //getting remember checkbox from login form
		if(!$this->session->userdata('logged_in'))	//Check if user already login
		{
			$data['username']= $username;
			if($this->user_model->check_user($username)) {
				$user_info=$this->user_model->fetch_data($username);
				//Username is unique on SQL
				if(password_verify($password, $user_info->password)) {
					$user_data = array(
						'username' => $username,
						'logged_in' => true 	//create session variable
					);
					if($remember) {// if remember me is activated create cookie
						set_cookie("username", $username, '300'); //set cookie username
						set_cookie("password", $user_info->password, '300'); //set cookie password
						set_cookie("remember", $remember, '300'); //set cookie remember
					}	
					$this->session->set_userdata($user_data); //set user status to login in session
					redirect('home'); // direct user home page
				}else{
					$this->load->view('login', $data);
					$this->load->view('template/footer');	//if username password incorrect, show error msg and ask user to login
				}
			}else{
				$this->load->view('login', $data);
				$this->load->view('template/footer');	//if username password incorrect, show error msg and ask user to login
			}
		}else{
			redirect('home'); //if user already logined direct user to home page
		}
	}
	public function logout()
	{
		$this->session->unset_userdata('logged_in');//delete login status
		set_cookie("username", $username, ''); //set cookie username
		set_cookie("password", $password, ''); //set cookie password
		set_cookie("remember", $remember, ''); //set cookie remember
		redirect('login'); // redirect user back to login
	}
}
?>