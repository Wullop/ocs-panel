<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * Copyright (c) 2006-2017 Adipati Arya <jawircodes@gmail.com>,
 * 2006-2017 http://sshcepat.com
 *
 * Permission to use, copy, modify, and distribute this software for any
 * purpose with or without fee is hereby granted, provided that the above
 * copyright notice and this permission notice appear in all copies.
 *
 * THE SOFTWARE IS PROVIDED "AS IS" AND THE AUTHOR DISCLAIMS ALL WARRANTIES
 * WITH REGARD TO THIS SOFTWARE INCLUDING ALL IMPLIED WARRANTIES OF
 * MERCHANTABILITY AND FITNESS. IN NO EVENT SHALL THE AUTHOR BE LIABLE FOR
 * ANY SPECIAL, DIRECT, INDIRECT, OR CONSEQUENTIAL DAMAGES OR ANY DAMAGES
 * WHATSOEVER RESULTING FROM LOSS OF USE, DATA OR PROFITS, WHETHER IN AN
 * ACTION OF CONTRACT, NEGLIGENCE OR OTHER TORTIOUS ACTION, ARISING OUT OF
 * OR IN CONNECTION WITH THE USE OR PERFORMANCE OF THIS SOFTWARE.
 */
class Login extends Ci_Controller {
	public function __construct() {
		parent::__construct();
		require(APPPATH . '/third_party/password_compat-master/lib/password.php');
		
		$this->load->helper('url_helper');
		$this->load->model('user_model');
		$this->load->library(array('session'));
	}
	private function _set_view($file, $init) {
		$this->load->view('panel/base/page_header');
		$this->load->view($file, $init);
        $this->load->view('panel/base/footer');
	}
	public function login() {
		
		$data = new stdClass();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('username', 'Username', 'required|alpha_numeric');
		$this->form_validation->set_rules('password', 'Password', 'required');
		
		if ($this->form_validation->run() == false) {
				$this->load->view('panel/base/header');
				$this->load->view('panel/login', $data);
				$this->load->view('panel/base/footer');
		}
		else {
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			if ($this->user_model->resolve_user_login($username, $password)) {
				$user_id = $this->user_model->get_user_id_from_username($username);
				$user    = $this->user_model->get_user($user_id);
				switch ($user->is_admin) {
					case TRUE:
						$_SESSION['user_id']      = (int)$user->id;
						$_SESSION['username']     = (string)$user->username;
						$_SESSION['logged_in']    = (bool)true;
						$_SESSION['is_confirmed'] = (bool)$user->is_confirmed;
						$_SESSION['is_admin']     = (bool)$user->is_admin;
						redirect(base_url('panel/admin/'.str_replace(' ','-',$username)));
					break;
					case FALSE:
						$_SESSION['user_id']      = (int)$user->id;
						$_SESSION['username']     = (string)$user->username;
						$_SESSION['logged_in']    = (bool)true;
						$_SESSION['is_confirmed'] = (bool)$user->is_confirmed;
						$_SESSION['is_admin']     = (bool)FALSE;
						redirect(base_url('panel/seller/'.str_replace(' ','-',$username)));
					break;
					default: show_404();
				}
			}
			else {
				$data->error = 'Wrong username or password.';
				$this->load->view('panel/base/header');
				$this->load->view('panel/login', $data);
				$this->load->view('panel/base/footer');
			}
		}
		
	}
	public function logout() {
		
		$data = new stdClass();
		
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
			foreach ($_SESSION as $key => $value) {
				unset($_SESSION[$key]);
			}
			redirect(base_url('login/login'));
			
		} else {
			//redirect(base_url('panel'));
			
		}
		
	}
	public function register() {
		
		// create the data object
		$data = new stdClass();
		
		// load form helper and validation library
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		// set validation rules
		$this->form_validation->set_rules('username', 'Username', 'trim|required|alpha_numeric|min_length[4]|is_unique[users.username]', array('is_unique' => 'This username already exists. Please choose another one.'));
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[users.email]');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');
		$this->form_validation->set_rules('password_confirm', 'Confirm Password', 'trim|required|min_length[6]|matches[password]');
		
		if ($this->form_validation->run() === false) {
			
			// validation not ok, send validation errors to the view
			$this->load->view('panel/base/header');
			$this->load->view('panel/register', $data);
			$this->load->view('panel/base/footer');
			
		} else {
			
			// set variables from the form
			$username = $this->input->post('username');
			$email    = $this->input->post('email');
			$password = $this->input->post('password');
			
			if ($this->user_model->create_user($username, $email, $password)) {
				
				$user_id = $this->user_model->get_user_id_from_username($username);
				$user    = $this->user_model->get_user($user_id);
				$data = new StdClass();
				
				// set session user datas
				$_SESSION['user_id']      = (int)$user->id;
				$_SESSION['username']     = (string)$user->username;
				$_SESSION['active'] = (bool) $user->active;
				$_SESSION['logged_in']    = (bool)true;
				$_SESSION['is_confirmed'] = (bool)$user->is_confirmed;
				$_SESSION['is_admin']     = (bool)$user->is_admin;
				$data -> success = '<div class="alert alert-success">Registrasi Akun berhasil</div>';
				$this->load->view('panel/base/page_header');
				$this->load->view('panel/setting', $data);
				$this->load->view('panel/base/footer');
				
				
			} else {
				
				// user creation failed, this should never happen
				$data->error = 'There was a problem creating your new account. Please try again.';
				
				// send error to the view
				$this->load->view('panel/base/header');
				$this->load->view('panel/register', $data);
				$this->load->view('panel/base/footer');
				
			}
			
		}
		
	}
	
	private function __validate_login($data) {
		return !empty($data['oldpass']) && !empty($data['password']) && !empty($data['passconf']);
	}
	public function setting() {
		$data = new stdClass();
		if (isset($_SESSION['username']) && $_SESSION['logged_in'] === true)
		{
			if ($_POST) {
				if ($this->__validate_login($_POST)) {
					if (!$this->user_model->resolve_user_login($_SESSION['username'], $_POST['oldpass'])) {
						$data->message='<div class="alert alert-danger">Password lama yang anda masukan salah</div>';
					}
					elseif($_POST['password'] !== $_POST['passconf']) {
						$data->message='<div class="alert alert-warning">confirm passwd salah </div>';
					}
					else {
						if ($this->user_model->update_login($_POST)) {
							$data->message='<div class="alert alert-success">Password changed</div>';
						}
					}
				}
					else {$data->message ='<div class="alert alert-danger">Form harus diisi lengkap</div>';}
			}
				$this->_set_view('panel/setting', $data);
		}
		else { redirect(base_url('login/login')); }
	}
	
}
