<?php 
function status($str)
{
  if ($str == 'wc-completed') { return 'bg-success'; }
  if ($str == 'wc-on-hold') { return 'bg-warning'; }
  if ($str == 'wc-failed') { return 'bg-danger'; }
}

?>
<div class="container">
  <table class="table" ng-app="myApp" ng-controller="orderCtrl">
    <thead>
      <tr>
        <th>S#</th>
        <th>ORDER Number</th>
        <th>
          <a href="<?= OL('post_date', 'ASC'); ?>"><i class="fa fa-long-arrow-up fa-rotate-180"></i></a> 
          Order Date
          <a href="<?= OL('post_date', 'DESC'); ?>"><i class="fa fa-long-arrow-up"></i></a> 
        </th>
        <th>
            Order Status 
        </th>
        <th>Action</th>
      </tr>
    </thead>
    <?php 
      $i = @$_GET['off'];
      if (!$i) {$i=1;} else {$i=$i+1;}
    ?>
     
     <?php foreach ($orders as $order): ?>
      <tr class="<?php echo status($order['post_status']) ?>">
        <td><?= $i; ?></td>
        <td><?= $order['ID'] ?></td>
        <td>
          <?= date('M d, Y / h:i a', strtotime($order['post_date']));?> </td>
        <td>
          <?= ucfirst(str_replace('wc-', '', $order['post_status'])); ?>
        </td>
        <td>
          <a class="btn btn-warning btn-sm" data-toggle="modal" href="#DETAIL" data-href="<?= base_url();?>detail/?no=<?= $order['ID'] ?>"><i class="fa fa-pencil-square-o"></i> View Detail</a>
        </td>
      </tr>
    <?php $i++; endforeach ?> 
  </table>
  <?php 
      $page = 1;
      $url = base_url();
      for ($i=0; $i < $num; $i = $i + $limit) : ?>
        <a href="<?= $url.'?off='.$i; ?>"><?= $page; ?></a> / 
      <?php $page++; endfor;
  ?>
  
</div>
