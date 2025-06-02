<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 //put your code here 
 class Comment_model extends CI_Model{

    // add
    public function add_comment_without_location($username, $text,$shop){
        $time = date('Y-m-d');
        $comment = array(
            'username' => $username,
            'comment' => $text,
            'time' => $time,
            'shop' => $shop
        );
        $this->db->insert('comment', $comment);
    }

    // add
    public function add_comment($username, $text,$shop,$location){
        $time = date('Y-m-d');
        $comment = array(
            'username' => $username,
            'comment' => $text,
            'time' => $time,
            'location' => $location,
            'shop' => $shop
        );
        $this->db->insert('comment', $comment);
    }

    // add
    public function count_comment($shop){
        $query = $this->db->query(
            'select count(*) num
            from comment where shop = "'.$shop.'"')->row_array();
        return $query['num'];
    }

    //get shop data
    function fetch_shop($shop)
    {
        $sql = "SELECT * FROM shop where name = '$shop'";
        $query = $this->db->query($sql);
        $shop = $query->row();
        return $shop;
    }

    //get shop data
    function add_nodigication($username,$message,$shopname,$text)
    {
        date_default_timezone_set('Australia/Brisbane');
        $time = date('Y/m/d h:i  ', time());
        $data = array(
            'username' => $username,
            'message' => $message,
            'time' => $time,
            'text' => $text,
            'shopname' => $shopname
        );
        $this->db->insert('nodification', $data);
    }

    function check_nodigication($messageid)
    {
        // Validate
        $this->db->where('id', $messageid);
        $result = $this->db->get('nodification');
        if($result->num_rows() == 1){
            return true;
        } else {
            return false;
        }
    }

    function nodigication_deleted($messageid)
    {
        $query = $this->db->query(
            'DELETE
            from nodification 
            where id = "'.$messageid.'"'
    
        );
    }
}