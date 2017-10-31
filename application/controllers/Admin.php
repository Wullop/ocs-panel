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
class Admin extends CI_Controller {
	public function __construct() {
		parent::__construct();
		
		$this->load->model('user_model');
		$this->load->helper('url_helper');
		$this->load->library(array('session'));
	}
	private function _set_view($file, $init) {
		$data = new stdClass();
		$data -> msg = $this->user_model->seller_notify();
		$this->load->view('panel/base/page_header', $data);
		$this->load->view($file, $init);
        $this->load->view('panel/base/footer');
	}
	public function notify() {
	if ($_SESSION['is_admin'] === true) {
			
			$data = new stdClass();
			$data -> msg = $this->user_model->seller_notify();
			
			$this->_set_view('panel/admin/message', $data);
		}
		else {redirect(base_url('login/login'));}
	}
	public function admin($user=FALSE) {
		
		
		
		if ($_SESSION['username'] === $user && $_SESSION['is_admin'] === true) {
			
			$data = new stdClass();
			$data -> server = $this -> user_model -> get_hostname();
			$this->_set_view('panel/admin/servers', $data);
		}
		else {redirect(base_url('login/login'));}
	}
	private function __validate_post($data) {
		return !empty($data['ServerName']) && !empty($data['Location']) && !empty($data['HostName']) && !empty($data['RootPasswd']);
	}
	public function server( $cmd ) {
		$data = new stdClass();
		
		if ( $cmd == 'addserver' ) {
			if ( isset($_SESSION['username']) && $_SESSION['is_admin'] === true ) {
				
				if ($_POST) {
					if ( $this->__validate_post($_POST) ) {
						if ( $this->user_model->create_hostname($_POST) ) {
							$data->message = '<div class="alert alert-success">Server Berhasil ditambahkan.</div>';
							$data->server = $this -> user_model -> get_hostname();
							$this->_set_view('panel/admin/servers', $data);
							return;
						}else{ $data->message='<div class="alert alert-danger">Terjadi kesalahan saart penambahan server</div>';}
					} else { $data->message='<div class="alert alert-warning">Form harus diisi lengkap</div>'; }
					
				}
				$this->_set_view('panel/admin/addserver', $data);
			} else { redirect(base_url('login/login')); }
		}
		else if ($cmd == 'server') {
			if (isset($_SESSION['username']) && $_SESSION['logged_in'] === true) {
				$data->server = $this->user_model->get_hostname();
				$this->_set_view('panel/admin/servers', $data);
			} else { redirect(base_url('login/login')); }
		}
		else { show_404(); }
	}
	public function edit($id) {
	  $data = new stdClass();
		if ( isset($_SESSION['username']) && $_SESSION['is_admin'] === true ) {
			$data -> server = $this->user_model->get_hostname($id);
			
			if($_POST) {
				if ($this->__validate_post($_POST)) {
					if ($this -> user_model->update_server($_POST, $id)) {
						
						$data -> message = '<div class="alert alert-success">Success edit server</div>';
						$data -> server = $this->user_model->get_hostname($id);
					}
				} else {
					
					$data->message = '<div class="alert alert-danger">Form tidak boleh ada yg dikosongkan</div>';
					$data -> server = $this->user_model->get_hostname($id);
					}
			}
			$this->_set_view('panel/admin/edit', $data);
		}
		else { redirect(base_url('login/login')); }
	}
	public function konfirm_msg($id=false) {
		if ($_SESSION['is_admin'] === true) {
			if ($this->user_model->update_message($id,'konfirm')) {
				
				$data = new stdClass();
				$data -> msg = $this->user_model->seller_notify();
			
				$this->_set_view('panel/admin/message', $data);
			}
			else { exit; }
		}
		else { redirect(base_url('login/login')); }
	}
	public function del_msg($id=false) {
		if ($_SESSION['is_admin'] === true) {
			if ($this->user_model->update_message($id, 'del')) {
				$data = new stdClass();
				
				$data -> msg = $this->user_model->seller_notify();
				$this->_set_view('panel/admin/message', $data);
			}
			else { exit; }
		}
		else { redirect(base_url('login/login')); }
	}
	public function lock($id, $cmd) {
		$data = new stdClass();
		if ( isset($_SESSION['username']) && $_SESSION['is_admin'] === true ) {
			if ($cmd === 'lock') {
				if ($this -> user_model->update_server(array('Status' => false), $id)) {
					$data -> message = '<div class="alert alert-danger">Server berhasil di lock</div>';
					$this->admin($_SESSION['username']);
				}
			}
			elseif ($cmd === 'unlock') {
				if ($this -> user_model->update_server(array('Status' => true), $id)) {
					$data -> message = '<div class="alert alert-success">Success server berhasil di unlock </div>';
					$this->admin($_SESSION['username']);
				}
			}
			elseif ($cmd === 'del') {
				if ($this -> user_model->delete_server($id)) {
					$this->admin($_SESSION['username']);
				}
			}
			else {show_404();} 
		}
	  else { redirect(base_url('login/login')); }
	}
	public function cekuser($id=FALSE) {
		if ( isset($_SESSION['username']) && $_SESSION['is_admin'] === true ) {
			$data = new StdClass();
			$data->server=$this->user_model->get_hostname($id);
			$data->user=$this->user_model->get_user_ssh($id);
			
			$this->_set_view('panel/admin/accounts', $data);
		}
		else { redirect(base_url('login/login')); }
	}
	public function delet_account($id) {
		$this->load->library('sshcepat');
		if (empty($this->user_model->id_ssh($id)->hostname)) { Show_404(); }
		$data = array (
			'hostname' => $this->user_model->id_ssh($id)->hostname,
			'rootpass' => $this->user_model->get_hostname($this->user_model->id_ssh($id)->serverid)->RootPasswd,
			'id' => $this->user_model->get_hostname($this->user_model->id_ssh($id)->serverid)->Id,
			'username' => $this->user_model->id_ssh($id)->username
		);
		if ( isset($_SESSION['username']) && $_SESSION['is_admin'] === true ) {
			if ($this->user_model->delete_user_ssh($id)) {
					if ($this->sshcepat->deletAccount($data)) {
						redirect(base_url('admin/cekuser/'.$data['id']));
						
					} else {echo 'Root passwd wrong!';}
			}
		}
		else { redirect(base_url('login/login')); }
		
	}
	public function asset() {
		$this->load->helper('form');
		$this->load->library('form_validation');
		if ( isset($_SESSION['username']) && $_SESSION['is_admin'] === true ) {
			$this->form_validation->set_rules('pemilik','Pemilik', 'trim|required|min_length[3]');
			$this->form_validation->set_rules('nohp','No. telp', 'trim|required|min_length[3]');
			$this->form_validation->set_rules('provider', 'Provider', 'trim|required|min_length[1]');
			if ($this->form_validation->run() === false) {
				$data = new stdClass();
				$data->asset=$this->user_model->view_asset();
				$this->_set_view('panel/admin/asset', $data);
			} else {
				$post = array (
						'pemilik' => $this->input->post('pemilik'),
						'nohp' => $this->input->post('nohp'),
						'provider' => $this->input->post('provider')
				);
				if (!$this->user_model->get_hp($this->input->post('nohp'))) {
					if ($this->user_model->asset($post)) {
						$data = new stdClass();
						$data->asset=$this->user_model->view_asset();
						$data->message='<div class="alert alert-success">Data berhasil ditambahkan</div>';
						$this->_set_view('panel/admin/asset', $data);
						
					} else {echo 'Database error';} 
				}
				else {
					redirect(base_url('admin/asset'));
				}
			}
		}
		else {redirect(base_url('login/login'));}
	}
	public function asset_req() {
		$this->load->helper('form');
		$this->load->library('form_validation');
		if ( isset($_SESSION['username']) && $_SESSION['is_admin'] === true ) {
			$this->form_validation->set_rules('rekening','no rekening', 'trim|required|min_length[3]');
			$this->form_validation->set_rules('bank','bank', 'trim|required|min_length[3]');
			$this->form_validation->set_rules('pemilik', 'Pemilik', 'trim|required|min_length[3]');
			if ($this->form_validation->run() === false) {
				$data = new stdClass();
				$data->asset=$this->user_model->view_asset();
				$this->_set_view('panel/admin/asset_req', $data);
			} else {
				$post = array (
						'rekening' => $this->input->post('rekening'),
						'bank' => $this->input->post('bank'),
						'pemilik' => $this->input->post('pemilik')
				);
				if (!$this->user_model->get_req($this->input->post('rekening'))) {
					if ($this->user_model->asset($post)) {
						$data = new stdClass();
						$data->asset=$this->user_model->view_asset();
						$data->message='<div class="alert alert-success">Data berhasil ditambahkan</div>';
						$this->_set_view('panel/admin/asset_req', $data);
						
					} else {echo 'Database error';} 
				}
				else {
					redirect(base_url('admin/asset_req'));
				}
			}
		}
		else {redirect(base_url('login/login'));}
	}
	
	public function del_hp($id) {
		if ( isset($_SESSION['username']) && $_SESSION['is_admin'] === true ) {
			if ($this->user_model->del_req($id)) {
				
				redirect(base_url('admin/asset'));
			}
		}
		else { redirect(base_url('login/login')); }
	}
	public function del_req($id) {
		if ( isset($_SESSION['username']) && $_SESSION['is_admin'] === true ) {
			if ($this->user_model->del_req($id)) {
				
				redirect(base_url('admin/asset_req'));
			}
		}
		else { redirect(base_url('login/login')); }
	}
}
