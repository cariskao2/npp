var getTemplate = function () {
   var html = $('template.temp').html();
   // return $(html).clone();
   return html;
}

var temp = getTemplate();

// on在動態新增DOM後還是可以獲取DOM,但click只有一開始頁面載入完成那次才獲取得到
$(document).on("click", '.btnRemove', function () {
   var currentRow = $(this);
   currentRow.closest('.contact-item').remove();
});

$('.btnAdd').click(function () {
   $('#contact-table tbody').append(temp);
});