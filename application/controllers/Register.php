<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class register extends CI_Controller {
	public function index()
	{
        $invalid['invalid']="";
        $invalid['email']="";
        $this->load->view('template/header');
        $this->load->view('register',$invalid);
		$this->load->view('template/footer');
	}
    public function check_register()
	{
        $this->load->model('user_model');	
        $this->load->model('likestatus_model');
        $invalid['invalid']="";
        $invalid['email']=$this->session->userdata('email');
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->view('template/header');
        $username = $this->input->post('username'); //getting username from register form
		$password = $this->input->post('password');
        $encryptedpassword = password_hash($password, PASSWORD_DEFAULT);//Encrypted passwords
        $phonenumber = $this->input->post('phonenumber'); //getting username from register form

        $this->form_validation->set_rules('email', 'Email', 'is_unique[users.email]',array('is_unique' => 'This email address has already been used'));
        $this->form_validation->set_rules('password', 'Password', 'min_length[5]|max_length[25]|callback_password_strength',array('min_length' => 'Your password is too short', 'max_length' => 'Your password is over max length','password_strength' => 'Your password must contain a number(0-9) and a letters(a-Z)'));
		$this->form_validation->set_rules('username', 'Username', 'is_unique[users.username]',array('is_unique' => 'This username has already been used'));
        
        $email = $this->session->userdata('email'); //getting password from register form
		$remember = $this->input->post('remember');
        $vcode = $this->input->post('vcode');
        $nodification = $this->input->post('nodification');
        if($this->form_validation->run()==TRUE){
            if ($this->user_model->verify_token($email,$vcode))//判断数据库是否已经存在这个账户以及Vcode是否正确
            {
                $user_data = array(
                    'username' => $username,
                    'logged_in' => false,
                    'encryptedpassword' => $encryptedpassword,
                    'phonenumber' => $phonenumber,
                    'email' => $email,
                    'nodification' => $nodification 	//create session variable
                );
                $this->session->set_userdata($user_data);
                $this->load->view('setsecretquestion');
            }else{
                $invalid['invalid']="<div class=\"alert alert-danger\" role=\"alert\"> Incorrect Verification Code!! </div> ";
                $this->load->view('register', $invalid);//如果数据库中已经存在丢错提示给用户
            }
            $this->load->view('template/footer');
        }else {
            $invalid['invalid']="";
            $this->load->view('register', $invalid);
            $this->load->view('template/footer');
        }
    }

    public function setquestion(){
        //create user
        $username = $this->session->userdata('username');
        $encryptedpassword = $this->session->userdata('encryptedpassword');
        $phonenumber = $this->session->userdata('phonenumber');
        $email = $this->session->userdata('email');
        $nodification = $this->session->userdata('nodification');
        $question1 = $this->input->post('question1');
        $question2 = $this->input->post('question2');
        $answer1 = $this->input->post('answer1');
        $answer2 = $this->input->post('answer2');
        if ($this->user_model->check_user($username)) { 
            redirect('register');
        }else {
            if($username != NULL && $encryptedpassword != NULL && $phonenumber != NULL && $email != NULL && !empty($question1) 
            && !empty($question2) && !empty($answer1) && !empty($answer2)
            ) {
                $this->user_model->register($username, $encryptedpassword,$phonenumber,$email);
                $user_data = array(
                    'username' => $username,
                    'logged_in' => true,	//create session variable
                );
                $this->session->set_userdata($user_data);
                //set question
                if ($nodification){
                    $this->user_model->setquestion($username,$question1, $answer1,$question2,$answer2,"1");
                }else{
                    $this->user_model->setquestion($username,$question1, $answer1,$question2,$answer2,"0");
                }
                redirect('home');
            }else {
                redirect('register');
            }
        }
    }

    public function password_strength($password){
        if (preg_match('#[0-9]#', $password) && preg_match('#[a-zA-Z]#', $password)) {
            return TRUE;
        }
        return FALSE;
    }

    public function send()
    {
        $this->load->view('template/header');
        $this->form_validation->set_rules('email', 'Email', 'is_unique[users.email]',array('is_unique' => 'This email address has already been used'));
        $email = $this->input->post('email');
        $invalid['invalid']="";
        $invalid['email'] = $email;
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
        }
        $this->load->view('register', $invalid);
        $this->load->view('template/footer');
    }
}
?>