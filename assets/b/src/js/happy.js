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