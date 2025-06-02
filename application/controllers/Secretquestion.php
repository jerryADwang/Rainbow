<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class secretquestion extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$data['error'] = "";
		$this->load->view('template/header');
		$this->load->view('resetpassword',$data);
		$this->load->view('template/footer');
	}

	public function check_user()
	{
		$this->load->view('template/header');
        $username = $this->input->post('username');
		if ($this->user_model->check_user($username)) {
			$user_data = array(
				'username' => $username,
				'logged_in' => false,	//create session variable
			);
			$this->session->set_userdata($user_data);
			$questions= $this->user_model->fetch_data($username);
			$data['question1'] = $questions->question1;
			$data['question2'] = $questions->question2;
			$data['error'] = "";
			$this->load->view('verifysecretquestion',$data);
		}else {
			$data['error'] = "Username invalid!!";
			$this->load->view('resetpassword',$data);
		}
		$this->load->view('template/footer');
	}

	public function verify()
	{
		$this->load->view('template/header');

		$username = $this->session->userdata('username');
		$questions= $this->user_model->fetch_data($username);
		$answer1 = $this->input->post('answer1');
		$answer2 = $this->input->post('answer2');
		if (!empty($answer1) && !empty($answer2)) {
			if ($answer1 == $questions->answer1 && $answer2 == $questions->answer2) {
				$this->session->set_userdata('secretquestion',TRUE);
				$this->load->view('template/setpassword');
			}else {
				$questions= $this->user_model->fetch_data($username);
				$data['question1'] = $questions->question1;
				$data['question2'] = $questions->question2;
				$data['error'] = "Incorrect answer!!";
				$this->load->view('verifysecretquestion',$data);
			}
			$this->load->view('template/footer');
		}else {
			redirect('secretquestion');
		}

	}

	public function reset()
	{
		if ($this->session->userdata('secretquestion')) {
			$this->load->view('template/header');
			$username = $this->session->userdata('username');
			$password1 = $this->input->post('password1');
			$password2 = $this->input->post('password2');
			$encryptedpassword = password_hash($password1, PASSWORD_DEFAULT);
			$this->form_validation->set_rules('password2', 'Password', 'matches[password1]',array('matches' => 'Enter password differently'));
			$this->form_validation->set_rules('password1', 'Password', 'matches[password2]|min_length[5]|max_length[25]|callback_password_strength',array('min_length' => 'Your password is too short', 'max_length' => 'Your password is over max length','password_strength' => 'Your password must contain a number(0-9) and a letters(a-Z)','matches' => 'Enter password differently'));
			if($this->form_validation->run()==TRUE){ 
				$user_data = array(
					'username' => $username,
					'logged_in' => true 	//create session variable
				);
				$this->session->set_userdata($user_data);
				$this->user_model->UpdatePassword($username,$encryptedpassword);
				$this->session->set_userdata('secretquestion',FALSE);
				redirect('home');
			}else {
				$this->load->view('template/setpassword');
				$this->load->view('template/footer');
			}
		}else {
			redirect('secretquestion');
		}
	}

    public function password_strength($password){
        if (preg_match('#[0-9]#', $password) && preg_match('#[a-zA-Z]#', $password)) {
            return TRUE;
        }
        return FALSE;
    }
}
?>