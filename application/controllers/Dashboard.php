<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function index()
    {
        // $data = array("name"=>null, "participants"=>null, "keyword"=>null, "sort_by"=>null, "movie_rate"=>null);
    

        $sort_by = $this->input->get('sort_by');
    
        if(isset($sort_by)){
            $data['sort_by'] = $sort_by;
            // $data['movie_rate'] = $this->Shop_model->dashboard($);
        }
        
        $this->load->view('quiz2_movie',$data);
    }
}

?>