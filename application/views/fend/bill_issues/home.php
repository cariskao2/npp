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
<div id="gotop">^</div>
<div id="loader"><div class="loader"></div></div>
<div class="container">
   <h3 class="bill-issues-title">關注議題</h3>
   <div class="issues-list-home">
      <div class="row">
         <?php
if (!empty($getIssuesClass)) {
    foreach ($getIssuesClass as $k => $v) {
        ?>
         <?php if ($k % 5 == 0): ?>
         <div class="col-md-8"><a href="<?php echo base_url('fend/Issues_f/issuesAllList_f/' . $v->ic_id . '/'); ?>"
               class="issues-<?php echo $k + 1; ?>">
               <h2><?php echo $v->name; ?></h2>
               <div class="mask"></div>
            </a></div>
         <?php elseif ($k % 5 == 1): ?>
         <div class="col-md-4"><a href="<?php echo base_url('fend/Issues_f/issuesAllList_f/' . $v->ic_id . '/'); ?>"
               class="issues-<?php echo $k + 1; ?>">
               <h2><?php echo $v->name; ?></h2>
               <div class="mask"></div>
            </a></div>
         <?php elseif ($k % 5 == 2): ?>
         <div class="col-md-3"><a href="<?php echo base_url('fend/Issues_f/issuesAllList_f/' . $v->ic_id . '/'); ?>"
               class="issues-<?php echo $k + 1; ?>">
               <h2><?php echo $v->name; ?></h2>
               <div class="mask"></div>
            </a></div>
         <?php elseif ($k % 5 == 3): ?>
         <div class="col-md-4"><a href="<?php echo base_url('fend/Issues_f/issuesAllList_f/' . $v->ic_id . '/'); ?>"
               class="issues-<?php echo $k + 1; ?>">
               <h2><?php echo $v->name; ?></h2>
               <div class="mask"></div>
            </a></div>
         <?php elseif ($k % 5 == 4): ?>
         <div class="col-md-5"><a href="<?php echo base_url('fend/Issues_f/issuesAllList_f/' . $v->ic_id . '/'); ?>"
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
   <div style="margin-top:30px" class="more"><a href="<?php echo base_url('fend/Issues_f/Issues_class_f/'); ?>">更多內容</a></div>
</div>
<style>
</style>
<script>
   $(function () {
      var _getIssuesClass = <?php echo json_encode($getIssuesClass); ?>;

      _getIssuesClass.forEach((v, k) => {
         $('.issues-' + (k + 1)).css('background-image', 'url(' + baseURL +
            'assets/uploads/issuesClass_uplaod/' + v.img + ')');
      });
   });
</script>