$(function () {
   // 清除icon
   $('.input-group .input-group-addon').click(function () {
      $(this).prev().val('');
   });

   $('#date_start,#date_end').bootstrapMaterialDatePicker({
      time: false,
      format: 'YYYY-MM-DD',
      lang: 'zh-tw',
      clearButton: true,
      nowButton: true,
      cancelText: '取消',
      clearText: '清除',
      nowText: '今天',
      okText: '完成',
      weekStart: 0,
   });

   $('#date_start').bootstrapMaterialDatePicker({}).on('change', function (e, date) {
      $('#date_end').bootstrapMaterialDatePicker('setMinDate', date);
   });

   $('#date_end').bootstrapMaterialDatePicker({}).on('change', function (e, date) {
      $('#date_start').bootstrapMaterialDatePicker('setMaxDate', date);
   });
})
// 起始到結束之間的日期計算
// var _dateFrom = '';
// var _tDayTimestamp = Date.parse(new Date());
// console.log(_tDayTimestamp);
// _dateFromTimestamp = Date.parse(dateText);
// console.log(_dateFromTimestamp);
// var _count = parseInt((_tDayTimestamp - _dateFromTimestamp) / (1000 * 60 * 60 * 24));
// console.log(_count);