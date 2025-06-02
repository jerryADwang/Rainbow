<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Upload extends CI_Controller
{
    public function index()
    {
		$this->load->view('template/header'); 
    	if (!$this->session->userdata('logged_in'))//check if user already login
		{	
			if (get_cookie('remember')) { // check if user activate the "remember me" feature  
				$username = get_cookie('username'); //get the username from cookie
				$password = get_cookie('password'); //get the username from cookie
				if ( $this->user_model->login($username, $password) )//check username and password correct
				{
					$user_data = array('username' => $username,'logged_in' => true );
					$this->session->set_userdata($user_data); //set user status to login in session
					redirect('profile');
				}else{
					redirect('login'); //if user already logined direct user to home page
				}
			}else{
				redirect('login'); //if user already logined direct user to home page
			}
		}else{
			redirect('profile');
		}
		$this->load->view('template/footer');
    }

    public function do_upload() {
		$this->load->model('user_model');
		$user_data=$this->user_model->fetch_data($this->session->userdata('username'));
		$data['error'] = '';
		$data['username']= $user_data->username;
		$data['email']= $user_data->email;
		$data['phone']= $user_data->phonenumber;
		$data['membership']= $user_data->membership;
		$config['upload_path'] = 'uploads/';
		$config['allowed_types'] = 'jpg|png';
		$config['max_size'] = 10000;
		$config['max_width'] = 1000;
		$config['max_height'] = 1000;
		$this->load->library('upload', $config);
		$this->load->view('template/header'); 
    	if (!$this->session->userdata('logged_in'))//check if user already login
		{	
			if (get_cookie('remember')) { // check if user activate the "remember me" feature  
				$username = get_cookie('username'); //get the username from cookie
				$password = get_cookie('password'); //get the username from cookie
				if ( $this->user_model->login($username, $password) )//check username and password correct
				{
					$user_data = array('username' => $username,'logged_in' => true );
					$this->session->set_userdata($user_data); //set user status to login in session
					redirect('profile');
				}else{
					redirect('login'); //if user already logined direct user to home page
				}
			}else{
				redirect('login'); //if user already logined direct user to home page
			}
		}else{
			if ( ! $this->upload->do_upload('userfile')) {
				$data['error'] = $this->upload->display_errors();
				if($user_data->path == NULL) {
					$data['path']= base_url("uploads/default.jpg");
				}else {
					$data['path']= base_url($user_data->path);
				}
				$this->load->view('profile',$data);
				$this->load->view('template/footer');
			} else {
				$this->user_model->upload($this->upload->data('file_name'), 'uploads/'.$this->upload->data('file_name'),$this->session->userdata('username'));
				redirect('profile');
			}
		}
		
	}
}

?>

