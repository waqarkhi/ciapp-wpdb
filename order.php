<?php 
function status($str)
{
  if ($str == 'wc-completed') { return 'bg-success'; }
  if ($str == 'wc-on-hold') { return 'bg-warning'; }
  if ($str == 'wc-failed') { return 'bg-danger'; }
}
function ML($type)
{
    return base_url().'?status='.$type;
}
function OL($o,$b)
{
  $status = @$_GET['status'];
  if ($status) {$uri = current_url().'?status='.$_GET['status'];}
  else { $uri = current_url().'?'; }
  $uri .= '&or='.$o;
  $uri .= '&by='.$b;
  $uri = str_replace('?&', '?', $uri);
  return $uri;
}
?>
<div class="container">
  <div class="mt-3 mb-3">
    <div class="row">
      <div class="col-md-8">
        <a href="<?= base_url(); ?>" class="btn btn-primary">All</a> 
        <a href="<?= ML('wc-completed'); ?>" class="btn btn-success">Completed</a> 
        <a href="<?= ML('wc-pending'); ?>" class="btn btn-info">Pending</a> <a href="<?= ML('wc-on-hold'); ?>" class="btn btn-warning">On Hold</a> 
        <a href="<?= ML('wc-failed'); ?>" class="btn btn-danger">Failed</a> 
        <a href="<?= ML('wc-cancelled'); ?>" class="btn btn-secondary">Cancelled</a> 
        <a href="<?= ML('trash'); ?>" class="btn btn-outline-dark">Trashed</a> 
      </div>
      <div class="col-md-4 text-right">
        <form style="display: inline-block;" action="search" method="post">
          <div class="input-group mb-3">
            <input type="text" name="word" class="form-control" placeholder="Search Anything">
            <select name="search" class="form-control">
              <option value="post_id">Order No</option>
              <option value="meta_value">Email Address</option>
            </select>
            <div class="input-group-append">
              <button class="btn btn-success" type="submit"><i class="fa fa-search"></i></button>  
            </div>
          </div>
        </form>
        <a href="logout" class="btn btn-outline-dark"><i class="fa fa-user"></i> Logout</a>
      </div>
    </div>

  </div>
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
     <tr ng-repeat="x in orders | orderBy : '-ID'">
      <td>{{ $index + 1 }}</td>
      <td>{{ x.ID }}</td>
      <td>{{ x.post_date }}</td>
      <td>
          <span ng-if="x.post_status == 'wc-on-hold'">On-hold</span>
          <span ng-if="x.post_status == 'trash'">Trashed</span>
          <span ng-if="x.post_status == 'wc-cancelled'">Cancelled</span>
          <span ng-if="x.post_status == 'wc-pending'">Pending</span>
          <span ng-if="x.post_status == 'wc-failed'">Failed</span>
          <span ng-if="x.post_status == 'wc-completed'">Completed</span>
      </td>
      <td>
          <a class="btn btn-warning btn-sm" href="<?= base_url();?>detail/?no={{ x.ID }}"><i class="fa fa-pencil-square-o"></i> View Detail</a>
      </td>
    </tr>
  </table>
  <?php 
      $page = 1;
      $url = base_url();
      for ($i=0; $i < $num; $i = $i + $limit) : ?>
        <a href="<?= $url.'?off='.$i; ?>"><?= $page; ?></a> / 
      <?php $page++; endfor;
  ?>
  
</div>
