$(function () {
   $('#loader').hide(0);

   // 訊息彈出3秒後消失
   setTimeout(function () {
      $("#alert-success").hide();
   }, 3000);
   setTimeout(function () {
      $("#alert-error").hide();
   }, 3000);
});

// window.onload = function () {}
let _h = $(window).height();
let _w = $(window).width();
let _sidebarH = 0; //左方導航高度
let _funH = 0; // 上方功能欄高度
let url = window.location.href;

if ($('#list-input').length > 0) {
   if ($('.thead-has-select').length > 0) {
      _funH = _w > 767 ? '54' : 118;
   } else {
      _funH = _w > 767 ? '54' : 86;
   }
   _sidebarH = _w > 767 ? _h - 50 : _h - 189;
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
// console.log('listinput', $('#list-input').length);
// console.log('pagina', $('#pagination-bottom').length);