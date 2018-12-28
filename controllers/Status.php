<?php 
class Status extends CI_Controller
{
	public function index()
	{
		$data['page'] = $this->page('index');
		$posts = 'wp_posts';

		$table = $posts;

		$or = @$_GET['order'];
		$by = @$_GET['by'];
		$status = @$_GET['status'];
		if (!$or) { $or = 'ID';}
		if (!$by) { $by = 'desc';}

		$offset = @$_GET['off'];

		if (!$offset) {$offset=0;}

		$limit = 5;

		$this->db->limit($limit);
		$this->db->offset($offset);

		if ($status) {$this->db->where('post_status', $status);}

		
		$this->db->where('post_type','shop_order');
		$this->db->where('post_status','wc-completed');
		$this->db->order_by($or, $by);

		// Search
		$data['orders'] = $this->db->get($table)->result_array();


		$data['limit'] = $limit;


		// fetching orders length
		$this->db->where('post_status','wc-completed');
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


		$this->load->view('detail', $data);
	}

	private function page($page)
	{
		return 'status/'.$page;
	}
	public function dateplus()
	{
		$months = $_GET['months'];
		$from = $_GET['from'];
		$date = $from;;
        $date = strtotime(date("Y-m-d", strtotime($date)) . " +".$months." month");
        $date = date("Y-m-d",$date);
        echo $date;
	}
}