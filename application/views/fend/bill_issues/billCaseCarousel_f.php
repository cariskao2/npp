<!-- Owl Carousel -->
<!-- <link rel="stylesheet" href="<?php echo base_url('assets/plugins/OwlCarousel2-2.3.4/css/docs.theme.min.css'); ?>"> -->
<link rel="stylesheet"
   href="<?php echo base_url('assets/plugins/OwlCarousel2-2.3.4/owlcarousel/assets/owl.carousel.min.css'); ?>">
<link rel="stylesheet"
   href="<?php echo base_url('assets/plugins/OwlCarousel2-2.3.4/owlcarousel/assets/owl.theme.default.min.css'); ?>">
<!-- <script src="<?php echo base_url('assets/plugins/OwlCarousel2-2.3.4/vendors/jquery.min.js'); ?>"></script> -->
<script src="<?php echo base_url('assets/plugins/OwlCarousel2-2.3.4/owlcarousel/owl.carousel.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/OwlCarousel2-2.3.4/vendors/jquery.mousewheel.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/OwlCarousel2-2.3.4/vendors/highlight.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/OwlCarousel2-2.3.4/js/app.js'); ?>"></script>

<div class="breadcrumb-bg">
   <div class="container">
      <nav aria-label="breadcrumb">
         <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url('fend/home'); ?>">首頁</a></li>
            <li class="breadcrumb-item"><a href="<?php echo base_url('fend/bill_issues_f'); ?>">法案議題</a>
            <li class="breadcrumb-item"><a href="<?php echo base_url('fend/bill_f/billCategoryList_f'); ?>">重點法案</a>
            <li class="breadcrumb-item active" aria-current="page"><?=$getCateGoryInfo->title;?></li>
         </ol>
      </nav>
   </div>
</div>
<div id="gotop">⬆</div>
<div id="loader">
   <div class="loader"></div>
</div>
<div class="container">
   <div style="text-align:center;margin-top:30px;margin-bottom:-10px">
      <h3><?=$getCateGoryInfo->title;?></h3>
   </div>
   <form action="<?php echo base_url('fend/bill_f/billCaseCarousel/' . $getCateGoryInfo->gory_id); ?>" method="post" id="yearSelectForm">
      <select name="select" id="year-select" class="form-control mb-3 pretty-select">
         <?php
if (!empty($getBillCaseCarouselYears)) {
    foreach ($getBillCaseCarouselYears as $item) {
        ?>
         <option value="<?php echo $item->yid; ?>"><?php echo $item->title; ?></option>
         <?php
}
}
?>
      </select>
   </form>
</div>
<!-- Owl Carousel -->
<div class="container-fluid">
   <div class="owl-carousel owl-theme">
   <?php
if (!empty($getBillCaseCarouselList)) {
    foreach ($getBillCaseCarouselList as $item) {
        $statusName    = $item->name;
        $billCaseTitle = $item->titlename;
        $billCaseIntro = $item->introduction;
        ?>
      <div class="case-item">
         <div class="status-name"><?php echo $statusName; ?></div>
         <div class="case-title"><?php echo $billCaseTitle; ?></div>
         <div class="case-intro"><?php echo $billCaseIntro; ?></div>
      </div>
      <?php
}
}
?>
   </div>
</div>
<style>
</style>
<script>
   $(function () {
      // Owl Carousel
      var owl = $('.owl-carousel');
      // var len = owl.children().length;

      owl.owlCarousel({
         margin: 10,
         items: 2,
         center: true, //讓1st item從中間開始顯示,而不是從最左邊
         loop: false, //若center:true,則尾部item會從左邊接上。center:false,在最後一張點擊下一張時,會回到1st item
         nav: true, //是否顯示切換上下一張的button
         navText: ['上一張', '下一張'],
         responsive: {
            // nav、loop、center等設定,都可以寫入
            600: {
               items: 4
            },
            800: {
               items: 6
            },
            1000: {
               items: 8
            },
         }
      });

      // select
      let $this = $(this),
         text = $this.find('option:selected').text(),
         _l = text.length;

      let _w = _l <= 7 ? 200 : _l * 27;

      $('#year-select').css('width', _w + 'px');
   });

   $(document).on('change', '#year-select', function () {
      let $this = $(this),
         text = $this.find('option:selected').text(),
         _l = text.length;

      let _w = _l <= 7 ? 200 : _l * 27;

      $('#year-select').css('width', _w + 'px');
      $('#yearSelectForm').submit();
   });
</script>