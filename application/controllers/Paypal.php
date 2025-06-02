<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Paypal extends CI_Controller {

	public function index()
	{
        $data['error'] = "";
        if (!$this->session->userdata('logged_in'))//check if user already login
		{	
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
					redirect('paypal'); //if user already logined show main page 
					//如果用户logout了需不需要显示login页面 $this->load->view('login', $data); ??????????????????
				}else{
					redirect('login');
				}	//if username password incorrect, show error msg and ask user to login
			}else {
				redirect('login');
			}
        }else {
            $this->load->view('template/header');
            $user_info=$this->user_model->fetch_data($this->session->userdata('username'));
			$membership = $user_info->membership;
            if ($membership == "Pro") {
                $this->load->view('template/premium',$data);
            }else{
                $this->load->view('template/pro',$data);
            }
            $this->load->view('template/footer');

        }
	}

    public function level($level = NULL)
	{
        $data['error'] = "";
        if (!$this->session->userdata('logged_in'))//check if user already login
		{	
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
					redirect('paypal/level/'.$level); //if user already logined show main page 
					//如果用户logout了需不需要显示login页面 $this->load->view('login', $data); ??????????????????
				}else{
					redirect('login');
				}	//if username password incorrect, show error msg and ask user to login
			}else {
				redirect('login');
			}
        }else{
            $user_info=$this->user_model->fetch_data($this->session->userdata('username'));
			$membership = $user_info->membership;

            switch ($membership) 
            {
            case 'Pro':
                if ($level =='pro') {
                    $data['error'] = "You are already our Pro user";
                    $this->load->view('template/header');
                    $this->load->view('template/pro',$data);
                    // echo "prouser()"; 
                }else {
                    $this->load->view('template/header');
                    $this->load->view('template/premium',$data);
                }
                break;
            case 'Premium':
                if ($level =='pro') {
                    $this->load->view('template/header');
                    $this->load->view('template/pro',$data);
                }else {
                    $data['error'] = "You are already our Premium user";
                    $this->load->view('template/header');
                    $this->load->view('template/premium',$data);
                }
                break;
            default:
                if ($level =='pro') {
                    $this->load->view('template/header');
                    $this->load->view('template/pro',$data);
                }else {
                    $this->load->view('template/header');
                    $this->load->view('template/premium',$data);
                }
            }
            $this->load->view('template/footer');
        }
	}
}
?>
