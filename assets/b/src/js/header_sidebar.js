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

// 列表title欄
var getTableHeaderTemp = function () {
   var tableHeaderTemp = $('template#table-header-temp').html();
   // return $(html).clone();
   return tableHeaderTemp;
}

var _getTableHeaderTemp = getTableHeaderTemp();

$('.main-header .navbar').append(_getTableHeaderTemp);

$(document).ready(function () {
   var explorer = navigator.userAgent; // 偵測瀏覽器
   // console.log(explorer);

   if (explorer.indexOf("Firefox") >= 0) {
      $('.sidebar-toggle').click(function () {
         // functionOnTop();
         sidebarToggle();
      });
   } else if (explorer.indexOf("Chrome") >= 0) {
      $('.sidebar-toggle').click(function () {
         sidebarToggle();
      });
   } else if (explorer.indexOf("Safari") >= 0) {
      $('.sidebar-toggle').click(function () {
         // functionOnTop();
         sidebarToggle();
      });
   }
});

var checkFunctionOnTop = true;
var _browserW = $(window).width();

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

// 左方導航欄游標設定
function sidebarToggle() {
   var w = $('.sidebar-menu').width();
   var _bW = $(window).width();

   if (_bW > 767) {
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
}

a.click(function () {
   var w = $('.sidebar-menu').width();
   var explorer = navigator.userAgent; // 偵測瀏覽器

   checkFunctionOnTop = true

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