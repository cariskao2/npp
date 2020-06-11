<div id="gotop">^</div>
<div class="container-fluid">
   <div id="carousel" class="carousel slide" data-ride="carousel">

      <!-- 指示符 -->
      <ul class="carousel-indicators">
         <?php
$i = 0;
if (!empty($getCarouselInfo)) {
    foreach ($getCarouselInfo as $record) {
        ?>
         <li data-target="#carousel" data-slide-to="<?php echo $i++; ?>">
         </li>
         <?php
}
}
?>
      </ul>

      <!-- 輪播圖片 -->
      <div class="carousel-inner">
         <?php
if (!empty($getCarouselInfo)) {
    foreach ($getCarouselInfo as $record) {
        ?>
         <div class="carousel-item">
            <a href="<?php echo $record->link; ?>"><img
                  src="<?php echo base_url('assets/uploads/carousel_upload/' . $record->img); ?>"></a>
            <div class="carousel-caption">
               <h3><?php echo $record->title; ?></h3>
               <p><?php echo $record->introduction; ?></p>
            </div>
         </div>
         <?php
}
}
?>
      </div>

      <!-- 左右切換按鈕 -->
      <a class="carousel-control-prev" href="#carousel" data-slide="prev">
         <span class="carousel-control-prev-icon"></span>
      </a>
      <a class="carousel-control-next" href="#carousel" data-slide="next">
         <span class="carousel-control-next-icon"></span>
      </a>
   </div>
</div>
<div class="container custom-gutters">
   <div class="row">
      <div class="col-md-12">
         <div class="home-title_style">新聞訊息</div>
         <div class="row">
            <?php
if (!empty($getNewsInfo)) {
    foreach ($getNewsInfo as $record) {
        $id      = $record->pr_id;
        $type_id = $record->pr_type_id;
        $img     = $record->img;
        $m_title = $record->main_title;
        $date    = $record->date_start;
        $e       = $record->editor;
        ?>
            <div class="col-lg-4 col-md-6">
               <a href="<?php echo base_url('fend/news_f/newsInner/' . $type_id . '/' . $id); ?>"
                  class="newsBlock_style" style="border-radius:0">
                  <div class="card mb-4 box-shadow">
                     <img class="card-img-top"
                        src="<?php echo base_url('assets/uploads/news_upload/' . $type_id . '/' . $img); ?>"
                        alt="Card image cap">
                     <div class="card-body">
                        <h5><?php echo mb_strimwidth(strip_tags($m_title), 0, 40, '...'); ?></h5>
                        <span class="data-start_fontsize">發布日期：<?php echo $date; ?></span>
                        <p><?php echo mb_strimwidth(strip_tags($e), 0, 100, '...'); ?></p>
                     </div>
                  </div>
               </a>
            </div>
            <?php
}
}
?>
         </div>
         <div class="more"><a href="<?php echo base_url('fend/news_f'); ?>">更多內容</a></div>
      </div>
   </div>
</div>
<script>
   $(function () {
      $('.carousel').carousel({
         interval: 7000, // false
         pause: "hover", // false
      });
   });

   $(".carousel-indicators li:first").addClass("active");
   $(".carousel-inner div:first").addClass("active");
</script>