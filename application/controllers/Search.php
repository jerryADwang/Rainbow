<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class search extends CI_Controller {

	public function index()
	{	
		$data['marustatus'] =  "bi bi-hand-thumbs-up";
		$data['nandosstatus'] =  "bi bi-hand-thumbs-up";

		$data['jackpotstatus'] =  "bi bi-hand-thumbs-up";
		$data['marucount'] = $this->Likestatus_model->count_status("maru");
		$data['jackpotcount'] = $this->Likestatus_model->count_status("jackpot");
		$data['nandoscount'] = $this->Likestatus_model->count_status("nandos");
		$data['marucommentcount'] = $this->comment_model->count_comment("maru");
		$data['jackpotcommentcount'] = $this->comment_model->count_comment("jackpot");
		$data['nandoscommentcount'] = $this->comment_model->count_comment("nandos");
		$this->load->model('user_model');
		$this->load->model('likestatus_model');
        $this->load->view('template/header');
		$shoplist = $this->shop_model->shoplist();
		$result="";
		foreach ($shoplist as $shop) {
			$count = $this->comment_model->count_comment($shop->name);
			$likecount = $this->Likestatus_model->count_status($shop->name);
			$status =  "bi bi-hand-thumbs-up";
			if ($this->session->userdata('logged_in')){
				if (!$this->likestatus_model->check_exist($this->session->userdata('username'),$shop->name)) {
					$this->likestatus_model->add($this->session->userdata('username'),$shop->name);
				}
				
				if ($this->likestatus_model->status_check($this->session->userdata('username'),$shop->name)->status != '1') {
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
								<a role="button" href="https://infs3202-053734f9.uqcloud.net/rainbow/home/shop/'.$shop->name.'"><i class="'.$status.'" style="color:red;"></i></a>
							</div>
							<div class="comment mt-2">'.$likecount.' likes</div>
						</div>
					</div>
				</div>
        	</div>
			';
		}
		$data['result'] = $result;
		if ($this->session->userdata('logged_in'))//check if user already login
		{
			if (!$this->likestatus_model->check_exist($this->session->userdata('username'),"maru")) {
				$this->likestatus_model->add($this->session->userdata('username'),"maru");
			}

			if (!$this->likestatus_model->check_exist($this->session->userdata('username'),"nandos")) {
				$this->likestatus_model->add($this->session->userdata('username'),"nandos");
			}

			if (!$this->likestatus_model->check_exist($this->session->userdata('username'),"jackpot")) {
				$this->likestatus_model->add($this->session->userdata('username'),"jackpot");
			}

			if ($this->likestatus_model->status_check($this->session->userdata('username'),"maru")->status != '1') {
				$data['marustatus'] = 'bi bi-hand-thumbs-up';		
			}else {
				$data['marustatus'] = 'bi bi-hand-thumbs-up-fill';	
			}
			if ($this->likestatus_model->status_check($this->session->userdata('username'),"nandos")->status != '1') {
				$data['nandosstatus'] = 'bi bi-hand-thumbs-up';	
			}else {
				$data['nandosstatus'] = 'bi bi-hand-thumbs-up-fill';	
			}
			if ($this->likestatus_model->status_check($this->session->userdata('username'),"jackpot")->status != '1') {
				$data['jackpotstatus'] = 'bi bi-hand-thumbs-up';	
			}else {
				$data['jackpotstatus'] = 'bi bi-hand-thumbs-up-fill';	
			}
		}
		$this->load->view('home',$data);
		$this->load->view('template/footer');
	}
}

?>