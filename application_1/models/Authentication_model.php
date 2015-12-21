<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Authentication_model extends CI_Model
{
    public function login($username, $password)
    {
        $user_clear = (stripslashes(strip_tags(htmlspecialchars($username, ENT_QUOTES))));
        $password_clear = (stripslashes(strip_tags(htmlspecialchars($password, ENT_QUOTES))));
        $this->db->where('users_username', $user_clear);
        $this->db->where('users_password', md5($password_clear));

        return $this->db->get('users')->row_array();
    }
}

/* End of file authentication_model.php */
/* Location: ./application/models/authentication_model.php */
