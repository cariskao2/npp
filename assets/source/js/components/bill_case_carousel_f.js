// case-editor - swiper-pagination-bullet
$('.swiper-pagination-bullet').click(function () {
   let index = $(this).index();
   let caseId = $('.swiper-slide .case-id').eq(index).val();

   // console.log('index', index);
   // console.log('caseid', caseId);

   carouselAjax(caseId);
});

// case-editor - swiper-button
$('.swiper-button-next,.swiper-button-prev').click(function () {
   // let index = $('.swiper-slide-visible.swiper-slide-active.swiper-slide').index();
   let caseId = $('.swiper-slide-visible.swiper-slide-active .case-id').val();

   // console.log('index', index);
   // console.log('caseid', caseId);

   carouselAjax(caseId);
});

editorLenth(); // 一開始先判斷是否需要取代爲...

function carouselAjax(caseId) {
   let hitURL = baseURL + 'fend/bill_f/getBillCaseInfoAjax';

   $.ajax({
      url: hitURL,
      method: "POST",
      data: {
         caseId: caseId
      },
      success: function (res) {
         let docode = JSON.parse(res);

         $('.case-editor .content').html(docode.editor);
         $('.case-editor .content').removeClass('show');
         $('.file-url a').attr('href', docode.link);

         editorLenth();
      }
   })
}

function editorLenth() {
   var len = 200; // 超過len個字以"..."取代
   $('.case-editor .content').each(function () {
      if ($(this).text().length > len) {
         $(this).attr("title", $(this).text());
         var text = $(this).text().substring(0, len - 1) + '...';
         $(this).text(text);
         $('.open').css('display', 'block');
      } else {
         $('.open').css('display', 'none');
      }
   });
}

$('.open .open-img').click(function () {
   let text = $('.case-editor .content').attr('title');

   if (text != '') {
      $('.case-editor .content').text(text);
      $('.case-editor .content').addClass('show');
      $('.case-editor .content').attr('title', '');
   } else {
      let hasShow = $('.case-editor .content').hasClass('show');

      if (hasShow) {
         editorLenth();
         $('.case-editor .content').removeClass('show');
      }
   }
});

$(function () {
   // 屆期初始化
   let $this = $(this);
   let text = $this.find('option:selected').text();
   let _l = text.length;
   let _w = _l <= 7 ? 200 : _l * 27;
   // let _w = _l <= 7 ? 200 : _l < 20 ? _l * 10 : _l < 25 ? _l * 12 : _l * 15;

   $('#case-year-select').css('width', _w + 'px');
});

// 屆期
$(document).on('change', '#case-year-select', function () {
   let $this = $(this),
      text = $this.find('option:selected').text(),
      _l = text.length;

   let _w = _l <= 7 ? 200 : _l * 27;
   // let _w = _l <= 7 ? 200 : _l < 20 ? _l * 10 : _l < 25 ? _l * 12 : _l * 15;

   $('#case-year-select').css('width', _w + 'px');
   $('#yearSelectForm').submit();
});