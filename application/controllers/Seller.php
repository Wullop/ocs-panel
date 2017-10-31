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
class Seller extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('user_model');
		$this->load->helper('url_helper');
		$this->load->library('sshcepat');
		$this->load->library(array('session'));
	}
	private function _set_view($file, $init) {
		
		$this->load->view('panel/base/page_header');
		$this->load->view($file, $init);
        $this->load->view('panel/base/footer');
	}
	public function seller($user=FALSE) {
		
		//if (empty($user)) {show_404();}
		
		if (isset($_SESSION['username']) && $_SESSION['logged_in'] === true) {
			
			$data = new stdClass();
			$data->user = $this->user_model->get_user($_SESSION['user_id']);
			$data->server=$this->user_model->get_hostname();
			$this->_set_view('panel/seller/servers', $data);
		}
		else {redirect(base_url('login/login'));}
	}
	public function addsaldo_hp() {
		$this->load->helper('form');
		$this->load->library('form_validation');
		if (isset($_SESSION['username']) && $_SESSION['logged_in'] === true) {
			$this->form_validation->set_rules('sender', 'Pengirim', 'trim|required|min_length[4]');
		    $this->form_validation->set_rules('hp', 'No Telp', 'trim|required|min_length[4]');
			$user = $this->user_model->get_user($_SESSION['user_id']);
			if ($this->form_validation->run() === false) {
				$data = new stdClass();
				$data->user = $this->user_model->get_user($_SESSION['user_id']);
				$this->_set_view('panel/seller/addsaldo_hp', $data);
			} else {
				$mkios = $this->input->post('mkios');
				$sender = $this->input->post('sender');
				$hp = $this->input->post('hp');
				$jumlah= $this->input->post('jumlah');
				if (empty($mkios)) {
					$pesan = $user->username. ' Meminta saldo via no hp: ' .$sender. ' dikirim ke nomor : '. $hp .' sebesar : '. $jumlah;
					} else {
						$pesan = $user->username. ' Meminta saldo via mkios Dengan no seri ' .$mkios. ' dikirim ke nomor '.$hp.' sebesar : '. $jumlah;
					}
				$userid=$_SESSION['user_id'];
				if ($this->user_model->deposit($userid, $pesan, $jumlah)) {
					
					
					 $data = new stdClass();
					 $data -> message = 'Terimakasih telah membeli ssh di server kami . silkan tunggu beberapa saat saldo anda akan bertambah otomatis, konfirmasi ini membutuhkan waktu paling lama 1x24 jam.';
					 $data->user = $this->user_model->get_user($_SESSION['user_id']);
					 $this->_set_view('panel/seller/addsaldo_hp', $data);
				}
				else {echo "database error";}
			}
		}
		else {redirect(base_url('login/login'));}
		
	}
	public function addsaldo_req() {
		$this->load->helper('form');
		$this->load->library('form_validation');
		if (isset($_SESSION['username']) && $_SESSION['logged_in'] === true) {
			$this->form_validation->set_rules('sender', 'Rekening', 'trim|required|min_length[4]');
		    $this->form_validation->set_rules('username', 'username', 'trim|required|min_length[4]');
		    $this->form_validation->set_rules('rekening', 'tujuan', 'trim|required|min_length[4]');
			$user = $this->user_model->get_user($_SESSION['user_id']);
			if ($this->form_validation->run() === false) {
				$data = new stdClass();
				$data->user = $this->user_model->get_user($_SESSION['user_id']);
				$this->_set_view('panel/seller/addsaldo_req', $data);
			} else {
				$sender = $this->input->post('sender');
				$username = $this->input->post('username');
				$rekening= $this->input->post('rekening');
				$jumlah= $this->input->post('jumlah');
				$userid=$_SESSION['user_id'];
				
				$pesan = $user->username. ' Meminta saldo sebesar '. $jumlah. ' via reqkening '. $sender. ' Dengan atas nama '.$username.' ke no req '. $rekening;
				if ($this->user_model->deposit($userid, $pesan, $jumlah)) { 
					 $data = new stdClass();
					 $data -> message = 'Terimakasih telah membeli ssh di server kami . silkan tunggu beberapa saat saldo anda akan bertambah otomatis, konfirmasi ini membutuhkan waktu paling lama 1x24 jam.';
					 $data->user = $this->user_model->get_user($_SESSION['user_id']);
					 $this->_set_view('panel/seller/addsaldo_req', $data); 
				}
				else {echo "database error";}
			}
		}
		else {redirect(base_url('login/login'));}
		
	}
	public function buy($id=FALSE) {
	    $this->load->helper('form');
		$this->load->library('form_validation');
		
		if (isset($_SESSION['username']) && $_SESSION['logged_in'] === true) {
		    if ($this->user_model->get_hostname($id)->Status) {
		        if ($this->user_model->get_user($_SESSION['user_id'])->saldo < $this->user_model->get_hostname($id)->Price)
		        {
					 
					 $data = new stdClass();
					 $data->message='<p class="text-danger">Saldo anda kurang</p>';
					 $data->user = $this->user_model->get_user($_SESSION['user_id']);
					 $data->server=$this->user_model->get_hostname();
					 $this->_set_view('panel/seller/servers', $data);
				}
				  else {
				    $this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[5]');
				    $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[5]');
				    if ($this->form_validation->run() === false) {
				        $data = new StdClass();
				        
					    $data->user = $this->user_model->get_user($_SESSION['user_id']);
					    $data->server=$this->user_model->get_hostname($id);
					    
					    $this->load->view('panel/base/page_header');
					    $this->load->view('panel/seller/create', $data);
					    $this->load->view('panel/base/footer');
					    
				    } else {
						$server=$this->user_model->get_hostname($id);
						$by = $this->user_model->get_user($_SESSION['user_id']);
						$dat = array(
							'message' => '<div class="alert alert-success">Akun sukses dibuat</div>',
						    'hostname'=>$server->HostName,
						    'rootpass'=>$server->RootPasswd,
						    'openssh'=>$server->OpenSSH,
							'dropbear'=>$server->Dropbear,
							'location'=>$server->Location,
							'price' => $server->Price,
						    'username'=>$this->input->post('username'),
						    'password'=>$this->input->post('password'),
						    'expired'=>$server->Expired
						    );
						    $ssh = $this ->sshcepat->addAccount($dat);
						    
						    
						    if($ssh) {
								 if ($this->user_model->user_ssh(
									$dat['username'],
									$dat['hostname'],
									$by->username,
									$dat['expired'], 
									$server->Id, 
									$server->Price)) 
								{
									$saldo = $by->saldo - $server->Price;
									if ($this->user_model->update_saldo($by->username, $saldo)) {
										$data = new stdClass();
										$data->user = $dat;
										$this->load->view('panel/base/page_header');
										$this->load->view('panel/seller/account', $data);
										$this->load->view('panel/base/footer');
									}
								}
							} else { echo "root pass salah";}
							
						}
						
				    } // end form_validation
			   } else {
			       
			        $data = new stdClass();
			        $data->user = $this->user_model->get_user($_SESSION['user_id']);
			        $data->server=$this->user_model->get_hostname();
			        $this->_set_view('panel/seller/servers', $data); 
			       
			   } // server locked;
		    
		}
		
		else {redirect(base_url('login/login'));}
		
	}
	public function cek_account($user=false) {
		if (isset($_SESSION['username']) && $_SESSION['logged_in'] === true) {
			$data = new StdClass();
			$data->account= $this->user_model->get_account_list($user);
			$this->_set_view('panel/seller/account_list', $data);
		}
		else {redirect(base_url('login/login'));}
	}
	public function delet_account($id) {
		$this->load->library('sshcepat');
		if (empty($this->user_model->id_ssh($id)->hostname)) { Show_404(); }
		$create_by = $this->user_model->id_ssh($id)->created_by;
		$data = array (
			'hostname' => $this->user_model->id_ssh($id)->hostname,
			'rootpass' => $this->user_model->get_hostname($this->user_model->id_ssh($id)->serverid)->RootPasswd,
			'username' => $this->user_model->id_ssh($id)->username
		);
		if ( isset($_SESSION['username']) && $_SESSION['logged_in'] === true ) {
			if ($_SESSION['username'] === $create_by ) {
				 if ($this->user_model->delete_user_ssh($id)) {
					if ($this->sshcepat->deletAccount($data)) {
						redirect(base_url('panel/reseller/cek_account/'.$_SESSION['username']));
						
					} else {echo 'Root passwd wrong!';}
			} 
			} else { show_404(); } 
			
		}
		else { redirect(base_url('login/login')); }
		
	}
	
}
