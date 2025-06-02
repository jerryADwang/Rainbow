<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 //put your code here 
 class Likestatus_model extends CI_Model{

    // check status
    public function status_check($username,$shopname){
        $this->db->where('username', $username);
        $this->db->where('shopname', $shopname);
        $result = $this->db->get('status');
        return $result->row();
    }

    // update status
    public function status_update($username,$status,$shopname){
        $time = date('Y');
        $data = array(
            'status' => $status,
            'status_time' => $time
        );
        $this->db->update('status', $data,array('username' => $username,'shopname'=>$shopname));
    }

    // update status
    public function wishlist_update($username,$wishlist,$shopname){
        $time = date('Y');
        $data = array(
            'wishlist' => $wishlist,
            'wishlist_time' => $time
        );
        $this->db->update('status', $data,array('username' => $username,'shopname'=>$shopname));
    }

    // add
    public function count_status($shop){
        $query = $this->db->query(
            'select count(*) num
            from status where status = "1" and shopname = "'.$shop.'"')->row_array();
        return $query['num'];
    }

    // add
    public function count_wishlist($shop){
        $query = $this->db->query(
            'select count(*) num
            from status where wishlist = "1" and shopname = "'.$shop.'"')->row_array();
        return $query['num'];
    }

    // add
    public function check_exist($username,$shopname){
        $this->db->where('username', $username);
        $this->db->where('shopname', $shopname);
        $result = $this->db->get('status');
        if($result->num_rows() == 1){
            return true;
        } else {
            return false;
        }
    }

    // add
    public function add($username,$shopname){
        $time = date('Y');
        $user = array(
            'username' => $username,
            'shopname' => $shopname,
            'wishlist_time' => $time,
            'status_time' => $time
        );
        $this->db->insert('status', $user);
    }
}