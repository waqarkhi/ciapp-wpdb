<?php 
$remove = array();
$remove[] = array('meta_key' => '_order_total');
$remove[] = array('meta_key' => '_order_total');
$remove[] = array('meta_key' => '_order_currency');
$remove[] = array('meta_key' => '_payment_method_title');
$remove[] = array('meta_key' => '_billing_first_name');
$remove[] = array('meta_key' => '_billing_last_name');
$remove[] = array('meta_key' => '_billing_email');
$remove[] = array('meta_key' => '_billing_phone');
$remove[] = array('meta_key' => '_billing_city');
$remove[] = array('meta_key' => '_billing_address_1');
$remove[] = array('meta_key' => '_billing_class');
$remove[] = array('meta_key' => '_billing_text_board');
$remove[] = array('meta_key' => '_cart_discount');
$remove[] = array('meta_key' => '_completed_date');
?>
<pre>
	<?php //print_r($remove); ?>
</pre>
	<div class="row">
		<div class="col-md-12">
			<table class="table table-bordered">
				<tr><th>Order No.</th><td><?= $orders[0]['post_id'] ?></td></tr>
				<?php foreach ($orders as $o): ?>
					<?php foreach ($remove as $r): ?>
						<?php if ($o['meta_key'] == $r['meta_key']): ?>
							<?php $title = str_replace('_', ' ', $o['meta_key']);?>
							<tr><th><?= $title; ?></th><td class="<?= $o['meta_key'] ?>"><?= $o['meta_value'] ?></td></tr>
						<?php endif ?>
					<?php endforeach ?>
				<?php endforeach ?>
			</table>
			<!-- <h2>All Data</h2>
			<table class="table table-bordered">
				<?php foreach ($orders as $o): ?>
				<?php $title = str_replace('', '', $o['meta_key']);?>
				<tr><th><?= $title; ?></th><td><?= $o['meta_value'] ?></td></tr>
			<?php endforeach ?>
			</table> -->
		</div>
		<div class="col-md-12">
			<h4>Course(s) purchased</h4>
			<?php foreach ($items as $i): ?>
				<ul class="list-group">
					<li class="list-group-item"><?= $i['order_item_name'] ?></li>
				</ul>
			<?php endforeach ?>
			<?php if (sizeof($coupons) > 0): ?>
				<h4>Discount Coupon</h4>
				<?php foreach ($coupons as $c): ?>
					<ul class="list-group disc">
						<li class="list-group-item"><?= $c['order_item_name'] ?></li>
					</ul>
				<?php endforeach ?>				
			<?php endif ?>
		<pre>
			<?php //print_r($items); ?>
		</pre>
		</div>
	</div>
<pre>
<?php //print_r($orders); ?>
</pre>

<script type="text/javascript">
	$(function() {
  var cart_total = parseFloat($('._order_total').html());
  var discount = parseFloat($('._cart_discount').html());
  var total = cart_total + discount;
  var dis_per = discount/total*100;
  $('._cart_discount').append(' <span class="badge badge-primary">'+dis_per+'%</span>');
});
</script>