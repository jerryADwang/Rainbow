<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ajax extends CI_Controller {
    public function fatch()
    {

        $this->load->helper('form');
		$this->load->helper('url');
		$this->load->model('file_model'); // load file_model 
        $output = '';
        $query = '';
        $shop = $this->session->userdata('shop');
        if($this->input->get('query')){ 
            $query = $this->input->get('query'); // get search query send from ajax search form
        }
        $data = $this->file_model->fetch_data($query,$shop); //send query to file_model and put result to $data
            if(!$data == null){
                echo json_encode ($data->result()); //send result back
            }else{
                echo  ""; // no result found
            }
    }

    public function fatch_comment()
    {

        $this->load->helper('form');
		$this->load->helper('url');
		$this->load->model('file_model'); // load file_model 
        $output = '';
        $shop = $this->session->userdata('shop');
        $data = $this->file_model->fetch_comment($shop); //send query to file_model and put result to $data
            if(!$data == null){
                echo json_encode ($data->result()); //send result back
            }else{
                echo  ""; // no result found
            }
    }

    public function fatch_shop()
    {

        $this->load->helper('form');
		$this->load->helper('url');
		$this->load->model('file_model'); // load file_model 
        $output = '';
        $query = '';
        if($this->input->get('query')){ 
            $query = $this->input->get('query'); // get search query send from ajax search form
        }
        $data = $this->file_model->fetch_shop($query); //send query to file_model and put result to $data
        // $menu = $this->file_model->fetch_menu($query);
        if(!$data == null){
            echo json_encode ($data->result()); //send result back
        }else {
            echo  ""; // no result found
        }
    }


    public function fatch_nodification()
    {
        $this->load->helper('form');
		$this->load->helper('url');
		$this->load->model('file_model'); // load file_model 
        $output = '';//干什么用的？？？？？？？？？
        $username = $this->session->userdata('username');
        $data = $this->file_model->fetch_nodification($username); //send query to file_model and put result to $data
        if(!$data == null){
            echo json_encode ($data->result()); //send result back
        }else {
            echo  ""; // no result found
        }
    }
}
?>