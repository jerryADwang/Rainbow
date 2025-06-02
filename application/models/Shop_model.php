<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 //put your code here 
 class Shop_model extends CI_Model{

    function create_shop($username,$shopname,$type,$time,$location,$pp)
    {
        $data = array(
            'username' => $username,
            'name' => $shopname,
            'opening_time' => $time,
            'type' => $type,
            'location' => $location,
            'price' => $pp,
        );
        $this->db->insert('shop', $data);
    }

    //  upload shop file
    public function upload($filename, $path,$shop){
        $data = array(
            'picturename' => $filename,
            'picturepath' => $path,
        );
        $this->db->update('shop', $data,array('name' => $shop));
    }

    //  feach all shop data
    public function shoplist(){
        $query = $this->db->query('select * from shop order by name ASC');
        $shoplist = $query->result();
        return $shoplist;
    }

    //  feach wishlist
    public function wishlist($username){
        $query = $this->db->query(
            'select shop.name, shop.picturepath 
            from shop, status 
            where shop.name = status.shopname AND wishlist = "1" AND status.username = "'.$username.'" ORDER BY shop.name DESC;'
        
        );
        $shoplist = $query->result();
        return $shoplist;
    }

    //  feach menulist
    public function menulist($shopname){
        $query = $this->db->query(
            'select * 
            from menu 
            where shopname = "'.$shopname.'" ORDER BY id ASC;'
    
        );
        $menulist = $query->result();
        return $menulist;
    }

    //the shop owner
    public function ownercheck($username,$shop){
        $this->db->where('name', $shop);
        $this->db->where('username', $username);
        $result = $this->db->get('shop');
        if($result->num_rows() == 1){
            return true;
        } else {
            return false;
        }
    }

    //create menu
    public function createmenu($menuname,$shopname,$path,$price){
        $data = array(
            'menuname' => $menuname,
            'price' => $price,
            'path' => $path,
            'shopname' => $shopname
        );
        $this->db->insert('menu', $data);
    }

    //  feach all shop data
    public function ownerlist($username){
        $query = $this->db->query('select * from shop where username = "'.$username.'"order by name ASC');
        $shoplist = $query->result();
        return $shoplist;
    }

    //  feach dashboard data
    public function dashboard($name){
        $query = $this->db->query(
            'select name,
            (select count(*) from status where status = "1" and shopname = "'.$name.'") AS thumpsup_num,
            (select count(*) from status where status = "1" and shopname = "'.$name.'" and status_time = "2019") AS thumpsup_num_2019,
            (select count(*) from status where status = "1" and shopname = "'.$name.'" and status_time = "2020") AS thumpsup_num_2020,
            (select count(*) from status where status = "1" and shopname = "'.$name.'" and status_time = "2021") AS thumpsup_num_2021,
            (select count(*) from status where status = "1" and shopname = "'.$name.'" and status_time = "2022") AS thumpsup_num_2022,
            (select count(*) from status where wishlist = "1" and shopname = "'.$name.'") AS wishlist_num,
            (select count(*) from status where wishlist = "1" and shopname = "'.$name.'" and wishlist_time = "2019") AS wishlist_num_2019,
            (select count(*) from status where wishlist = "1" and shopname = "'.$name.'" and wishlist_time = "2020") AS wishlist_num_2020,
            (select count(*) from status where wishlist = "1" and shopname = "'.$name.'" and wishlist_time = "2021") AS wishlist_num_2021,
            (select count(*) from status where wishlist = "1" and shopname = "'.$name.'" and wishlist_time = "2022") AS wishlist_num_2022,
            (select count(*) from users) AS user_num,
            (select user_num - thumpsup_num) AS thumps_down_num,
            (select user_num - wishlist_num) AS general_num
            from shop 
            where name = "'.$name.'"'
        );
        $result = $query->result();
        return $result;
    }


     //  feach dashboard data
     public function dashboard_type($type,$year,$shop_list){
        $query = "";
        if ($type == "Wishlist") {
            if ($year == NULL) {
                foreach($shop_list as $shop) {
                    $shopname = urldecode($shop->name);
                    $query = $query."(select count(*) from status where wishlist = '1' and shopname = '$shop->name' ) AS '$shopname', ";
                }
            }else {
                foreach($shop_list as $shop) {
                    $shopname = urldecode($shop->name);
                    $query = $query."(select count(*) from status where wishlist = '1' and shopname = '$shop->name' and wishlist_time = '$year') AS '$shopname', ";
                }
            }
        }elseif($type == "Comment") {
            if ($year == NULL) {
                foreach($shop_list as $shop) {
                    $shopname = urldecode($shop->name);
                    $query = $query."(select count(*) from comment where shop = '$shop->name') AS '$shopname', ";
                }
            }else {
                foreach($shop_list as $shop) {
                    $shopname = urldecode($shop->name);
                    $query = $query."(select count(*) from comment where shop = '$shop->name' and time LIKE '%$year%' ) AS '$shopname', ";
                }
            }
        } elseif ($type == "Thumpsup_num") {
            if ($year == NULL) {
                foreach($shop_list as $shop) {
                    $shopname = urldecode($shop->name);
                    $query = $query."(select count(*) from status where status = '1' and shopname = '$shop->name' ) AS '$shopname', ";
                }
            }else {
                foreach($shop_list as $shop) {
                    $shopname = urldecode($shop->name);
                    $query = $query."(select count(*) from status where status = '1' and shopname = '$shop->name' and status_time = '$year') AS '$shopname', ";
                }
            }
        }
        $all_query = $this->db->query(
            'select type,'.$query.' username
            from shop
            where name ="maru"'
        );

        $result = $all_query->result();
        return $result;
    }
}