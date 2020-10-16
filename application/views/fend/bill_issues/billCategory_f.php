<div class="breadcrumb-bg">
   <div class="container">
      <nav aria-label="breadcrumb">
         <ol class="breadcrumb">
            <li style="" class="breadcrumb-item"><a href="<?php echo base_url('fend/home'); ?>">首頁</a>
            </li>
            <li style="" class="breadcrumb-item"><a href="<?php echo base_url('fend/bill_issues_f'); ?>">法案議題</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">重點法案</li>
         </ol>
      </nav>
   </div>
</div>
<div id="gotop">⬆</div>
<div id="loader"><div class="loader"></div></div>
<div class="container">
   <h3 class="bill-issues-title">重點法案</h3>
   <div class="issues-list-home">
      <div class="row">
         <?php
if (!empty($getBillCategory)) {
    foreach ($getBillCategory as $k => $v) {
        ?>
         <?php if ($k % 5 == 0): ?>
         <div class="col-md-8"><a href="<?php echo base_url('fend/issues_f/issuesAllList_f/' . $v->gory_id . '/'); ?>"
               class="category-<?php echo $k + 1; ?>">
               <h2><?php echo $v->title; ?></h2>
               <div class="mask"></div>
            </a></div>
         <?php elseif ($k % 5 == 1): ?>
         <div class="col-md-4"><a href="<?php echo base_url('fend/Issues_f/issuesAllList_f/' . $v->gory_id . '/'); ?>"
               class="category-<?php echo $k + 1; ?>">
               <h2><?php echo $v->title; ?></h2>
               <div class="mask"></div>
            </a></div>
         <?php elseif ($k % 5 == 2): ?>
         <div class="col-md-3"><a href="<?php echo base_url('fend/Issues_f/issuesAllList_f/' . $v->gory_id . '/'); ?>"
               class="category-<?php echo $k + 1; ?>">
               <h2><?php echo $v->title; ?></h2>
               <div class="mask"></div>
            </a></div>
         <?php elseif ($k % 5 == 3): ?>
         <div class="col-md-4"><a href="<?php echo base_url('fend/Issues_f/issuesAllList_f/' . $v->gory_id . '/'); ?>"
               class="category-<?php echo $k + 1; ?>">
               <h2><?php echo $v->title; ?></h2>
               <div class="mask"></div>
            </a></div>
         <?php elseif ($k % 5 == 4): ?>
         <div class="col-md-5"><a href="<?php echo base_url('fend/Issues_f/issuesAllList_f/' . $v->gory_id . '/'); ?>"
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
</div>
<style>
</style>
<script>
   $(function () {
      var _getBillCategory = <?php echo json_encode($getBillCategory); ?>;

      _getBillCategory.forEach((v, k) => {
         $('.category-' + (k + 1)).css('background-image', 'url(' + baseURL +
            'assets/uploads/bill_category/' + v.img + ')');
      });
   });
</script>