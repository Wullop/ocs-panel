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
class User_model extends CI_Model {
	public function __construct() {
		
		parent::__construct();
		$this->load->database();
	}
	public function create_user($username, $email, $password) {
		
		$data = array(
			'username'   => $username,
			'email'      => $email,
			'password'   => $this->hash_password($password),
			'created_at' => date('Y-m-j H:i:s'),
		);
		
		return $this->db->insert('users', $data);
		
	}
	public function create_hostname($array) {
		return $this->db->insert('server', $array);
	}
	public function resolve_user_login($username, $password) {
		
		$this->db->select('password');
		$this->db->from('users');
		$this->db->where('username', $username);
		$hash = $this->db->get()->row('password');
		
		return $this->verify_password_hash($password, $hash);
	}
	
	public function get_user_id_from_username($username) {
		
		$this->db->select('id');
		$this->db->from('users');
		$this->db->where('username', $username);

		return $this->db->get()->row('id');
	}
	public function get_user_id_from_ssh($user, $hostid) {
		
		$this->db->select('id');
		$this->db->from('sshuser');
		$this->db->where('username', $user);
		$this->db->where('serverid', $hostid);
		return $this->db->get()->row('id');
	}
	public function get_user_ssh($hostid) {
		$query = $this->db->get_where('sshuser', array('serverid' => $hostid));
		$arr = array();
		foreach ($query->result_array() as $row) {
			$tmp = array(
				'id' => $row['id'],
				'username' => $row['username'],
				'hostname' => $row['hostname'],
				'created_by' => $row['created_by'],
				'created_at' => $row['created_at'],
				'expired_at' => date("Y-m-j H:i:s", strtotime('+'.$row['expired_at'].' days', time()))
			);
			array_push($arr, $tmp);
		}
		return $arr;
	}
	public function seller_notify() {
		$arr = array();
		foreach ($this->db->get_where('deposit', array('is_confirmed' => false)) -> result_array() as $row) {
			
			$tmp = array (
						'id' => $row['id'],
						'userid' => $row['userid'],
						'username' => $this->get_user($row['userid'])->username,
						'pesan' => $row['pesan'],
						'created_at' => $row['created_at']
						);
			array_push($arr, $tmp);
		}
		return $arr; 
	}
	private function _get_seller_msg($id) {
		
		$this->db->from('deposit');
		$this->db->where('id', $id);
		
		return $this->db->get()->row();
	}
	public function id_ssh($id) {
		
		$this->db->from('sshuser');
		$this->db->where('id', $id);
		
		return $this->db->get()->row();
	}
	public function update_message($id,$cmd) {
		$this->db->where('id', $id);	
		if ($cmd == 'konfirm') {
			if ($this->db->update('deposit', array('is_confirmed' => true))) {
						$saldo = $this -> _get_seller_msg($id) -> jumlah;
						$username= $this->get_user($this -> _get_seller_msg($id) -> userid)->username;
						$total = $this->get_user($this -> _get_seller_msg($id) -> userid)->saldo + $saldo;
						return $this->update_saldo($username, $total);
				}
		}
		elseif ($cmd =='del') { return $this->db->delete('deposit', array('id' => $id)); }
		else {show_404();}
	}
	public function get_user($user_id) {
		
		$this->db->from('users');
		$this->db->where('id', $user_id);
		return $this->db->get()->row();
	}
	private function hash_password($password) {
		return password_hash($password, PASSWORD_BCRYPT);
	}
	private function verify_password_hash($password, $hash) {
		return password_verify($password, $hash);
	}
	public function get_hostname($id=FALSE) {
		if ($id === FALSE) {return $this->db->get('server')->result_array(); }
		
		$this->db->from('server');
		$this->db->where('Id', $id);
		return $this->db->get()->row();
	}
	public function update_server($post, $id) {
		$this->db->where('Id', $id);
		return $this->db->update('server', $post);
	}
	public function delete_server($id) {
		$this->db->where('Id', $id);
		return $this->db->delete('server', array('Id' => $id));
	}
	public function update_login($post) {
		$data = array('password' => $this->hash_password($post['password']));
		$this->db->where('username', $post['username']);
		return $this->db->update('users', $data);
	}
	public function update_saldo($user, $saldo) {
		$this->db->where('username', $user);
		return $this->db->update('users', array('username' => $user, 'saldo'=>$saldo));
	}
	public function user_ssh($user, $host, $create, $expired, $id, $price) {
		
		$data = array(
			'username'   => $user,
			'hostname'      => $host,
			'created_by'   => $create,
			'created_at' => date('Y-m-j H:i:s'),
			'expired_at' => $expired,
			'serverid' => $id,
			'price' => $price
		);
		
		return $this->db->insert('sshuser', $data);
		
	}
	public function deposit($userid, $pesan, $jumlah) {
		
		$data = array(
			'userid'   => $userid,
			'pesan'      => $pesan,
			'jumlah' => $jumlah,
			'created_at' => date('Y-m-j H:i:s')
		);
		
		return $this->db->insert('deposit', $data);
		
	}
	public function delete_user_ssh($id) {
		$this->db->where('id', $id);
		return $this->db->delete('sshuser', array('id' => $id));
	}
	public function asset($data) {
		return $this->db->insert('asset', $data);
	}
	public function view_asset() {
		return $this->db->get('asset')->result_array();
	}
	public function get_hp($hp) {
		
		$this->db->select('id');
		$this->db->from('asset');
		$this->db->where('nohp', $hp);

		return $this->db->get()->row('id');
	}
	public function get_req($req) {
		
		$this->db->select('id');
		$this->db->from('asset');
		$this->db->where('rekening', $req);

		return $this->db->get()->row('id');
	}
	public function del_req($id) {
		$this->db->where('id', $id);
		return $this->db->delete('asset', array('id' => $id));
	}
	public function get_account_list($user) {
		return $this->db->get_where('sshuser', array('created_by' => $user))->result_array();
	}
	public function get_country() {
		$query = $this->db->get('country');
		return $query->result_array();
	}
}
