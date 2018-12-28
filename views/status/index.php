<style type="text/css">
.badge {padding:3px 5px 6px;}

  table td p {margin: 0;font-size: 13px;}
</style>
<div class="" ng-controller="statusCtrl">
  <table class="table">
    <thead>
      <tr>
        <th>Order #</th>
        <th>Name</th>
        <th>Course / Ending</th>
        <th>Start Date</th>
        <th>Email</th>
      </tr>
    </thead> 
    <tbody>
    	<tr ng-repeat="o in userOrderItems" class="{{o.class}}">
        <td>{{o.order_id}}</td>
    		<td>{{o.first_name}} {{o.last_name}}</td>
    		<td>
          <p ng-repeat="course in o.courses">
            <span>{{course.name}}</span> | {{course.end_date}} <span class="badge badge-{{course.badge}}">{{course.remain}}</span>
          </p>
        </td>
    		<td>{{o.start_date}}</td>
    		<td>{{o.email}}</td>
    	</tr>
    </tbody>
  </table>
<ul class="pagination justify-content-center">
  <li class="page-item" ng-repeat="p in pages"><a class="page-link" href="<?= base_url() ?>status?off={{p.off}}">{{p.page}}</a></li>
</ul>



</div>

<script type="text/javascript">
<?php 
  $by = 'DESC';
  $or = 'meta_value';
  $off = 0;
  $lim = 10;

  if (!empty($_GET['off'])) {$off = $_GET['off'];}
  if (!empty($_GET['lim'])) {$lim = $_GET['lim'];}
  
  if (!empty($_GET['by'])) {$by = $_GET['by'];}
  if (!empty($_GET['or'])) {$or = $_GET['or'];}

  $addition = '&or='.$or.'&by='.$by.'&off='.$off."&lim=".$lim;
?>
var app = angular.module("miaApp",[]);


var url = '<?= base_url(); ?>API?tab=wp_postmeta&key=_completed_date&value=1<?= $addition; ?>';
var ctrl = 'statusCtrl';
var orderDetails=[];
<?php date_default_timezone_set('Asia/Karachi'); ?>
var current_date = moment('<?= date("d-M-Y", time()) ?>');
var count = '<?= base_url(); ?>API?tab=wp_postmeta&key=_completed_date&value=1&count=1';

app.controller(ctrl, function ($scope, $http) {
  $http.get(count).then((res) => {
    var page = 1;
    var NO = parseInt(res.data);
    var lim = <?= $lim; ?>;
    var end = '';
    var paging = [];
    for(i=0; i<NO; i = i+lim) {
      var p = {};
      p.page = page;
      p.off = i
      paging.push(p);
      page++;
    }
    console.log(paging);
    $scope.pages = paging;

  });
	$http.get(url).then((res) => {
    orders = res.data;
    orders.forEach((order) => {

      var obj = {};

      obj.order_id = order.post_id;

      orderurl = '<?= base_url(); ?>API?tab=wp_postmeta&pid='+order.post_id;
      $http.get(orderurl).then((res) => {
        user_details = res.data;
         user_details.forEach((ud) => {
          if (ud.meta_key == "_billing_first_name") { obj.first_name = ud.meta_value;}
          if (ud.meta_key == "_billing_last_name") { obj.last_name = ud.meta_value;}
          if (ud.meta_key == "_completed_date") { 
              obj.start_date = moment(ud.meta_value).format('YYYY-MMM-DD');
              obj.rawsd = ud.meta_value;
            }
          if (ud.meta_key == "_billing_email") { obj.email = ud.meta_value;}
        });
      }).then(() => {
        var orderItemUrl = '<?= base_url(); ?>API?tab=wp_woocommerce_order_items&oid='+order.post_id;
        //console.log(orderItemUrl);
        $http.get(orderItemUrl).then((res) => {
            var items = res.data;

            var courses = [];
            var warn = [];
            items.forEach((orderItem) => {
              if (orderItem.order_item_type == 'line_item') {
                  var UND = orderItem.order_item_name;
                  var dur = '';

                    if (UND.includes('1 Month')) { dur = 1; }
                    if (UND.includes('3 Month')) { dur = 3; }
                    if (UND.includes('6 Month')) { dur = 6; }
                    if (UND.includes('9 Month')) { dur = 9; }

                   
                    var addTime = moment(obj.start_date).add(dur, 'month');
                    var remain = addTime.endOf('day').from(current_date);
                    var ED = `${addTime.format('DD-MMM-YY')} - ${remain}`;
                    warn.time = addTime.endOf('day').from(current_date);
                    var badge = '';

                    if (remain.includes('ago')) {
                        badge = "danger";
                    } else {
                      if (remain.includes('a day')) {
                          badge = "warning";                          
                        } else {

                        if (remain.includes('days')) {
                          var is_Warn = remain.split('in ').join('');
                          is_Warn = parseInt(is_Warn,10);
                          console.log(is_Warn);
                          if (is_Warn < 10) {
                            badge = "warning";                            
                          } else {
                            badge = "success";
                          }
                        }
                      }
                    }

                    if (remain.includes('month')) {
                        badge = "success";                      
                    }
                    

                  courses.push({name:orderItem.order_item_name, end_date:ED,badge:badge,remain:remain});
              }
            });
            obj.courses = courses;
        });
        
      });
      orderDetails.push(obj);
    })
    orderDetails.sort((a, b) => parseFloat(a.sorting) - parseFloat(b.sorting));
      console.log(orderDetails);
    $scope.userOrderItems = orderDetails;
  });
});

/*jQuery(window).load(function () {
  setInterval(() => {
    var con = 'tr:contains(in 10 days),tr:contains(in 9 days),tr:contains(in 8 days),tr:contains(in 7 days),tr:contains(in 6 days),tr:contains(in 5),tr:contains(in 4 days),tr:contains(in 3 days),tr:contains(in 2 days),tr:contains(in a day)';
    var exp = 'tr:contains(ago)';
    
    if ($('tr').hasClass('expring') != true) {jQuery(con).addClass('expring');}
    if ($('tr').hasClass('expired') != true) {jQuery(exp).addClass('expired');}

  },1000);
});*/

// to be continue.. http://localhost/orders/status

</script>