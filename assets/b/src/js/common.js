$(function () {
   $('#loader').hide(0);

   // 訊息彈出3秒後消失
   setTimeout(function () {
      $("#alert-success").hide();
   }, 3000);
   setTimeout(function () {
      $("#alert-error").hide();
   }, 3000);

   // 底部footer依照容量多寡會跑版的解決方案
   var $h = $('.content-wrapper section').height();
   // console.log('h', $h);
   if ($h > 950) {
      $h += 50;
      // console.log('h2', $h);
      $('.content-wrapper').css('height', $h);
   } else {
      $('.content-wrapper').css('height', '95vh');
   }

   // 清除日期或時間
   $('.input-group .input-group-addon').click(function () {
      $(this).prev().val('');
   });

   // JQuery UI datepicker
   $.datepicker.regional['zh-TW'] = {
      dayNames: ["星期日", "星期一", "星期二", "星期三", "星期四", "星期五", "星期六"],
      dayNamesMin: ["日", "一", "二", "三", "四", "五", "六"],
      monthNames: ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"],
      monthNamesShort: ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"],
      prevText: "上月",
      nextText: "次月",
      weekHeader: "週",
      currentText: "今天",
      closeText: "關閉"
   };

   $.datepicker.setDefaults($.datepicker.regional["zh-TW"]);

   $('#date_start').datepicker({
      showButtonPanel: true,
      dateFormat: 'yy-mm-dd',
      showMonthAfterYear: true,
   });
   // $('#date_end').datepicker({
   //    showButtonPanel: true,
   //    dateFormat: 'yy-mm-dd',
   //    showMonthAfterYear: true,
   // });
})

// 各個Lists分頁
function pagination(url) {
   jQuery('ul.pagination li a').click(function (e) {
      // 當點擊下方頁面時,就獲取以下資料並跳轉
      e.preventDefault();
      var link = jQuery(this).get(0).href;
      var value = link.substring(link.lastIndexOf('/') + 1);
      // console.log('link', link);
      jQuery("#searchList").attr("action", baseURL + url + value);
      jQuery("#searchList").submit();
   });
}

// 顯示狀態
$('#radioBtn a').on('click', function () {
   var sel = $(this).data('title');
   var tog = $(this).data('toggle');
   // console.log('sel', sel);
   // console.log('tog', tog);
   $('#' + tog).prop('value', sel); //將該被點擊的data-title值寫入到id="happy"的value中。

   // 當點擊爲Y,就把不爲Y的元素移除active並加上notActive
   $('a[data-toggle="' + tog + '"]').not('[data-title="' + sel + '"]').removeClass('active').addClass(
      'notActive');
   // 當點擊爲Y,就把爲Y的元素移除notActive並加上active
   $('a[data-toggle="' + tog + '"][data-title="' + sel + '"]').removeClass('notActive').addClass('active');
})