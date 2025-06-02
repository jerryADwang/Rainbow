<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class favorites extends CI_Controller {
	public function index()
	{
		$data['error']= "";
		$this->load->helper('form');
		$this->load->helper('url');
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
					$this->load->view('favorites'); //if user already logined show main page 
					//如果用户logout了需不需要显示login页面 $this->load->view('login', $data); ??????????????????
				}else{
					redirect('login');	//if username password incorrect, show error msg and ask user to login
				}
			}else{
				redirect('login');	//if username password incorrect, show error msg and ask user to login
			}
		}else{
			$wishlist = $this->shop_model->wishlist($this->session->userdata('username'));
			$result="";
			foreach ($wishlist as $shop) {
				$count = $this->comment_model->count_comment($shop->name);
				// $likecount = $this->Likestatus_model->count_status($shop->name);
				$status =  "bi bi-hand-thumbs-up";
				if ($this->session->userdata('logged_in')){
					if (!$this->Likestatus_model->check_exist($this->session->userdata('username'),$shop->name)) {
						$this->Likestatus_model->add($this->session->userdata('username'),$shop->name);
					}
					
					if ($this->Likestatus_model->status_check($this->session->userdata('username'),$shop->name)->status != '1') {
						$status = 'bi bi-hand-thumbs-up';		
					}else {
						$status = 'bi bi-hand-thumbs-up-fill';	
					}
				}
				$result = $result.'
				<div class="col col-md-4 mt-5 pr-5">
					<a href="https://infs3202-053734f9.uqcloud.net/rainbow/shop/shoppage/'.$shop->name.'"> <img src="https://infs3202-053734f9.uqcloud.net/rainbow/'.$shop->picturepath.'" alt="Shops image"></a>
					<div class="row mt-3">
						<div class="col col-md-6">
								<h3 style="text-transform:capitalize;">'.$shop->name.'</h3>
								<div class="rating pb-3">
									'.$count.' comments
								</div>
						</div>
						<div class="col col-md-4 p-md-0">
							<div class="shopcontent pr-4">
								<div class="bookmark pt-1">
								<a class="btn btn-outline-success bg-light" role="button" type="submit" href="https://infs3202-053734f9.uqcloud.net/rainbow/shop/drop_wishlist/'.$shop->name.'">Drop <i class="bi bi-bag-heart-fill"></i></a>
								</div>
							</div>
						</div>
					</div>
				</div>
				';
			}
			$data['result'] = $result;
			$data['empty'] = "";
			if (empty($result)) {
				$data['empty'] = "Empty Wishlist! Plz add your wishlist on home page!";
			}
			$this->load->view('favorites',$data); //if user already logined show main page
		}
		$this->load->view('template/footer');
	}
}
?>