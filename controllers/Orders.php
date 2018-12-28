<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Orders extends CI_Controller {
	public function API()
	{
		// purchse items
		// http://localhost/orders/API?tab=wp_woocommerce_order_items&oid=9580

		// order detail
		// http://localhost/orders/API?tab=wp_postmeta&pid=9580

		$off = 0;
		$lim = 500;

		if (!empty($_GET['off'])) {	$off = $_GET['off'];}
		if (!empty($_GET['lim'])) {	$lim = $_GET['lim'];}



		$logged = $this->session->userdata('logged_in');
		if ($logged) {
		
		$table = @$_GET['tab'];
		$tabArr = array("wp_posts", "wp_postmeta", "wp_woocommerce_order_items, wp_users");

		if (in_array($table, $tabArr)) {
			if (empty($table)) {$table = 'wp_posts';}
			if ($table == 'wp_posts') {$this->getVar('post_type','shop_order');}

			$ID = @$_GET['ID'];

			$emp = "";

			/* GET post_id */ 	if (!empty(@$_GET['pid'])) {$this->getVar('post_id', $_GET['pid']);}
			/* GET order_id */ 	if (!empty(@$_GET['oid'])) {$this->db->where('order_id', $_GET['oid']);}
			/* GET meta_key */ 	if (!empty(@$_GET['key'])) {$this->db->where('meta_key', $_GET['key']);}
			/* GET meta_key */ 	if (!empty(@$_GET['value'])) {$this->db->where("meta_value <>", $emp);}
			/* GET post_status */ if (!empty(@$_GET['pst'])) {$this->db->where('post_status', $_GET['pst']);}

			/* GET order by */ 	
			if (!empty(@$_GET['or']) AND !empty(@$_GET['by'])) 
				{$this->db->order_by($_GET['or'], $_GET['by']);}


			if ($ID) { $this->db->where('ID', $ID);}

				$this->db->limit($lim);
				$this->db->offset($off);
				
				$data = $this->db->get($table)->result_array();
				
				if (!empty($_GET['count'])) {
					$data = count($data);
				}


				header('Content-Type: application/json');
				echo json_encode($data, JSON_PRETTY_PRINT);

		} else {echo "no record found.";}
		
		} else {echo 'error';}
	}
	public function index()
	{
		$logged = $this->session->userdata('logged_in');
		if (!$logged) {redirect('login');}
		$data['page'] = 'orders/order';
		$users = 'wp_users';
		$posts = 'wp_posts';



		$table = $posts;

		$or = @$_GET['order'];
		$by = @$_GET['by'];
		$status = @$_GET['status'];
		if (!$or) { $or = 'ID';}
		if (!$by) { $by = 'desc';}

		$offset = @$_GET['off'];
		if (!$offset) {$offset=0;}
		$limit = 50;

		$this->db->limit($limit);
		$this->db->offset($offset);

		if ($status) {
			$this->db->where('post_status', $status);
		}

		
		$this->db->where('post_type','shop_order');
		$this->db->order_by($or, $by);

		// Search
		$data['orders'] = $this->db->get($table)->result_array();


		$data['limit'] = $limit;


		// fetching orders length
		$this->db->where('post_type','shop_order');
		$data['num'] = $this->db->count_all_results($table);

		// loading view
		$this->load->view('template', $data);
	}

	public function detail()
	{
		$order_items = 'wp_woocommerce_order_items';
		$table = 'wp_postmeta';
		

		$post_id = $_GET['no'];

		$this->db->where('post_id',$post_id);		
		$data['orders'] = $this->db->get($table)->result_array();

		$this->db->where('order_id', $post_id);
		$this->db->where('order_item_type', 'line_item');
		$data['items'] = $this->db->get($order_items)->result_array();
		
		$this->db->where('order_id', $post_id);
		$this->db->where('order_item_type', 'coupon');
		$data['coupons'] = $this->db->get($order_items)->result_array();

		$this->load->view('orders/detail', $data);
	}
	
	public function search()
	{
		$data['page'] = 'search';
		$by = $_POST['search'];
		$word = $_POST['word'];
		$this->db->order_by('meta_id', 'DESC');
		$this->db->like($by,$word);
		//echo $by." : ";
		//echo $word."<br>";
		$query = $this->db->get('wp_postmeta')->result_array();

		$this->db->where('post_type','shop_order');

		/*echo "<pre>";
		print_r($query);
		echo "</pre>";*/

		//foreach ($query as $q) {echo json_encode($q);}

		$data['orders'] = $query;
		$data['search'] = $_POST['search'];
		$data['word'] = $_POST['word'];

		
		// loading view
		$this->load->view('template', $data);
	}
	public function login()
	{
		if ($this->session->userdata('logged_in')) {
			redirect(base_url());
		} else {
			if ($_POST) {
				echo $this->session->userdata('logged_in');
				if ($_POST['user'] =='interacademy' && $_POST['pass'] == 'karach!') {
					$userdata = array('logged_in' => true);
					$this->session->set_userdata($userdata);
					redirect('/');
				} else {
					redirect('/login');
				}
			} else {
				$this->load->view('login');
			}
		}
	}
	public function logout()
	{
		$this->session->sess_destroy();
		redirect('/login');
	}
	public function test()
	{
		if ($this->session->userdata('logged_in')) {
			$tab = $_GET['table'];
			$data = $this->db->get($tab)->result_array();
			echo "<pre>";
			print_r($data);
			echo "</pre>";
		} else {
			show_404();
		}
	}

	private function getVar($where, $what)
	{
		return $this->db->where($where, $what);
	}
}
