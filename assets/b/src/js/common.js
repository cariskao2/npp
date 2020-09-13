$(function () {
   $('#loader').hide(0);

   // 訊息彈出3秒後消失
   setTimeout(function () {
      $("#alert-success").hide();
   }, 3000);
   setTimeout(function () {
      $("#alert-error").hide();
   }, 3000);

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

window.onload = function () {
   var explorer = navigator.userAgent; // 偵測瀏覽器

   //outerHeight(true)：包含margin、padding、border
   var _paginationFixed = $('#pagination-fixed .pagination').outerHeight(true); //獲取下方分頁的高度
   _paginationFixed = _paginationFixed != undefined ? _paginationFixed : 0; //若沒有分頁欄,高度就設爲0

   var _pageH = $(window).height(); //頁面總高度,不同於$(document).height()
   var _mainHeaderH = $('.main-header.header-fixex-top').outerHeight(true); //頂部藍色標題欄高度
   var _funH = $('.function-on-top .box').outerHeight(true); //上方黑色功能欄+列表標題欄高度
   var _footerH = $('.main-footer').outerHeight(true);

   // 計算要scroll的所需高度
   var _listScrollH = _pageH - _mainHeaderH - _funH - _paginationFixed - _footerH;

   if (explorer.indexOf("Firefox") >= 0) {
      _listScrollH += 2;
   }
   var _sidebarH = _pageH - _mainHeaderH - 10;
   var _notListHcontentScroll = _pageH - _mainHeaderH - _funH - _footerH;

   // 設定相關要scroll的高度
   $('.list-scroll').height(_listScrollH); //設定列表頁的高度
   $('section.sidebar').height(_sidebarH); //設定左方導航欄的高度
   $('.not-list-H-scroll').height(_notListHcontentScroll); //設定新增跟編輯長內容的高度

   // 下方分頁的高度若產生變化(分頁條變成二行),就自動調整高度使之顯示完整
   if (_paginationFixed != undefined && _paginationFixed > 40) {
      $('#pagination-fixed').height(68);
      $('#pagination-fixed').css({
         bottom: '-68px',
      });
   }

   // console.log('_pageH', _pageH);
   // console.log('_funH', _funH);
   // console.log('_mainHeaderH', _mainHeaderH);
   // console.log('_footerH', _footerH);
   // console.log('_paginationFixed', _paginationFixed);
   // console.log('_listScrollH', _listScrollH);
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