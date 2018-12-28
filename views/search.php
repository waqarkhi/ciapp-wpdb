<div class="container">
  <table class="table">
    <thead>
      <tr>
        <th>S#</th>
        <th>ORDER Number</th>
        <th>Order Date</th>
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
     <tbody id="data"></tbody>
  </table>
  
  
</div>
<script type="text/javascript">
$(document).ready(function () {
var obj = [];
<?php foreach ($orders as $o): ?>
  obj.push("<?php echo $o['post_id']; ?>");
<?php endforeach ?>
var arr = $.unique(obj);
if (arr.length > 0) {
  $('.table').before('<div class="progress" id="LD"><div class="progress-bar" style="width:0"></div></div>');  
} else {
  $('.table').after('<div class="text-center" id="LD">No record found.</div>');
}
var i = 1;
var f = 0;
arr.forEach(function (id) {
  var URL = "<?= base_url();?>API?tab=wp_posts&ID=";
  $.ajax({
    url : URL+id,
    success: function (res) {
      console.log(res);
      $(function () {
        var val = Object.values(res)[0];

        console.log(val);
        if (val != undefined) {
            var html = '<tr id="ID'+i+'"></tr>';

            var status = val['post_status'];
            
            if (status === 'wc-processing') { status = 'Processing';}
            if (status === 'wc-failed') { status = 'Failed';}
            if (status === 'wc-completed') { status = 'Completed';}
            if (status === 'wc-pending') { status = 'Pending';}
            if (status === 'wc-cancelled') { status = 'Cancelled';}
            if (status === 'wc-on-hold') { status = 'On-hold';}
            if (status === 'trash') { status = 'Trashed';}

            $('#data').append(html);
            $('#data #ID'+i).append('<td>'+i+'</td>');
            $('#data #ID'+i).append('<td>'+val['ID']+'</td>');
            $('#data #ID'+i).append('<td>'+val['post_date']+'</td>');
            $('#data #ID'+i).append('<td>'+status+'</td>');
            $('#data #ID'+i).append('<td><a class="btn btn-warning btn-sm" data-toggle="modal" href="#DETAIL" data-href="<?= base_url();?>detail/?no='+val['ID']+'"><i class="fa fa-pencil-square-o"></i> View Detail</a></td>');
            i = i+1;
        }
        f = f+1;
        var per = Math.round(f*(100/arr.length));
        var LDC = '';
        $('#LD .progress-bar').attr('style','width:'+per+'%');
        if (f == arr.length) {
          
          //onclick popup detail
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
            });
        }
      })
    }
  });
});
});


</script>