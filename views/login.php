<!DOCTYPE html>
<html lang="en">
<head>
  <title>Orders</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
  <style type="text/css">
    .bg-success {background: #e7fdec !important;}
    .bg-warning {background-color:#fff8e5 !important;}
  .bg-danger {background-color:#ffe4e5 !important}
  </style>
</head>
<body>
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-4 mt-5">
      <?php if ($this->session->flashdata('danger')): ?>
        <div class="alert alert-danger"><?= $this->session->flashdata('danger'); ?></div>
      <?php endif ?>
      <form method="post" action="login">
    <div class="form-group">
      <input type="text" class="form-control" name="user" id="un" placeholder="Enter username">
    </div>
    <div class="form-group">
      <input type="password" class="form-control" name="pass" id="pwd" placeholder="Enter password">
    </div>
    <button type="submit" class="btn btn-primary btn-block">Login</button>
  </form>
    </div>
  </div>
</div>
</body>
</html>