<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<div class="breadcrumb-bg">
   <div class="container">
      <nav aria-label="breadcrumb">
         <ol class="breadcrumb">
            <li style="" class="breadcrumb-item"><a href="<?php echo base_url('fend/home'); ?>">首頁</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">法案議題</li>
         </ol>
      </nav>
   </div>
</div>
<div id="gotop">⬆</div>
<div id="loader"><div class="loader"></div></div>
<div class="container">
   <h3 class="bill-issues-title">本屆時代力量黨團提案概況</h3>
   <div id="piechart"></div>
</div>
<div class="container">
   <h3 class="bill-issues-title">關注議題</h3>
   <div class="issues-list-home">
      <div class="row">
         <?php
if (!empty($getIssuesClass)) {
    foreach ($getIssuesClass as $k => $v) {
        ?>
         <?php if ($k % 5 == 0): ?>
         <div class="col-md-8"><a href="<?php echo base_url('fend/issues_f/issuesAllList_f/' . $v->ic_id); ?>"
               class="issues-<?php echo $k + 1; ?>">
               <h2><?php echo $v->name; ?></h2>
               <div class="mask"></div>
            </a></div>
         <?php elseif ($k % 5 == 1): ?>
         <div class="col-md-4"><a href="<?php echo base_url('fend/issues_f/issuesAllList_f/' . $v->ic_id); ?>"
               class="issues-<?php echo $k + 1; ?>">
               <h2><?php echo $v->name; ?></h2>
               <div class="mask"></div>
            </a></div>
         <?php elseif ($k % 5 == 2): ?>
         <div class="col-md-3"><a href="<?php echo base_url('fend/issues_f/issuesAllList_f/' . $v->ic_id); ?>"
               class="issues-<?php echo $k + 1; ?>">
               <h2><?php echo $v->name; ?></h2>
               <div class="mask"></div>
            </a></div>
         <?php elseif ($k % 5 == 3): ?>
         <div class="col-md-4"><a href="<?php echo base_url('fend/issues_f/issuesAllList_f/' . $v->ic_id); ?>"
               class="issues-<?php echo $k + 1; ?>">
               <h2><?php echo $v->name; ?></h2>
               <div class="mask"></div>
            </a></div>
         <?php elseif ($k % 5 == 4): ?>
         <div class="col-md-5"><a href="<?php echo base_url('fend/issues_f/issuesAllList_f/' . $v->ic_id); ?>"
               class="issues-<?php echo $k + 1; ?>">
               <h2><?php echo $v->name; ?></h2>
               <div class="mask"></div>
            </a></div>
         <?php endif;?>
         <?php
}
}
?>
      </div>
   </div>
   <div style="margin-top:30px" class="more"><a href="<?php echo base_url('fend/issues_f/Issues_class_f/'); ?>">更多內容</a></div>
</div>
<div class="container" style="margin-top:50px">
   <h3 class="bill-issues-title">重點法案</h3>
   <div class="issues-list-home">
      <div class="row">
         <?php
if (!empty($getBillCategory)) {
    foreach ($getBillCategory as $k => $v) {
        ?>
         <?php if ($k % 5 == 0): ?>
         <div class="col-md-8"><a href="<?php echo base_url('fend/bill_f/billCaseCarousel/' . $v->gory_id); ?>"
               class="category-<?php echo $k + 1; ?>">
               <h2><?php echo $v->title; ?></h2>
               <div class="mask"></div>
            </a></div>
         <?php elseif ($k % 5 == 1): ?>
         <div class="col-md-4"><a href="<?php echo base_url('fend/bill_f/billCaseCarousel/' . $v->gory_id); ?>"
               class="category-<?php echo $k + 1; ?>">
               <h2><?php echo $v->title; ?></h2>
               <div class="mask"></div>
            </a></div>
         <?php elseif ($k % 5 == 2): ?>
         <div class="col-md-3"><a href="<?php echo base_url('fend/bill_f/billCaseCarousel/' . $v->gory_id); ?>"
               class="category-<?php echo $k + 1; ?>">
               <h2><?php echo $v->title; ?></h2>
               <div class="mask"></div>
            </a></div>
         <?php elseif ($k % 5 == 3): ?>
         <div class="col-md-4"><a href="<?php echo base_url('fend/bill_f/billCaseCarousel/' . $v->gory_id); ?>"
               class="category-<?php echo $k + 1; ?>">
               <h2><?php echo $v->title; ?></h2>
               <div class="mask"></div>
            </a></div>
         <?php elseif ($k % 5 == 4): ?>
         <div class="col-md-5"><a href="<?php echo base_url('fend/bill_f/billCaseCarousel/' . $v->gory_id); ?>"
               class="category-<?php echo $k + 1; ?>">
               <h2><?php echo $v->title; ?></h2>
               <div class="mask"></div>
            </a></div>
         <?php endif;?>
         <?php
}
}
?>
      </div>
   </div>
   <div class="bill-group">
      <div class="more"><a href="<?php echo base_url('fend/bill_f/billCategoryList_f/'); ?>">更多內容</a></div>
      <div class="more"><a href="<?php echo base_url('fend/bill_f/billCaseList_f/'); ?>">提出法案列表</a></div>
   </div>
</div>
<style>
</style>
<script>
   //預設陣列資料
   var items = <?php echo json_encode($billStatusName); ?>;
   var datas = <?php echo json_encode($statusNumRows); ?>;
   var task = ['Task', 'Hours per Day'];// google chart 1st資料格式

   // 合併陣列
   var mapArr = items.map((item, i) => {
         return [item, datas[i]];
   })
   mapArr.unshift(task);//在mapArr前方插入task
   // console.log(mapArr);

   google.charts.load('current', { 'packages': ['corechart'] });
   google.charts.setOnLoadCallback(drawChart);

   function drawChart() {
      var dataMapArr = google.visualization.arrayToDataTable(mapArr);
      var options = {};

      if ($(window).width() > 991) {
         options = {
            // 'width': 1000,
            'height': 600,
            title: '法案狀態分布',
            pieHole: 0.4,//中間中空孔徑
            legend: 'right',// 標籤顯示
            titleTextStyle:{
               fontSize: 30
            },
         };
      } else if($(window).width() > 768) {
         options = {
            // 'width': 1000,
            'height': 400,
            title: '法案狀態分布',
            pieHole: 0.4,//中間中空孔徑
            legend: 'bottom',// 標籤顯示
            titleTextStyle:{
               fontSize: 25
            },
            // legend: {
            //    position: 'bottom',// 標籤顯示
            //    textStyle: {
            //       fontSize: 16,
            //    }
            // }
         };
      } else {
         options = {
            // 'width': 1000,
            'height': 400,
            title: '法案狀態分布',
            pieHole: 0.4,//中間中空孔徑
            legend: 'none',// 標籤顯示
            titleTextStyle:{
               fontSize: 20
            },
         };
      }

      var chart = new google.visualization.PieChart(document.getElementById('piechart'));
      chart.draw(dataMapArr, options);
   }

   $(function () {
      var _getIssuesClass = <?php echo json_encode($getIssuesClass); ?>;

      _getIssuesClass.forEach((v, k) => {
         $('.issues-' + (k + 1)).css('background-image', 'url(' + baseURL +
            'assets/uploads/issuesClass_uplaod/' + v.img + ')');
      });

      var _getBillCategory = <?php echo json_encode($getBillCategory); ?>;

      _getBillCategory.forEach((v, k) => {
         $('.category-' + (k + 1)).css('background-image', 'url(' + baseURL +
            'assets/uploads/bill_category/' + v.img + ')');
      });
   });
</script>