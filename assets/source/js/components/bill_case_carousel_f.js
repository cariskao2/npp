// must run at start
timeLine();
editorLenth(); // 一開始先判斷是否需要overflow hidden

function getBillCaseInfoAjax(caseId) {
   let hitURL = baseURL + 'fend/bill_f/getBillCaseInfoAjax';

   $.ajax({
      url: hitURL,
      method: "POST",
      data: {
         caseId: caseId
      },
      success: function (res) {
         let decode = JSON.parse(res);

         $('.case-editor .content').html(decode.editor);
         $('.case-editor .content').removeClass('show');
         $('.file-url a').attr('href', decode.link);

         editorLenth();
      }
   })
}

function getBCSesAndInfoAjax(caseId) {
   let hitURL = baseURL + 'fend/bill_f/getBCSesAndInfoAjax';

   $.ajax({
      url: hitURL,
      method: "POST",
      data: {
         caseId: caseId
      },
      success: function (res) {
         $('.dark .time-line').empty();

         let decode = JSON.parse(res);
         let _ses = new Array();
         let _info = new Array();
         // console.log('decode', decode);

         // 獲取所有ses_id & name
         decode.forEach((item) => {
            _ses.push(item.ses);
         });

         // 獲取所有info(若用filter會存入符合條件的全部DOM,不能指定info)
         decode.forEach((item, j) => {
            let itemLen = item.info.length; //獲取每個索引中,info的長度
            // console.log(itemLen);

            for (let i = 0; i < itemLen; i++) {
               _info.push(item.info[i]); //將原本二維的info陣列改成一維陣列存放
            }
         });
         // console.log('info', _info);

         var _createDOM = '';
         var noteImgURL = baseURL + 'assets/f_imgs/billCaseCarousel/note.png';
         var videoImgURL = baseURL + 'assets/f_imgs/billCaseCarousel/draft_youtube.png';

         if (decode.length > 0) {
            _ses.forEach((item, i) => {
               _createDOM += '<div class="time-line-block"><div class="time-line-session">' + item.ses_name + '</div><div class="time-line-info">';

               _info.forEach((ele, j) => {
                  // console.log('item', item.ses_id);
                  // console.log('ele', ele.id);
                  if (item.ses_id === ele.id) {
                     _createDOM += '<div class="line-info">';
                     _createDOM += '<span class="line"></span>';
                     _createDOM += '<span class="info-date">' + ele.date.replace(/-/g, '.') + '</span>';
                     _createDOM += '<span class="info-dot"></span>';
                     _createDOM += '<span class="info-title">' + ele.title + '</span>';
                     _createDOM += '<span class="info-board-icon"><img src="' + noteImgURL + '" alt="not found!"><input type="hidden" name="board-hide" class="board-hide" value="' + ele.content + '"></span>';

                     if (ele.url != '') {
                        _createDOM += '<a class="info-video-icon" target="_blank" href="' + ele.url + '"><img src="' + videoImgURL + '" alt="not found!"></a>';
                     }

                     _createDOM += '</div>';
                  }
               });

               _createDOM += '</div></div>';
            });
         } else {
            _createDOM += '<p class="no-category-match">此法案尚未建立任何立法程序</p>';
         }

         $('.dark .time-line').append(_createDOM);
         timeLine();
      }
   })
}

// 布告欄
function editorLenth() {
   var len = 230; // 超過len個字以"..."取代

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

// 布告欄上、下箭頭
$('.open .open-img').click(function () {
   let text = $('.case-editor .content').attr('title');

   if (text != '') {
      $('.case-editor .content').text(text);
      $('.case-editor .content').attr('title', '');
      $('.case-editor .content').addClass('show');
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

// 立法程序各會期草案黑點之間的直線設定
function timeLine() {
   if ($('.time-line-block').length > 0) {
      var _offset = (24 - 5) / 2 //24:dot的寬度,5:直線寬度,/2後置中
      var dotX = $('.info-dot:first').position().left; //獲取圓點相對父元素的X偏移量(.time-line有設定relative)
      var dot1Y = $('.info-dot:first').position().top; //獲取1st圓點的相對父元素Y偏移量
      var dot2Y = $('.info-dot:last').position().top; //獲取last一個圓點的相對父元素Y偏移量
      var _distance = (dot2Y - dot1Y); //獲取直線的總長度(高)

      dotX += _offset; //調整X偏移量到圓點中央

      $('.time-line-info .line').css({
         'height': _distance,
         'top': dot1Y + _offset,
         'left': dotX
      });
   }
}