<div class="breadcrumb-bg">
   <div class="container">
      <nav aria-label="breadcrumb">
         <ol class="breadcrumb">
            <li style="" class="breadcrumb-item"><a href="<?php echo base_url('fend/home'); ?>">首頁</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">新聞訊息</li>
         </ol>
      </nav>
   </div>
</div>
<div id="gotop">^</div>
<div class="container custom-gutters" style="margin-bottom:20px">
   <div class="row">
      <div class="col-md-12">
         <div class="home-title_style" style="margin-top:30px">法案及議事說明</div>
         <div class="row">
            <?php
if (!empty($get1Info)) {
    foreach ($get1Info as $record) {
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
         <div class="more"><a href="<?php echo base_url('fend/news_f/newsFlists/1/'); ?>">更多內容</a></div>
      </div>
   </div>
</div>
<div class="container custom-gutters" style="margin-bottom:20px">
   <div class="row">
      <div class="col-md-12">
         <div class="home-title_style" style="margin-top:30px">懶人包及議題追追追</div>
         <div class="row">
            <?php
if (!empty($get2Info)) {
    foreach ($get2Info as $record) {
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
         <div class="more"><a href="<?php echo base_url('fend/news_f/newsFlists/2/'); ?>">更多內容</a></div>
      </div>
   </div>
</div>
<div class="container custom-gutters">
   <div class="row">
      <div class="col-md-12">
         <div class="home-title_style" style="margin-top:30px">行動紀實</div>
         <div class="row">
            <?php
if (!empty($get3Info)) {
    foreach ($get3Info as $record) {
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
         <div class="more"><a href="<?php echo base_url('fend/news_f/newsFlists/3/'); ?>">更多內容</a></div>
      </div>
   </div>
</div>