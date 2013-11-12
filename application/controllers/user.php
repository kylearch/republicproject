<?php

class User extends CI_Controller
{

	//Decode Cookie into array
	private function decode_cookie($cookie)
	{
		//Load Dependencies
		$this->load->helper('cookie');
		$this->load->library('encrypt');

		$cookie_value = json_decode($this->encrypt->decode(get_cookie($cookie)), true);
		return $cookie_value;
	}

	//Authentication function
	private function authenticate()
	{	
		//Retrieve and ecode "user" cookie
		$user = $this->decode_cookie('user');

		//Check "user" cookie value
		if (empty($user))
		{
			//Redirect if "user" is empty->(User Login)
			$this->load->helper('url');
			redirect('/user/login');
		}
		else
		{
			return $user;
		}
	}

	//Index
	public function index()
	{
		//Authenticate user and send to profile page
		if ($this->authenticate())
		{
			$this->load->helper('url');
			redirect('user/profile');
		}
	}

	//Login
	public function login()
	{
		//Load User Login Dependencies
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model("user_model");

		//Set Page Variables
		$data['title'] = 'Login';

		//User Login Form Validation Rules
		$this->form_validation->set_error_delimiters('<p class="error">', '</p>');
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[4]');

		//Run Validation
		if ($this->form_validation->run() === FALSE)
		{
			//Validation Failed
			//Load User Login View
			$this->load->view('header', $data);
			$this->load->view('user/login', $data);
			$this->load->view('footer', $data);
		}
		else
		{
			$username = $this->input->post('username');
			$password = $this->input->post('password');

			if ($this->user_model->check_credentials($username, $password) === FALSE) {
				$data['error'] = 'Invalid login';

				$this->load->view('header', $data);
				$this->load->view('user/login', $data);
				$this->load->view('footer', $data);
			} else {
				$this->load->helper('url');
				redirect('/user/profile');
			}
		}

	}

	//Logout
	public function logout()
	{
		//Load Dependencies
		$this->load->helper(array('cookie', 'url'));
		delete_cookie('user');
		redirect('/user/login');
	}

	//View Profile
	public function profile()
	{
		if ($this->authenticate())
		{
			//Load User Profile Dependencies
			$this->load->helper('form');
			$this->load->library('form_validation');
			$this->load->model('user_model');

			//Decode user cookie
			$user = $this->decode_cookie('user');

			//Set Page Variables
			$data['title'] = 'User Profile';
			$data['user'] = $user; //User data {uid: xxxxxx, username: xxxxxxx}

			//*** Begin Form Section
			//User Login Form Validation Rules
			$this->form_validation->set_error_delimiters('<p class="error">', '</p>');
			$this->form_validation->set_rules('email', 'Email', 'valid_email');
			$this->form_validation->set_rules('password', 'Password', 'matches[pwdconf]');
			if ($this->input->post('password'))
			{
				$this->form_validation->set_rules('pwdconf', 'Password Confirmation', 'required');
			}

			//Image
			$config = array(
			    'upload_path'   => './public/img/user/',
			    'allowed_types' => 'gif|jpg|png',
			    'file_name' => $this->input->post('username')
			);
			$this->load->library('upload', $config);
			if ($this->upload->do_upload('image'))
			{
				$image_data = $this->upload->data();
			}
			else
			{
				$this->upload->display_errors();
			}

			//Run Validation
			if ($this->form_validation->run() === TRUE)
			{
				//Input Fields
				$uid = $this->input->post('uid');
				$post["email"] = $this->input->post('email');
				$post["fname"] = $this->input->post('first_name');
				$post["lname"] = $this->input->post('last_name');
				$post["password"] = $this->input->post('password');
				$post["image"] = (!empty($image_data)) ? $image_data["file_name"] : null ;

				//Update database
				$this->user_model->save($uid, $post);
			}
			//*** End Form Section

			//Retrieve Existing Profile Data
			$data['profile'] = $this->user_model->load($user['uid']);

			//Load User Profile View
			$this->load->view('header', $data);
			$this->load->view('user/profile', $data);
			$this->load->view('footer', $data);	
		}
	}

}