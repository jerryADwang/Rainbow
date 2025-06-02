<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class shop extends CI_Controller {
	public function shoppage($shop = NULL,$messageid = Null)
	{
		$data['error']= "";
		$data['status'] = "bi bi-hand-thumbs-up";
		$data['wishlist'] = "Add";
		$data['disable'] = 'none';
		$this->load->model('likestatus_model');	
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->view('template/header');
		$shop= urldecode($shop);
		
		//when user input an invalid parameters redirect home page
		if ($shop == NULL) {
			redirect('home');
		}
		if($this->comment_model->fetch_shop($shop) == NULL){
			redirect('home');
		}
		if ($messageid != Null) {
			if($this->comment_model->check_nodigication($messageid)) {
				$this->comment_model->nodigication_deleted($messageid);
			}
		}

		$shop_data=$this->comment_model->fetch_shop($shop);

		$data['path']= base_url().$shop_data->picturepath;
		$data['shopname'] = $shop_data->name;
		$data['price'] = $shop_data->price;
		$data['location'] = $shop_data->location;
		$data['openingtime'] = $shop_data->opening_time;
		$data['type'] = $shop_data->type;
		$data['count'] = $this->Likestatus_model->count_status($shop);
		$data['menulist'] = $this->shop_model->menulist($shop);


		if (!$this->session->userdata('logged_in'))//check if user already login
		{	
			$user_data = array(
				'logged_in' => false,
				'shop' => $shop	//create session variable
			);
			$this->session->set_userdata($user_data); //set user status to login in session
			$this->load->view('shop',$data);	//if username password incorrect, show error msg and ask user to login
		}else{
			$username = $this->session->userdata('username');

			$user_data = array(
				'username' => $username,
				'logged_in' => true,
				'shop' => $shop	//create session variable
			);
			$this->session->set_userdata($user_data);

			if (!$this->likestatus_model->check_exist($username,$shop)) {
				$this->likestatus_model->add($this->session->userdata('username'),$shop);
			}

			if ($this->likestatus_model->status_check($this->session->userdata('username'),$shop)->status != '1') {
				$data['status'] = 'bi bi-hand-thumbs-up';		
			}else {
				$data['status'] = 'bi bi-hand-thumbs-up-fill';	
			}
			if ($this->likestatus_model->status_check($this->session->userdata('username'),$shop)->wishlist != '1') {
				$data['wishlist'] = "Add";
			}else {
				$data['wishlist'] = "Drop";
			}
			if ($this->shop_model->ownercheck($this->session->userdata('username'), $shop)) {
				$data['disable'] = 'block';
			}else {
				$data['disable'] = 'none';
			}
			$this->load->view('shop',$data); //if user already logined show main page
		}
		// $this->load->view('template/footer');
	}

    public function add_comment()
	{
		$this->load->model('comment_model');	
		$data['error']= "";
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->view('template/header');
		$text = $this->input->post('comment');
		$location = $this->input->post('location');

		//when user input an invalid parameters redirect to home page
		if ($this->session->userdata('shop') == NULL) {
			redirect('home');
		}else {
			$shop = $this->session->userdata('shop');
		}
		$username = $this->session->userdata('username');
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
					redirect('shop/shoppage/'.$shop); //if user already logined show main page 
					//如果用户logout了需不需要显示login页面 $this->load->view('login', $data); ??????????????????
				}else{
					redirect('login');	//if username password incorrect, show error msg and ask user to login
				}
			}else{
				redirect('login');	//if username password incorrect, show error msg and ask user to login
			}
		}else{
			if (!empty($text)) {
				if (empty($location)) {
					$this->comment_model->add_comment_without_location($username,$text,$shop);
				}else {
					$this->comment_model->add_comment($username,$text,$shop,$location);
				}
				$nodificationlist = $this->user_model->nodificationlist();
				foreach ($nodificationlist as $list) {
					$this->send($list->email,$shop);
					$message = "A new comment have been added in ".$shop;
					$this->comment_model->add_nodigication($list->username,$message,$shop,$text);
				}
				redirect('shop/shoppage/'.$shop); 
			}else {
				redirect('shop/show_add_comment');
			}
		}
    }

	public function send($email,$name)
    {
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
		$this->email->subject('New update');
		$this->email->message('A New comment has been posted in '.$name. '.
		 Check here: https://infs3202-053734f9.uqcloud.net/rainbow/home/show_nodification');
		$this->email->send();
    }

    public function show_add_comment()
	{	
		$data['error']= "";
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->view('template/header');
		if ($this->session->userdata('shop') == NULL) {
			redirect('home');
		}else {
			$shop = $this->session->userdata('shop');
		}
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
					redirect('shop/shoppage/'.$shop);  //if user already logined show main page 
				}else{
					redirect('login');	//if username password incorrect, show error msg and ask user to login
				}
			}else{
				redirect('login');	//if username password incorrect, show error msg and ask user to login
			}
		}else{
			$this->load->view('addcomment');
		}
		$this->load->view('template/footer');
    }

	public function show_add_menu()
	{	
		$data['error']= "";
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->view('template/header');
		if ($this->session->userdata('shop') == NULL) {
			redirect('home');
		}else {
			$shop = $this->session->userdata('shop');
		}
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
					redirect('shop/shoppage/'.$shop);  //if user already logined show main page 
				}else{
					redirect('login');	//if username password incorrect, show error msg and ask user to login
				}
			}else{
				redirect('login');	//if username password incorrect, show error msg and ask user to login
			}
		}else{
			if ($this->shop_model->ownercheck($this->session->userdata('username'), $shop)){
				$this->load->view('template/menudetail',$data);
			}else {
				redirect('shop/shoppage/'.$shop); 
			}
		}
		$this->load->view('template/footer');
    }

	public function createmenu()
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
			if ($this->session->userdata('shop') == NULL) {
				redirect('home');
			}else {
				$shop = $this->session->userdata('shop');
			}
			if ($this->shop_model->ownercheck($this->session->userdata('username'), $shop)){
				$username=$this->session->userdata('username');
				$menuname = $this->input->post('menuname'); 
				$price = $this->input->post('price');
				$data['error'] = '';
	
				$config['upload_path'] = 'assets/img/';
				$config['allowed_types'] = 'jpg|png';
				$config['max_size'] = 10000;
				$config['max_width'] = 1000;
				$config['max_height'] = 1000;

				$this->load->library('upload', $config);
				if ( ! $this->upload->do_upload('userfile')) {
					$data['error'] = $this->upload->display_errors();
					echo 'userfile';
					$this->load->view('template/menudetail',$data);
				} else {
					$this->shop_model->createmenu($menuname,$shop,'assets/img/'.$this->upload->data('file_name'),$price);
					redirect('shop/shoppage/'.$shop); 
				}
			}else {
				redirect('shop/shoppage/'.$shop); 
			}
		}
		$this->load->view('template/footer');
	}

	public function backshop()
	{
		
		//when user reach here without interact the shop page
		if ($this->session->userdata('shop') == NULL) {
			redirect('home');
		}else {
			$shop = $this->session->userdata('shop');
		}
		redirect('shop/shoppage/'.$shop); 
	}

	public function change_status()
	{
		$this->load->model('user_model');
		$this->load->model('likestatus_model');
		$shop = $this->session->userdata('shop');
		if ($this->session->userdata('shop') == NULL) {
			redirect('home');
		}else {
			$shop = $this->session->userdata('shop');
		}

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
					redirect('shop/shoppage/'.$shop); //if user already logined show main page 
				}else{
					redirect('login');
				}	//if username password incorrect, show error msg and ask user to login
			}else {
				redirect('login');
			}
		}else{
			if (!$this->likestatus_model->check_exist($this->session->userdata('username'),$shop)) {
				$this->likestatus_model->add($this->session->userdata('username'),$shop);
			}
			if ($this->likestatus_model->status_check($this->session->userdata('username'),$shop)->status != '1') {
				$this->likestatus_model->status_update($this->session->userdata('username'),'1',$shop);	
			}else {
				$this->likestatus_model->status_update($this->session->userdata('username'),'0',$shop);
			}
			redirect('shop/shoppage/'.$shop); 
		}
	}

	public function change_wishlist()
	{
		$this->load->model('user_model');
		$this->load->model('likestatus_model');
		$shop = $this->session->userdata('shop');
		if ($this->session->userdata('shop') == NULL) {
			redirect('home');
		}else {
			$shop = $this->session->userdata('shop');
		}

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
					redirect('shop/shoppage/'.$shop); //if user already logined show main page 
				}else{
					redirect('login');
				}	//if username password incorrect, show error msg and ask user to login
			}else {
				redirect('login');
			}
		}else{
			if (!$this->likestatus_model->check_exist($this->session->userdata('username'),$shop)) {
				$this->likestatus_model->add($this->session->userdata('username'),$shop);
			}
			if ($this->likestatus_model->status_check($this->session->userdata('username'),$shop)->wishlist != '1') {
				$this->likestatus_model->wishlist_update($this->session->userdata('username'),'1',$shop);	
			}else {
				$this->likestatus_model->wishlist_update($this->session->userdata('username'),'0',$shop);
			}
			redirect('shop/shoppage/'.$shop); 
		}
	}

	public function drop_wishlist($shop = NULL)
	{
		$this->load->model('user_model');
		$this->load->model('likestatus_model');

		if($this->comment_model->fetch_shop($shop) == NULL){
			redirect('favorites');
		}
		if ($shop==NULL) {
			redirect('favorites');
		}

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
					redirect('shop/shoppage/'.$shop); //if user already logined show main page 
				}else{
					redirect('login');
				}	//if username password incorrect, show error msg and ask user to login
			}else {
				redirect('login');
			}
		}else{
			if (!$this->likestatus_model->check_exist($this->session->userdata('username'),$shop)) {
				$this->likestatus_model->add($this->session->userdata('username'),$shop);
			}	
			$this->likestatus_model->wishlist_update($this->session->userdata('username'),'0',$shop);
			redirect('favorites');
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
}
?>