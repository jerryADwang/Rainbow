<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 //put your code here 
 class File_model extends CI_Model{

    function fetch_data($query,$shop)
    {
        if($query == '')
        {
            return null;
        }else{
            $query = $this->db->query(
            'select comment.username, comment.comment, comment.time, comment.location, users.path, users.filename
            from comment, users 
            where comment.username = users.username AND shop = "'.$shop.'" AND comment.comment LIKE "%'.$query.'%"
            ORDER BY comment.time DESC');
            return $query;
        }
    }

    function fetch_comment($shop)
    {
        $query = $this->db->query(
        'select comment.username, comment.comment, comment.time, comment.location, users.path, users.filename
        from comment, users 
        where comment.username = users.username AND shop = "'.$shop.'"
        ORDER BY comment.time DESC');
        return $query;
    }

    function fetch_shop($query)
    {
        if($query == '')
        {
            return null;
        }else{
            $query = $this->db->query(
            'select *
            from shop
            where name LIKE "%'.$query.'%" or type LIKE "%'.$query.'%"
            ORDER BY name DESC');
            return $query;
        }
    }


    function fetch_nodification($username)
    {
        $query = $this->db->query(
        'select *
        from nodification
        where username = "'.$username.'"
        ORDER BY time DESC');
        return $query;
    }
}