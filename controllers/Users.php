<?php 
class Users extends CI_Controller
{	
	public function index()
	{
		$users = 'wp_users';

		if(@$_GET['uid']) {$this->db->where('ID', $_GET['uid']);}
		if(@$_GET['un']) {$this->db->where('user_login', $_GET['un']);}
		if(@$_GET['em']) {$this->db->where('user_email', $_GET['em']);}

		$data = $this->db->get($users)->result_array();

		header('Content-Type: application/json');
		echo json_encode($data, JSON_PRETTY_PRINT);
	}
}