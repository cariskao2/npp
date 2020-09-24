var a = $('.main-sidebar .sidebar-menu .treeview>a');
var aText = $('.main-sidebar .sidebar-menu .treeview>a:not(.people)');
var _toggle = $('.main-header .navbar .sidebar-toggle');
var sm = $('.sidebar-menu');

// 左方導航欄游標設定
sm.click(function () {
   let ww = $(window).width();
   let smw = sm.width();

   if (ww > 767 && smw == 50) {
      aText.css('cursor', 'text');
      setTimeout(sidebarMenuToggle, 100);
   }
});

// logo旁的3橫線按鈕
_toggle.click(function () {
   let ww = $(window).width();
   let smw = sm.width();

   // console.log(ww);
   // console.log(smw);

   if (ww > 767 && smw != 50) {
      a.css('cursor', 'pointer');
      sm.addClass('sidebar-toggle');
      sm.attr({
         'data-toggle': 'push-menu',
         'role': 'button'
      });
   } else {
      aText.css('cursor', 'text');
      setTimeout(sidebarMenuToggle, 100);
   }
});

function sidebarMenuToggle() {
   sm.removeAttr('data-toggle role');
   sm.removeClass('sidebar-toggle');
}
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

// 上方功能欄temp
var getFuncTemp = function () {
   var funcTemp = $('template#function-on-top').html();
   // return $(html).clone();
   return funcTemp;
}
var _getFuncTemp = getFuncTemp();

$('.main-header .navbar').append(_getFuncTemp);