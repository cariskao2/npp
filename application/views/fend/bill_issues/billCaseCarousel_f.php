<link rel="stylesheet" href="<?php echo base_url('assets/plugins/swiper@6.3.5/css/swiper-bundle.min.css'); ?>">
<link rel="stylesheet" href="<?php echo base_url('assets/plugins/swiper@6.3.5/css/style.css'); ?>">
<script src="<?php echo base_url('assets/plugins/swiper@6.3.5/js/swiper-bundle.min.js'); ?>"></script>

<div class="breadcrumb-bg">
   <div class="container">
      <nav aria-label="breadcrumb">
         <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url('fend/home'); ?>">首頁</a></li>
            <li class="breadcrumb-item"><a href="<?php echo base_url('fend/bill_issues_f'); ?>">法案議題</a>
            <li class="breadcrumb-item"><a href="<?php echo base_url('fend/bill_f/billCategoryList_f'); ?>">重點法案</a>
            <li class="breadcrumb-item active" aria-current="page"><?=$getCategoryInfo->title;?></li>
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
      <h3><?=$getCategoryInfo->title;?></h3>
   </div>
   <form action="<?php echo base_url('fend/bill_f/billCaseCarousel/' . $getCategoryInfo->gory_id); ?>" method="post"
      id="yearSelectForm">
      <select name="select" id="year-select" class="form-control mb-3 pretty-select">
         <?php
if (!empty($getBillCaseCarouselYears)) {
    foreach ($getBillCaseCarouselYears as $item) {
        ?>
         <option value="<?php echo $item->yid; ?>" <?php if ($sendYId == $item->yid) {echo 'selected';}?>>
            <?php echo $item->title; ?></option>
         <?php
}
}
?>
      </select>
   </form>
</div>
<div class="container-fluid">
   <div class="swiper-container">
      <div class="swiper-wrapper">
         <?php
if (!empty($getBillCaseCarouselList)) {
    foreach ($getBillCaseCarouselList as $item) {
        $statusName    = $item->name;
        $billCaseTitle = $item->titlename;
        $billCaseIntro = $item->introduction;
        $color         = $item->color_name;
        ?>
         <div class="swiper-slide">
            <div class="status-name" style="background-color:<?php echo $color; ?>"><?php echo $statusName; ?></div>
            <div class="case-title"><?php echo $billCaseTitle; ?></div>
            <div class="case-intro"><?php echo $billCaseIntro; ?></div>
         </div>
         <?php
}
}
?>
      </div>
      <div class="swiper-pagination"></div>
      <div class="swiper-button-next"></div>
      <div class="swiper-button-prev"></div>
      <div class="center-triangle"></div>
   </div>
</div>
<style>
</style>
<script>
   var swiper = new Swiper('.swiper-container', {
      slidesPerView: 2,
      spaceBetween: 30,
      centeredSlides: true,
      autoHeight: true,
      pagination: {
         el: '.swiper-pagination',
         clickable: true,
      },
      navigation: {
         nextEl: '.swiper-button-next',
         prevEl: '.swiper-button-prev',
      },
      breakpoints: {
         768: {
            slidesPerView: 4,
         },
         1200: {
            slidesPerView: 6,
         },
      }
   });

   $(function () {
      // select
      let $this = $(this),
         text = $this.find('option:selected').text(),
         _l = text.length;

      let _w = _l <= 7 ? 200 : _l < 20 ? _l * 10 : _l < 25 ? _l * 12 : _l * 15;

      $('#year-select').css('width', _w + 'px');
   });

   $(document).on('change', '#year-select', function () {
      let $this = $(this),
         text = $this.find('option:selected').text(),
         _l = text.length;

      let _w = _l <= 7 ? 200 : _l < 20 ? _l * 10 : _l < 25 ? _l * 12 : _l * 15;

      $('#year-select').css('width', _w + 'px');
      $('#yearSelectForm').submit();
   });
</script>