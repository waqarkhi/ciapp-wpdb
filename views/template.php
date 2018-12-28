<?php
if (!$this->session->userdata('logged_in')) {
    redirect('login');
}
if (empty($search)) {$search = '';} 
if (empty($word)) {$word = '';} 
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
<!DOCTYPE html>
<html lang="en" ng-app="miaApp">
<head>
  <title>Orders</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="<?= base_url('assets/js/moment.js') ?>"></script>
  <style type="text/css">
    .bg-success {background: #e7fdec !important;}
    .bg-warning {background-color:#fff8e5 !important;}
  .bg-danger {background-color:#ffe4e5 !important}
  .progress-bar {background: #333}
  .progress {height: 3px !important}
  </style>
  <?php if (strpos($page, 'status') !== false): ?>
    <?php $this->load->view('status/ng.php'); ?>
  <?php endif ?>
</head>
<body>
    <nav class="navbar navbar-expand-sm bg-primary navbar-dark">
      <div class="container">
        <!-- Brand/logo -->
        <a class="navbar-brand" href="#">MIA</a>
        
        <!-- Links -->
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a class="nav-link text-light" href="<?= base_url(); ?>">Orders Detail</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-light" href="<?= base_url(); ?>status">Enrollment Detail</a>
          </li>
        </ul>
        <form style="display: inline-block;" action="search" method="post">
          <div class="input-group">
            <input type="text" name="word" class="form-control" value="<?= $word; ?>" placeholder="Search Anything">
            <select name="search" class="form-control">
              <option value="post_id" <?=($search == 'post_id') ? 'selected':'' ?>>Order No</option>
              <option value="meta_value" <?=($search == 'meta_value') ? 'selected':'' ?>>Anything</option>
            </select>
            <div class="input-group-append">
              <button class="btn btn-warning" type="submit"><i class="fa fa-search"></i></button>  
            </div>
          </div>
        </form>
        <a href="logout" class="btn btn-light ml-3"><i class="fa fa-user"></i> Logout</a>
        
      </div>
    </nav>
  <div class="container">
    <div class="mt-3 mb-3">
    <div class="row">
      <div class="col-md-7">
        <?php if (strpos($page, 'status') !== false): ?>
        <?php else: ?>
          <?php $this->load->view('orders/nav'); ?>
        <?php endif ?>
      </div>
      <div class="col-md-4 text-right">
        
      </div>
      <div class="col-md-1 text-right">
      </div>
    </div>
  </div>
  </div>
  <?php $this->load->view($page); ?>
</body>
</html>
<!-- The Modal -->
<div class="modal" id="DETAIL">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Order Detail</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body"></div>
    </div>
  </div>
</div>
<script type="text/javascript">
window.onload = function () {
  $('a[href="#DETAIL"]').on('click', function () {
    var url = $(this).attr('data-href');
    var target = $('#DETAIL .modal-body');
    var loader = `<div id="loader" class="text-center">
        <i class="fa fa-4x fa-spin fa-refresh"></i><br>
        loading...</div><div style="display:none;" id="OD"></div>`;
    target.html(loader);
    setTimeout(function() {
      target.load(url, function function_name() {
        $('#loader').remove();
      });
    }, 1000);
  })
}
</script>