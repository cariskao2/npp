<?php
$name       = $getMemberInfo->name;
$name_en    = $getMemberInfo->name_en;
$img        = $getMemberInfo->img;
$education  = $getMemberInfo->education;
$experience = $getMemberInfo->experience;
$districts  = $getMemberInfo->districts;
$committee  = $getMemberInfo->committee;
$fb         = $getMemberInfo->fb;
$ig         = $getMemberInfo->ig;
$line       = $getMemberInfo->line;
$yt         = $getMemberInfo->yt;
?>
<div class="breadcrumb-bg">
   <div class="container">
      <nav aria-label="breadcrumb">
         <ol class="breadcrumb">
            <li style="" class="breadcrumb-item"><a href="<?php echo base_url('fend/home'); ?>">首頁</a>
            </li>
            <li style="" class="breadcrumb-item"><a href="<?php echo base_url('fend/members_f'); ?>">本黨立委</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page"><?php echo $name; ?></li>
         </ol>
      </nav>
   </div>
</div>
<div id="gotop">^</div>
<div id="loader">
   <div class="loader"></div>
</div>
<div class="container">
   <div class="row mt-5">
      <div class="col-lg-4 col-md-12 text-center">
         <div class="row">
            <div class="col-lg-12 col-md-6 col-sm-12">
               <img style="width:250px;margin-bottom:20px"
                  src="<?php echo base_url('assets/uploads/members_upload/' . $img); ?>" alt="IMG NOT FOUND!">
               <h3><?php echo $name; ?></h3>
               <h6><?php echo $name_en; ?></h6>
            </div>
            <div class="col-lg-12 col-md-6 col-sm-12">
               <?php if (!empty($getIssuesChoice)): ?>
               <div style="margin-top:40px" class="members-bar">關注議題</div>
               <?php endif;?>
               <nav class="members-issues">
                  <ul>
                     <?php if (!empty($getIssuesChoice)): ?>
                     <?php foreach ($getIssuesChoice as $item): ?>
                     <?php
$id   = $item->ic_id;
$name = $item->name;
?>
                     <li>
                        <a href="<?php echo base_url('fend/bill_f/' . $id); ?>"><?=$name;?></a>
                     </li>
                     <?php endforeach;?>
                     <?php endif;?>
                  </ul>
               </nav>
            </div>
         </div>
      </div>
      <div class="col-lg-8 col-md-12">
         <div class="members-bar">基本資料</div>
         <div class="member-inner-block">
            <div class="row">
               <div class="col-md-4">
                  <div class="list">學歷</div>
               </div>
               <div class="col-md-8">
                  <div class="content">
                     <pre class="experience"><?php echo $education; ?></pre>
                  </div>
               </div>
            </div>
         </div>
         <div class="member-inner-block">
            <div class="row">
               <div class="col-md-4">
                  <div class="list">經歷</div>
               </div>
               <div class="col-md-8">
                  <div class="content">
                     <!-- 斷行+去空白,若加上<div>會有空白 -->
                     <pre class="experience"><?php echo $experience; ?></pre>
                  </div>
               </div>
            </div>
         </div>
         <div class="member-inner-block">
            <div class="row">
               <div class="col-md-4">
                  <div class="list">分區/不分區</div>
               </div>
               <div class="col-md-8">
                  <div class="content"><?php echo $districts; ?></div>
               </div>
            </div>
         </div>
         <div class="member-inner-block">
            <div class="row">
               <div class="col-md-4">
                  <div class="list">各會期委員會</div>
               </div>
               <div class="col-md-8">
                  <div class="content">
                     <pre class="experience"><?php echo $education; ?></pre>
                  </div>
               </div>
            </div>
         </div>
         <div class="members-bar">聯絡方式</div>
         <?php if (!empty($getConID1)): ?>
         <div class="member-inner-block">
            <div class="row">
               <div class="col-md-4">
                  <div class="list">國會辦公室電話</div>
               </div>
               <div class="col-md-8">
                  <?php foreach ($getConID1 as $item): ?>
                  <a href="tel:<?php echo $item->records; ?>" class="content"><?php echo $item->records; ?></a>
                  <?php endforeach;?>
               </div>
            </div>
         </div>
         <?php endif;?>
         <?php if (!empty($getConID2)): ?>
         <div class="member-inner-block">
            <div class="row">
               <div class="col-md-4">
                  <div class="list">國會辦公室地址</div>
               </div>
               <div class="col-md-8">
                  <?php
foreach ($getConID2 as $item) {
    $r    = $item->records;
    $arr1 = explode('：', $r);
    $arr2 = explode('號', $arr1[1]);
    $map  = $arr2[0] . '號';
    ?>
                  <a class="content" href="https://www.google.com.tw/maps/place/<?php echo $map; ?>"
                     target="_blank"><?php echo $item->records; ?></a>
                  <?php }?>
               </div>
            </div>
         </div>
         <?php endif;?>
         <?php if (!empty($getConID3)): ?>
         <div class="member-inner-block">
            <div class="row">
               <div class="col-md-4">
                  <div class="list">國會辦公室傳真</div>
               </div>
               <div class="col-md-8">
                  <?php foreach ($getConID3 as $item): ?>
                  <div class="content"><?php echo $item->records; ?></div>
                  <?php endforeach;?>
               </div>
            </div>
         </div>
         <?php endif;?>
         <?php if (!empty($getConID4)): ?>
         <div class="member-inner-block">
            <div class="row">
               <div class="col-md-4">
                  <div class="list">國會辦公室信箱</div>
               </div>
               <div class="col-md-8">
                  <?php foreach ($getConID4 as $item): ?>
                  <a target="blank" href="mailto:<?php echo $item->records; ?>"
                     class="content"><?php echo $item->records; ?></a>
                  <?php endforeach;?>
               </div>
            </div>
         </div>
         <?php endif;?>
         <?php if (!empty($getConID5)): ?>
         <div class="member-inner-block">
            <div class="row">
               <div class="col-md-4">
                  <div class="list">個人網站</div>
               </div>
               <div class="col-md-8">
                  <?php foreach ($getConID5 as $item): ?>
                  <a target="blank" href="<?php echo $item->records; ?>"
                     class="content"><?php echo $item->records; ?></a>
                  <?php endforeach;?>
               </div>
            </div>
         </div>
         <?php endif;?>
         <?php if (!empty($fb && $ig && $line && $yt)): ?>
         <div class="member-inner-block">
            <div class="row">
               <div class="col-md-4">
                  <div class="list">社群連結</div>
               </div>
               <div class="col-md-8">
                  <div class="member-link">
                     <?php if (!empty($fb)): ?>
                     <a target="_blank" href="<?php echo $fb; ?>"><img
                           src="<?php echo base_url('assets/f_imgs/members/facebook.png'); ?>" alt="img not found"></a>
                     <?php endif;?>
                     <?php if (!empty($ig)): ?>
                     <a target="_blank" href="<?php echo $ig; ?>"><img
                           src="<?php echo base_url('assets/f_imgs/members/instagram.png'); ?>" alt="img not found"></a>
                     <?php endif;?>
                     <?php if (!empty($line)): ?>
                     <a target="_blank" href="<?php echo $line; ?>"><img
                           src="<?php echo base_url('assets/f_imgs/members/line.png'); ?>" alt="img not found"></a>
                     <?php endif;?>
                     <?php if (!empty($yt)): ?>
                     <a target="_blank" href="<?php echo $yt; ?>"><img
                           src="<?php echo base_url('assets/f_imgs/members/youtube.png'); ?>" alt="img not found"></a>
                     <?php endif;?>
                  </div>
               </div>
            </div>
         </div>
         <?php endif;?>
      </div>
      <!-- col-lg-8 -->
   </div>
</div>
<style>
</style>
<script>
</script>