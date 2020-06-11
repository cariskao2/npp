<div class="breadcrumb-bg">
   <div class="container">
      <nav aria-label="breadcrumb">
         <ol class="breadcrumb">
            <li style="" class="breadcrumb-item"><a href="<?php echo base_url('fend/home'); ?>">首頁</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">本黨立委</li>
         </ol>
      </nav>
   </div>
</div>
<div id="gotop">^</div>
<div id="loader">
   <div class="loader"></div>
</div>
<div class="container">
   <select name="" id="year-select" class="form-control mb-3 pretty-select">
      <?php
if (!empty($getYearsList)) {
    foreach ($getYearsList as $item) {
        ?>
      <option value="<?php echo $item->yid; ?>"><?php echo $item->title; ?></option>
      <?php
}
}
?>
   </select>
   <div id="year-show"></div>
   <!-- members-info -->
   <div class="row mt-5" id="member-info"></div>
</div>
<style>
</style>
<script>
   // select
   $(function () {
      let $this = $(this),
         text = $this.find('option:selected').text(),
         hitURL = baseURL + 'fend/members_f/',
         _l = text.length,
         yid = $('#year-select :selected').val()

      let _w = _l <= 7 ? 200 : _l * 27;

      $('#year-select').css('width', _w + 'px');

      // memberinfo
      $.ajax({
         url: hitURL + 'getYearMembers',
         method: "POST",
         data: {
            yid: yid
         },
         success: function (res) {
            $('#member-info').html(res);
         }
      })

      // date
      $.ajax({
         url: hitURL + 'dateShow',
         method: "POST",
         data: {
            yid: yid
         },
         success: function (res) {
            // console.log(res)
            $('#year-show').html(res);
         }
      })
   });

   $(document).on('change', '#year-select', function () {
      let $this = $(this),
         hitURL = baseURL + 'fend/members_f/',
         text = $this.find('option:selected').text(),
         _l = text.length,
         yid = $('#year-select :selected').val(); //注意:selected前面有個空格！

      let _w = _l <= 7 ? 200 : _l * 27;
      $('#year-select').css('width', _w + 'px');

      // memberinfo
      $.ajax({
         url: hitURL + 'getYearMembers',
         method: "POST",
         data: {
            yid: yid
         },
         success: function (res) {
            $('#member-info').html(res);
         }
      })

      // date
      $.ajax({
         url: hitURL + 'dateShow',
         method: "POST",
         data: {
            yid: yid
         },
         success: function (res) {
            // console.log(res)
            $('#year-show').html(res);
         }
      })
   });
</script>