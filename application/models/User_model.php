<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 //put your code here
 class User_model extends CI_Model{

    // Log in
    public function login($username, $password){
        // Validate
        $this->db->where('username', $username);
        $this->db->where('password', $password);
        $result = $this->db->get('users');
        if($result->num_rows() == 1){
            return true;
        } else {
            return false;
        }
    }

    //check if it exist
    public function check_user($username){
        // Validate
        $this->db->where('username', $username);
        $result = $this->db->get('users');
        if($result->num_rows() == 1){
            return true;
        } else {
            return false;
        }
    }

    // Register
    public function register($username, $password,$phonenumber,$email){
        $user = array(
            'username' => $username,
            'password' => $password,
            'phonenumber' => $phonenumber,
            'email' => $email
        );
        $this->db->insert('users', $user);
    }

    // Set question
    public function setquestion($username,$question1,$answer1,$question2,$answer2,$nodification){
        //判断更改的是不是跟以前一样的
        $data = array(
            'question1' => $question1,
            'answer1' => $answer1,
            'question2' => $question2,
            'answer2' => $answer2,
            'nodification' => $nodification
        );
        $this->db->update('users', $data,array('username' => $username));
    }

    //Update datails
    public function UpdateUserDetail($username, $newusername, $email,$phonenumber){
        //判断更改的是不是跟以前一样的
        $data = array(
            'username' => $newusername,
            'email' => $email,
            'phonenumber' => $phonenumber,
        );
        $new = array(
            'username' => $newusername,
        );
        $this->db->update('comment', $new,array('username' => $username));
        $this->db->update('users', $data,array('username' => $username));
        $this->db->update('status', $new,array('username' => $username));
        $this->db->update('nodification', $new,array('username' => $username));
        $this->db->update('shop', $new,array('username' => $username));
    }

    //Update password
    public function UpdatePassword($username, $password){
        //判断更改的是不是跟以前一样的
        $data = array(
            'password' => $password,
        );
        $this->db->update('users', $data,array('username' => $username));
    }

    //Update membership 
    public function UpdateMembership($username, $level){
        //判断更改的是不是跟以前一样的
        $data = array(
            'membership' => $level,
        );
        $this->db->update('users', $data,array('username' => $username));
    }
    
    //get user data
    function fetch_data($username)
    {
        $sql = "SELECT * FROM users where username = '$username'";
        $query = $this->db->query($sql);
        $user = $query->row();
        return $user;
    }

    //  upload user file
    public function upload($filename, $path, $username){

        $data = array(
            'filename' => $filename,
            'path' => $path,
        );
        $this->db->update('users', $data,array('username' => $username));
    }

    public function insert_token($email, $token){
        $this->db->where('email', $email);
        $result = $this->db->get('email_verify');
        if($result->num_rows() == 1){
            $data = array(
                'email' => $email,
                'token' => $token,
            );
            $this->db->update('email_verify', $data, array('email' => $email));
        }else {
            $data = array(
                'email' => $email,
                'token' => $token,
            );
            $this->db->insert('email_verify', $data);
        }
    }

    public function verify_token($email, $token){
        $this->db->where('email', $email);
        $this->db->where('token', $token);
        $result = $this->db->get('email_verify');
        if($result->num_rows() == 1){
            $this->db->delete('email_verify',array('token' =>$token));
            return true;
        } else {
            return false;
        }
    }


    //  feach nodification = ture list 
    public function nodificationlist(){
        $query = $this->db->query(
            'select * 
            from users 
            where nodification = "1";'
    
        );
        $nodificationlist = $query->result();
        return $nodificationlist;
    }
}
?>
