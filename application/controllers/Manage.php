<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manage extends CI_Controller {
	
	public function index()
	{		
        $this->load->view('template/header');
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
					redirect('manage'); //if user already logined show main page 
				}else{
					redirect('login');
				}
			}else{
				redirect('login');
			}
		}else{
			$menulist = $this->shop_model->ownerlist($this->session->userdata('username'));
			$result="";
			$data['empty'] = "";
			foreach ($menulist as $shop) {
				$likecount = $this->Likestatus_model->count_wishlist($shop->name);
				$result = $result.'
				<div class="col mt-2">
					<div class="card shadow-sm">
					<img src="https://infs3202-053734f9.uqcloud.net/rainbow/'.$shop->picturepath.'" alt="Shops image" style="height:15rem;">
					<div class="card-body">
						<h3 class="card-text text-center" style="text-transform:capitalize;">'.$shop->name.'</h3>
						<div class="d-flex justify-content-between align-items-center">
						<div class="btn-group">
							<a type="button" class="btn btn-sm btn-outline-secondary" href="https://infs3202-053734f9.uqcloud.net/rainbow/shop/shoppage/'.$shop->name.'">View</a>
						</div>
						<p class="text-muted">'.$likecount.'&nbsp people wishlist</p>
						</div>
					</div>
					</div>
				</div>
				';
			}
			$data['empty'] = "<h3>You don't have any shop join us to apply a new shop</h3>";
			$data['result'] = $result;

			$data['sort_by_type'] =NULL;
			$data['year'] =NULL;
			$sort_by = $this->input->get('sort_by');
			$year = $this->input->get('year');
			$sort_by_type = $this->input->get('sort_by_type');
			if(isset($sort_by)){
				$data['sort_by'] =$sort_by;
				$data['dashboard'] = $this->shop_model->dashboard($sort_by);
				$test = $this->shop_model->dashboard($sort_by);
			}
			if(isset($sort_by_type)){
				$data['sort_by_type'] =$sort_by_type;
				$data['year'] =$year;
				$data['dashboard_type'] = $this->shop_model->dashboard_type($sort_by_type,$year,$menulist);
				$test1 = $this->shop_model->dashboard_type($sort_by_type,$year,$menulist);
			}
			$this->load->view('template/manageshop',$data);
		}

		$this->load->view('template/footer');
	}

    public function createshop()
	{		
        $data['error']= "";
        $data['username'] = "";
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->view('template/header');
		if (!$this->session->userdata('logged_in'))//check if user already login
		{	
			$data['username'] = $this->session->userdata('username');
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
                    redirect('manage/createshop');//if user already logined show main page 
				}else {	
					$this->load->view('login', $data);
					$this->load->view('template/footer');
				}
			}else{
				$this->load->view('login', $data);
				$this->load->view('template/footer');	//if username password incorrect, show error msg and ask user to login
			}
		}else{
			$username = $this->session->userdata('username');
			$user_info=$this->user_model->fetch_data($username);
			$data['membership'] = $user_info->membership;

			if ($data['membership'] == 'Premium') {
				$data['placeholder'] = 'Next';
				$data['disable'] = '';
			}else {
				$data['placeholder'] =  'Only for Premium user';
				$data['disable'] = 'disabled';
			}
            $this->load->view('template/shopdetail',$data);
			$this->load->view('template/footer'); //if user already logined show main page
		}

	}

    public function verifyshop()
	{	
		$this->load->view('template/header');
		$data['error'] = "";
		if (!$this->session->userdata('logged_in'))//check if user already login
		{	
			$data['username'] = $this->session->userdata('username');
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
                    redirect('manage/verifyshop');//if user already logined show main page 
				}else {	
					$this->load->view('login', $data);
					$this->load->view('template/footer');
				}
			}else{
				$this->load->view('login', $data);
				$this->load->view('template/footer');	//if username password incorrect, show error msg and ask user to login
			}
		}else{
			$username=$this->session->userdata('username');
			$shopname = $this->input->post('shopname'); 
			$type = $this->input->post('type');
			$openingday = $this->input->post('openingday');
			$location = $this->input->post('location');
			$pp = $this->input->post('pp');
			$this->form_validation->set_rules('shopname', 'Shopname', 'is_unique[shop.name]',array('is_unique' => 'This shop name has already been exist'));
			$data['error'] = '';
			if($this->form_validation->run()==TRUE){
				$this->session->set_userdata('shop',$shopname);
				$this->shop_model->create_shop($username,$shopname,$type,$openingday,$location,$pp);
				$this->load->view('template/shopimage.php',$data);
				$this->load->view('template/footer');
			}else {
				$user_info=$this->user_model->fetch_data($username);
				$data['membership'] = $user_info->membership;
	
				if ($data['membership'] == 'Premium') {
					$data['placeholder'] = 'Next';
					$data['disable'] = '';
				}else {
					$data['placeholder'] =  'Only for Premium user';
					$data['disable'] = 'disabled';
				}
				$this->load->view('template/shopdetail',$data);
				$this->load->view('template/footer');
			}
		}
	}

    public function do_upload() {
		$data['error'] = '';
		$config['upload_path'] = 'assets/img/';
		$config['allowed_types'] = 'jpg|png';
		$config['max_size'] = 10000;
		$config['max_width'] = 1000;
		$config['max_height'] = 1000;

		$this->load->library('upload', $config);
		if ( ! $this->upload->do_upload('userfile')) {
            $this->load->view('template/header');
            $data['error'] = $this->upload->display_errors();
            $this->load->view('template/shopimage.php',$data);
			$this->load->view('template/footer');
        } else {
			$this->shop_model->upload($this->upload->data('file_name'), 'assets/img/'.$this->upload->data('file_name'),$this->session->userdata('shop'));
            redirect('shop/shoppage/'.$this->session->userdata('shop')); 
        }
	}
}
?>
