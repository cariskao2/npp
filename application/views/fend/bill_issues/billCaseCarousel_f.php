<div class="breadcrumb-bg">
   <div class="container">
      <nav aria-label="breadcrumb">
         <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url('fend/home'); ?>">首頁</a></li>
            <li class="breadcrumb-item"><a href="<?php echo base_url('fend/bill_issues_f'); ?>">法案議題</a>
            <li class="breadcrumb-item"><a href="<?php echo base_url('fend/bill_f/billCategoryList_f'); ?>">重點法案</a>
            <li class="breadcrumb-item active" aria-current="page"><?=$getCateGoryTitle;?></li>
         </ol>
      </nav>
   </div>
</div>
<div id="gotop">⬆</div>
<div id="loader">
   <div class="loader"></div>
</div>
<div class="container">
   <div style="text-align:center;margin-top:30px;margin-bottom:-10px"><h3><?=$getCateGoryTitle;?></h3></div>
   <form action="<?php echo base_url('fend/bill_f/billCaseCarousel'); ?>" method="post" id="yearSelectForm">
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
<style>
</style>
<script>
   $(function () {
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