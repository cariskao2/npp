<?php
$title = $getCategoryInfo->title;

if ($categoryIdCheck > 0) {
    $gory_id = $getCategoryInfo->gory_id;

    $e    = $getBillCaseInfo->editor;
    $link = $getBillCaseInfo->link;
}
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
<div id="loader"><div class="loader"></div></div>
<?php if ($categoryIdCheck > 0) {
    //進入法案輪播前先確認該法案是否有被選擇
    ?>
<div class="container">
   <div style="text-align:center;margin-top:30px;margin-bottom:-10px">
      <h3><?=$title;?></h3>
   </div>
   <form action="<?php echo base_url('fend/bill_f/billCaseCarousel/' . $gory_id); ?>" method="post" id="yearSelectForm">
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
               src="<?php echo base_url('assets/f_imgs/billCaseCarousel/link.png'); ?>" alt="not found">
            <br><span>完整草案連結</span>
         </a>
      </div>
      <div class="time-line">
         <?php
if (!empty($getBillCaseSessions)) {
        foreach ($getBillCaseSessions as $record) {
            $sesId = $record->ses_id;
            $ses   = $record->session;
            ?>
         <div class="time-line-block">
            <div class="time-line-session"><?php echo $ses; ?></div>
            <div class="time-line-info">
            <span class="line"></span>
               <?php
if (!empty($getBillCaseSessionInfo)) {
                foreach ($getBillCaseSessionInfo as $item) {
                    $ses_id  = $item->ses_id;
                    $date    = $item->date;
                    $title   = $item->title;
                    $content = $item->content;
                    $url     = $item->url;

                    if ($ses_id == $sesId) {
                        ?>
               <div class="line-info">
                  <span class="info-date"><?php echo str_replace('-', '.', $date); ?></span>
                  <span class="info-dot"></span>
                  <span class="info-title"><?php echo $title; ?></span>
                  <span class="info-board-icon">
                     <img src="<?php echo base_url('assets/f_imgs/billCaseCarousel/note.png'); ?>" alt="not found!">
                     <input type="hidden" name="board-hide" class="board-hide" value="<?php echo $content; ?>">
                  </span>
                  <?php if ($url != ''): ?>
                  <a class="info-video-icon" target="_blank" href="<?php echo $url; ?>"><img
                        src="<?php echo base_url('assets/f_imgs/billCaseCarousel/draft_youtube.png'); ?>"
                        alt="not found!"></a>
                  <?php endif;?>
               </div>
               <?php
}
                }
            }
            ?>
            </div>
         </div>
         <?php
}
    } else {
        ?>
         <p class="no-category-match">此法案尚未建立任何立法程序</p>
         <?php
}
    ?>
      </div>
   </div>
</div>
<script>
   // sweetalert2
   $('.time-line').on('click', '.info-board-icon', function (e) {
     let _boardContent = $(this).children('.board-hide').val();

      swal({
         // text: '',
         html: _boardContent
      });
   });

   // swiper
   var swiper = new Swiper('.swiper-container', {
      initialSlide: <?php echo $currentCaseIdIndex; ?>,
      slidesPerView : 1,
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

   swiper.on('slideChange', function (e) {
      // let index = $(this).index();
      let caseId = $('.swiper-slide .case-id').eq(e.activeIndex).val();

      // console.log(e.activeIndex);
      // console.log(caseId);

      getBillCaseInfoAjax(caseId);
      getBCSesAndInfoAjax(caseId);
   });
</script>
<?php } else {?>
<p class="no-category-match">此法案類別目前無任何匹配的法案</p>
<?php }?>
<style>
   .no-category-match {
      text-align: center;
      color: red;
      font-size: 30px;
      font-weight: bloder;
      margin-top: 30px;
      height: calc(100vh - 515px);
   }
</style>