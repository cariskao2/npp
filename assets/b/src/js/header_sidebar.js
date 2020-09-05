// 上方導航標題置中
var $titleTop = $('.nav.navbar-nav li.title-on-top');
var $halfWidth = $titleTop.width() / 2;
// console.log('$halfWidth', $halfWidth);

//這裏要取得跟我們設定position的相反值才能獲取,這裏設爲right,所以要log出的值爲left
// console.log($titleTop.position().left);//但是這一行得不到我們要的值,只是說明一下
$titleTop.css({
   right: 'calc(50% - ' + $halfWidth + 'px)', //記得「-」號右邊要空一格
   position: 'absolute'
});

$(document).ready(function () {
   var explorer = navigator.userAgent; // 偵測瀏覽器

   if (explorer.indexOf("Firefox") >= 0) {
      // console.log("Firefox");
      $('.sidebar-toggle').click(function () {
         functionOnTop();
         sidebarToggle();
      });
   } else if (explorer.indexOf("Chrome") >= 0) {
      // console.log("Chrome & Opera");
      $('.sidebar-toggle').click(function () {
         sidebarToggle();
      });
   } else if (explorer.indexOf("Safari") >= 0) {
      $('.box .box-body').removeClass('list-scroll'); //在mobile時的列表才不會出現一條直的黑線
      // console.log("Safari");

      $('.sidebar-toggle').click(function () {
         functionOnTop();
         sidebarToggle();
         paginationFixed();
      });
   }
});

var checkFunctionOnTop = true;
var _paginationFixed = true;
var _browserW = $(window).width();

function paginationFixed() {
   if (_browserW > 767) {
      if (_paginationFixed) {
         $('.pagination-fixed').css('left', '50px');
         _paginationFixed = !_paginationFixed;
      } else {
         $('.pagination-fixed').css('left', '230px');
         _paginationFixed = !_paginationFixed;
      }
   }
}

function functionOnTop() {
   if (_browserW > 767) {
      if (checkFunctionOnTop) {
         $('.function-on-top').css('left', '50px');
         checkFunctionOnTop = !checkFunctionOnTop;
      } else {
         $('.function-on-top').css('left', '230px');
         checkFunctionOnTop = !checkFunctionOnTop;
      }
   }
}

var a = $('.main-sidebar .sidebar-menu .treeview>a');

function sidebarToggle() {
   var w = $('.sidebar-menu').width();

   if (w != 50) {
      a.css('cursor', 'pointer');
      a.attr({
         'data-toggle': 'push-menu',
         'role': 'button'
      });
      a.addClass('sidebar-toggle');
   } else {
      $('.main-sidebar .sidebar-menu .treeview>a:not(.people)').css('cursor', 'text');
      a.removeAttr('data-toggle role');
      a.removeClass('sidebar-toggle');
   }
}

a.click(function () {
   var w = $('.sidebar-menu').width();
   var explorer = navigator.userAgent; // 偵測瀏覽器

   checkFunctionOnTop = true
   _paginationFixed = true

   if (w != 50) {
      a.removeAttr('data-toggle role');
      a.removeClass('sidebar-toggle');
   } else {

      if (explorer.indexOf("Chrome") < 0) {
         $('.function-on-top').css('left', '230px');
      }
      if (explorer.indexOf("Safari") >= 0) {
         $('.pagination-fixed').css('left', '230px');
      }

      $('.main-sidebar .sidebar-menu .treeview>a:not(.people)').css('cursor', 'text');
   }
});