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
   var _paginationFixed = $('#pagination-fixed .pagination').height(); //獲取下方分頁的高度(不含margin、padding、border)
   _paginationFixed = _paginationFixed != undefined ? _paginationFixed : 0; //若沒有分頁欄,高度就設爲0

   var _pageH = $(window).height(); //頁面總高度,不同於$(document).height()
   var _mainHeaderH = $('.main-header.header-fixex-top').height(); //頂部藍色標題欄高度
   var _funH = $('.function-on-top .box').height(); //上方黑色功能欄+列表標題欄高度
   var _footerH = $('.main-footer').height(); //若outerHeight(true)則含margin、padding、border

   // 計算要scroll的所需高度
   var _listScrollH = _pageH - _mainHeaderH - _funH - _paginationFixed - _footerH;
   var _sidebarH = _pageH - _mainHeaderH;
   var _notListHcontentScroll = _pageH - _mainHeaderH - _funH - _footerH;

   // 設定相關要scroll的高度
   $('.list-scroll').height(_listScrollH); //設定列表頁的高度
   $('section.sidebar').height(_sidebarH); //設定左方導航欄的高度
   $('.not-list-H-scroll').height(_notListHcontentScroll); //設定新增跟編輯長內容的高度

   // 下方分頁的高度若產生變化(分頁條變成二行),就自動調整高度使之顯示完整
   if (_paginationFixed != undefined && _paginationFixed > 40) {
      $('#pagination-fixed').height(68);
      $('.list-input-scroll').css({
         marginBottom: '92px',
      });
   }

   // console.log('_pageH', _pageH);
   // console.log('_funH', _funH);
   // console.log('_mainHeaderH', _mainHeaderH);
   // console.log('_footerH', _footerH);
   // console.log('_paginationFixed', _paginationFixed);
   // console.log('_listScrollH', _listScrollH);
}

// 各個無搜尋欄位的Lists分頁
function pagination(url) {
   // 以下爲enable_query_strings=false
   //如果不寫下面url這一行 將會取最後一個/前所有值
   // var url = link.substr(link.lastIndexOf('/', link.lastIndexOf('/') - 1) + 1); // 1/10
   // var site = url.lastIndexOf("\/"); //获取最后一个/的位置,1

   /**
    * 獲取最後一個「/」前面的值
    * http://www.w3school.com.cn/jsref/jsref_lastIndexOf.asp
    * lastIndexOf第二個參數:它的合法取值是 0 到 stringObject.length - 1。如省略该参数，则将从字符串的最后一个字符处开始检索。
    * substr(start,length)表示從start位置開始，擷取length長度的字串。
    * substring(start,end)表示從start到end之間的字串，包括start位置的字元但是不包括end位置的字元。
    *
    * 這行說明:
    * 第二個lastIndexOf因爲沒有第二個參數(看上方說明),所以直接從最後面開始找「/」,找到後再將位置-1就變成那段字串的length,也就是最後一個字。
    * 第一個lastIndexOf的第二個參數就是第二個lastIndexOf的結果-1,也代表第一個lastIndexOf會從倒數第二段字串的最後一個字元開始往回查詢,這樣就會避開了最後一個「/」,而搜索到倒數第二個「/」再+1獲取倒數第二個「/」後的全部字串。
    */
   jQuery('ul.pagination li a').click(function (e) {
      // 當點擊下方頁面時,就獲取以下資料並跳轉
      e.preventDefault();
      var link = jQuery(this).get(0).href;
      var value = link.substring(link.lastIndexOf('/') + 1);

      // attr,更改form中的action連結
      //注意如果controller使用index的話,這裡就要加上index
      // jQuery("#searchList").attr("action", baseURL + "news/lists/" + type_id + '/' + value);
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