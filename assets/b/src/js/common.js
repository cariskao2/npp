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
})

// window.onload = function () {}
let _h = $(window).height();
let _w = $(window).width();
let _sidebarH = 0; //左方導航高度
let _funH = 0; // 上方功能欄高度
let url = window.location.href;

// console.log('listinput', $('#list-input').length);
// console.log('pagina', $('#pagination-bottom').length);

if ($('#list-input').length > 0) {
   _sidebarH = _w > 767 ? _h - 50 : _h - 189;
   _funH = _w > 767 ? '54' : 89;
} else {
   if (url.indexOf('profile') > 0) {
      _sidebarH = _h - 100;
   } else {
      _sidebarH = _w > 767 ? _h - 50 : _h - 154;
   }

   if (url.indexOf('carouselLists') > 0) {
      _funH = _w > 767 ? 54 : 74;
   } else {
      _funH = 54;
   }
}

if (_w > 767) {
   $('#mobile-scroll-only').addClass('add-edit-noscroll');
   $('#mobile-scroll-only').removeClass('add-edit-scroll');
} else {
   $('#mobile-scroll-only').addClass('add-edit-scroll');
   $('#mobile-scroll-only').removeClass('add-edit-noscroll');
}

let _navbarH = _w > 767 ? 50 : 100; //上方藍色標題欄高度
let _titleH = 34;
let _paginationFixed = $('#pagination-bottom').length > 0 ? 34 : 0;
let _footerH = 24;

_paginationFixed = _paginationFixed != undefined ? _paginationFixed : 0; //若沒有分頁欄,高度就設爲0

let _listScrollH = _h - _navbarH - _funH - _titleH - _paginationFixed - _footerH;
let _addEditScroll = _h - _navbarH - _funH - _footerH;

$('.tbody-outside').height(_listScrollH); //設定列表頁的高度
$('section.sidebar').height(_sidebarH); //設定左方導航欄的高度
$('.add-edit-scroll').height(_addEditScroll); //設定add、edit without input 的高度

if (_w <= 767) {
   if (url.indexOf('profile') > 0) {
      $('aside.main-sidebar').css('top', 100); //設定左方導航欄的top
   } else {
      $('aside.main-sidebar').css('top', _navbarH + _funH); //設定左方導航欄的top
   }
}

// console.log('_h', _h);
// console.log('_navbarH', _navbarH);
// console.log('_funH', _funH);
// console.log('_paginationFixed', _paginationFixed);
// console.log('_listScrollH', _listScrollH);
// console.log('_addEditScroll', _addEditScroll);

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