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
}) //$(function () {}

window.onload = function () {
   // 下方分頁的高度若產生變化(分頁條變成二行),就自動調整高度使之顯示完整
   var _paginationFixed = $('#pagination-fixed .pagination').height();

   if (_paginationFixed != undefined && _paginationFixed > 40) {
      $('#pagination-fixed').height(68);
      $('.list-input-scroll').css({
         marginBottom: '92px',
      });
   }

   //計算出列表頁右邊列表項目跟左邊導航的高度
   var _pageH = $(window).height(); //頁面總高度
   // var _pageH2 = $(document).height(); //頁面總高度
   // var _funoH = $('.function-on-top.not-list').outerHeight(true); //上方黑色導航欄+列表標題欄高度+margin-top(也就是上方藍色導航欄高度)
   var _mainHeaderH = $('.main-header.header-fixex-top').height(); //上方藍色導航欄高度
   var _funH = $('.function-on-top .box').height(); //上方黑色導航欄+列表標題欄高度
   var _footerH = $('.main-footer').outerHeight(true); //含margin、padding、border

   var _paginationFixed = _paginationFixed != undefined ? _paginationFixed : 0; //這裡不行用let宣告
   var _listScrollH = _pageH - _mainHeaderH - _funH - _paginationFixed - _footerH;
   var _listScrollH = _funH > 110 ? _listScrollH : _listScrollH + 3; //這裡不行用let宣告

   $('.list-scroll').height(_listScrollH); //自動依照頁面高度算出右邊列表項目含input的list-input-scroll高度

   var _sidebarH = _pageH - _mainHeaderH;
   $('section.sidebar').height(_sidebarH); //自動依照頁面高度算出左邊列表項目section.sidebar的高度

   var _notListHcontentScroll = _pageH - _mainHeaderH - _funH - _footerH;
   $('.not-list-H-content-scroll').height(_notListHcontentScroll); //自動依照頁面高度算出長內容的新增編輯頁面高度

   console.log('_pageH', _pageH);
   console.log('_funH', _funH);
   console.log('_mainHeaderH', _mainHeaderH);
   console.log('_footerH', _footerH);
   console.log('_paginationFixed', _paginationFixed);
   console.log('_listScrollH', _listScrollH);
}

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