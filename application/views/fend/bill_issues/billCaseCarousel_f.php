<?php
$title   = $getCategoryInfo->title;
$gory_id = $getCategoryInfo->gory_id;

$e    = $getBillCaseInfo->editor;
$link = $getBillCaseInfo->link;
?>
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
            <li class="breadcrumb-item active" aria-current="page"><?=$title;?></li>
         </ol>
      </nav>
   </div>
</div>
<div id="gotop">⬆</div>
<!-- <div id="loader"><div class="loader"></div></div> -->
<div class="container">
   <div style="text-align:center;margin-top:30px;margin-bottom:-10px">
      <h3><?=$title;?></h3>
   </div>
   <form action="<?php echo base_url('fend/bill_f/billCaseCarousel/' . $gory_id); ?>" method="post"
      id="yearSelectForm">
      <select name="select" id="case-year-select" class="form-control mb-3 pretty-select">
         <?php
if (!empty($getBillCaseCarouselYears)) {
    foreach ($getBillCaseCarouselYears as $item) {
        ?>
        <?php if ($caseIdCheck): ?>
         <option value="<?php echo $item->yid; ?>" <?php if ($matchYId == $item->yid) {echo 'selected';}?>><?php echo $item->title; ?></option>
        <?php else: ?>
         <option value="<?php echo $item->yid; ?>"><?php echo $item->title; ?></option>
        <?php endif;?>
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
        $billCaseId    = $item->case_id;
        $billCaseTitle = $item->titlename;
        $billCaseIntro = $item->introduction;
        $statusName    = $item->name;
        $color         = $item->color_name;
        ?>
         <div class="swiper-slide">
            <div class="status-name" style="background-color:<?php echo $color; ?>"><?php echo $statusName; ?></div>
            <div class="case-title"><?php echo $billCaseTitle; ?></div>
            <div class="case-intro"><?php echo $billCaseIntro; ?></div>
            <input type="hidden" class="case-id" name="caseId" value="<?php echo $billCaseId; ?>">
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
<div class="dark">
   <div class="container">
      <div class="case-editor">
         <div class="content"><?php echo $e; ?></div>
         <div class="open">
            <div class="open-img"></div>
         </div>
      </div>
      <div class="file-url">
         <a target="_blank" href="<?php echo $link; ?>"><img
               src="<?php echo base_url('assets/f_imgs/billCaseCarousel/link.png'); ?>" alt="not found"></a>
      </div>
      <div class="time-line"></div>
   </div>
</div>
<style>
</style>
<script>
   // swiper
   var swiper = new Swiper('.swiper-container', {
      initialSlide: <?php echo $currentCaseIdIndex; ?>,
      slidesPerView: 1,
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
            slidesPerView: 3,
         },
         1200: {
            slidesPerView: 6,
         },
      }
   });
</script>