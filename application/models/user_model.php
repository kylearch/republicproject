<?php

class User_model extends CI_Model
{

	public function __construct()
	{
		$this->load->database();
	}

	public function check_credentials($user, $pass)
	{
		$query = $this->db->query("SELECT `uid`, `username` FROM `users` WHERE `username`='{$user}' AND `password`=AES_ENCRYPT('{$pass}', 'exercise')");
		if ($query->num_rows() > 0) {
			$result = $query->row_array();
			$this->load->helper('cookie');
			$this->load->library('encrypt');
			
			$cookie = array(
				'name' => 'user',
				'value' => $this->encrypt->encode(json_encode($result)),
				'expire' => 60 * 60 * 24 * 7
			);
			$this->input->set_cookie($cookie);

			return $result;
		} else {
			return FALSE;
		}
	}

	public function save($uid, $data)
	{
		$pwd_str = (!empty($data['password'])) ? "`password`=AES_ENCRYPT('{$data['password']}', 'exercise'), " : "" ;
		$query = $this->db->query("UPDATE `users` SET " . $pwd_str . "`email`='{$data['email']}', `first_name`='{$data['fname']}', `last_name`='{$data['lname']}', `image`='{$data['image']}' WHERE `uid`='$uid'");
		return $query;
	}

	public function load($uid)
	{
		$query = $this->db->query("SELECT `uid`, `username`, `email`, `first_name`, `last_name` FROM `users` WHERE `uid`='$uid'");
		$result = $query->row_array();
		return $result;
	}

}