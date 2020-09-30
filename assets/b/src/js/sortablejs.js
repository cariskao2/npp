$('.ui-state-default').mouseover(function () {
   $(this).css({
      'opacity': .7,
   });
});

$('.ui-state-default').mouseout(function () {
   $(this).css({
      'opacity': 1,
   });
});

function sortJS(obj) {
   var url = obj.url;
   var who = obj.who;
   var redirect = obj.redirect;
   // console.log(url);
   // console.log(who);
   // console.log(redirect);

   var _sort = new Array();
   var hitURL = baseURL + url;

   $(".ui-state-default").each(function () {
      _sort.push($(this).attr('dbid'));
   });
   // console.log(_sort);

   $.ajax({
      type: "POST",
      url: hitURL,
      dataType: "text",
      data: {
         newSort: _sort,
         who: who
      },
      success: function (data) {
         // console.log('ok');
         // 這裡如果在controller導引的話會吃不到成功訊息。
         window.location.href = baseURL + redirect;
      },
      error: function (jqXHR) {
         console.log('發生錯誤: ', jqXHR.status);
      }
   })
}