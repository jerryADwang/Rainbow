<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class updatepassword extends CI_Controller {
	public function index()
	{
		$data['passworderror']= "";
        $data['error']= "";
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
                    redirect('updatepassword'); //if user already logined show main page 
					//如果用户logout了需不需要显示login页面 $this->load->view('login', $data); ??????????????????
                }else{
                    redirect('login');	//if username password incorrect, show error msg and ask user to login
                }
			}else{
                redirect('login');	//if username password incorrect, show error msg and ask user to login
			}
		}else{
			$this->load->view('template/updatepassword',$data); //if user already logined show main page
		}
		$this->load->view('template/footer');
	}

    public function update()
	{
        $this->load->model('user_model');
        $data['passworderror']= "";
        $this->load->helper('form');
		$this->load->helper('url');
		$this->load->view('template/header');

        $this->form_validation->set_rules('newpassword', 'Password', 'min_length[5]|max_length[25]|callback_password_strength',array('min_length' => 'Your password is too short', 'max_length' => 'Your password is over max length','password_strength' => 'Your password must contain a number(0-9) and a letters(a-Z)'));
        if($this->session->userdata('logged_in')){
            if($this->form_validation->run()==TRUE){ 
                $user_info=$this->user_model->fetch_data($this->session->userdata('username'));
                $username = $this->session->userdata('username'); //getting username from session
                $newpassword = $this->input->post('newpassword');
                $encryptedpassword = password_hash($newpassword, PASSWORD_DEFAULT);//Encrypted passwords
                $currentpassword = $this->input->post('currentpassword');
                if(password_verify($currentpassword, $user_info->password)){
                    $this->user_model->UpdatePassword($username, $encryptedpassword);
                    $user_data = array(
                        'username' => $username,
                        'logged_in' => true 	//create session variable
                    );
                    $this->session->set_userdata($user_data);
                    redirect('profile');
                }else {
                    $data['error']="<div class=\"alert alert-danger\" role=\"alert\"> Current Password Incorrect!! </div> ";
                    $this->load->view('template/updatepassword',$data);
                    $this->load->view('template/footer');
                }
            }else {
                $data['error']="";
                $this->load->view('template/updatepassword',$data);
                $this->load->view('template/footer');
            }
        }else {
            redirect('login');
        }
    }

    public function close()
	{
        redirect('profile');
    }

    public function password_strength($password){
        if (preg_match('#[0-9]#', $password) && preg_match('#[a-zA-Z]#', $password)) {
            return TRUE;
        }
        return FALSE;
    }
}
?>