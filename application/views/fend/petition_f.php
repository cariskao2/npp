<?php
$e = $getPetition->editor;
?>

<link rel="stylesheet" href="<?php echo base_url('assets/plugins/jquery-upload-file/dist/jquery-file-upload.css'); ?>">
<script src="<?php echo base_url('assets/plugins/jquery-upload-file/dist/jquery-file-upload.js'); ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.0.0/sweetalert2.all.js"></script>
<style>
   .g-recaptcha>div {
      margin: auto;
   }
</style>
<div class="breadcrumb-bg">
   <div class="container">
      <nav aria-label="breadcrumb">
         <ol class="breadcrumb">
            <li style="" class="breadcrumb-item"><a href="<?php echo base_url('fend/home'); ?>">首頁</a></li>
            <li style="" class="breadcrumb-item"><a href="<?php echo base_url('fend/bill_issues_f'); ?>">法案議題</a></li>
            <li style="" class="breadcrumb-item"><a
                  href="<?php echo base_url('fend/issues_f/issues_class_f'); ?>">關注議題</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?php echo $breadcrumbTag; ?></li>
         </ol>
      </nav>
   </div>
</div>
<div id="gotop">^</div>
<!-- <div id="loader">
   <div class="loader"></div>
</div> -->
<div class="container">
   <div class="row">
      <div class="col-md-12">
         <div class="form-title">陳情須知</div>
      </div>
      <div class="col-md-12"><?php echo $e; ?></div>
      <div class="col-md-12">
         <div class="form-title">陳情表單<span class="must">*為必填</span></div>
      </div>
      <div class="col-md-12">
         <form action="<?php echo base_url('fend/petition_f/emailSend'); ?>" method="post" enctype="multipart/form-data"
            class="petition-f" name="petition_form" id="petition_form">
            <div class="row">
               <div class="col-md-6">
                  <div class="form-group">
                     <label for="username" class="must">姓名</label>
                     <input type="text" class="form-control" id="username" name="username" value="" placeholder="請輸入姓名">
                  </div>
               </div>
               <div class="col-md-6">
                  <div class="form-group">
                     <label for="title" class="must">性別 (請讓我們知道後續聯絡時該如何稱呼您)</label><br>
                     <!-- Default inline 1-->
                     <div class="custom-control custom-radio custom-control-inline">
                        <input value="1" type="radio" class="custom-control-input" id="male" name="sex" checked>
                        <label class="custom-control-label" for="male">先生</label>
                     </div>

                     <!-- Default inline 2-->
                     <div class="custom-control custom-radio custom-control-inline">
                        <input value="0" type="radio" class="custom-control-input" id="female" name="sex">
                        <label class="custom-control-label" for="female">女士</label>
                     </div>

                     <!-- Default inline 3-->
                     <div class="custom-control custom-radio custom-control-inline">
                        <input value="2" type="radio" class="custom-control-input" id="other" name="sex">
                        <label class="custom-control-label" for="other">其它</label>
                     </div>
                  </div>
               </div>
               <div class="col-md-6">
                  <div class="form-group">
                     <label for="mail" class="must">聯絡信箱</label>
                     <input type="text" class="form-control" id="mail" name="mail" value=""
                        placeholder="例如 npp.ly@npptw.org">
                  </div>
               </div>
               <div class="col-md-6">
                  <div class="form-group">
                     <label for="phone" class="must">聯絡電話</label>
                     <input type="text" class="form-control" id="phone" name="phone" value="" placeholder="請輸入聯絡電話">
                  </div>
               </div>
               <div class="col-md-12">
                  <div class="form-group">
                     <label for="textarea" class="must">陳情內容</label>
                     <textarea class="form-control" name="textarea" id="textarea" rows="5" placeholder="請簡單描述您想要陳情的內容，例如，提供某個修法或政策的建議、告訴我們某件您在意並希望改善或處理的事情，若有相關連結也歡迎您附上。
最後請簡單描述您希望我們可以怎麼協助您，以讓我們更快進入狀況，非常感謝！"></textarea>
                  </div>
               </div>
               <div class="col-md-12">
                  <div class="form-group">
                     <div id="fileuploader">上傳檔案</div>
                  </div>
                  <p>*若您陳情的事項有相關文件或照片、圖片等，也歡迎您一併上傳提供。</p>
                  <p>*上傳檔案大小限制5MB(5000KB)。</p>
               </div>
               <div class="col-md-12">
                  <div class="g-recaptcha" data-sitekey="6LdY2vsUAAAAAC1ZvVjCrKlOMKo7qtrf15eBwlNI">
                  </div>
               </div>
               <div class="col-md-12">
                  <div class="form-group">
                     <input type="submit" class="form-control" value="送出陳情" style="background-color:#ffc107">
                     <input type="hidden" name="folder" value="" id="folder">
                  </div>
               </div>
            </div>
         </form>
      </div>
   </div>
</div>

<?php
$this->load->helper('form');
$check = $this->session->flashdata('petition_user');
if ($check) {
    echo '<script>swal("陳情內容已送出!");</script>';
}
?>
<script>
   function makeid(length) {
      var result = '';
      var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
      var charactersLength = characters.length;
      for (var i = 0; i < length; i++) {
         result += characters.charAt(Math.floor(Math.random() * charactersLength));
      }
      return result;
   }

   // sweetalert
   swal.setDefaults({
      confirmButtonText: "確定",
      cancelButtonText: "取消"
   });

   $(document).ready(function () {
      $("form[name=petition_form]").submit(function (ev) {
         if (grecaptcha.getResponse() != '') {
            return true;
         }

         swal('請勾選下方「我不是機器人」完成驗證作業，謝謝您的配合');
         return false;
      })

      // let arr = [];
      // let phone = '';
      let _random = makeid(30);
      $('#folder').val(_random);

      $("#fileuploader").uploadFile({
         url: baseURL + 'assets/plugins/jquery-upload-file/php/myUpload.php',
         fileName: 'myfile',
         // returnType: "json", //回傳JSON格式
         // showPreview: true, //能否預覽上傳圖片 預設FALSE
         previewHeight: '50px', //預覽圖片高度
         previewWidth: '50px', //預覽圖片寬度
         // allowedTypes: 'jpg,png,gif', //限制上傳的格式
         // statusBarWidth: 1000, //狀態欄寬 用於顯示上傳的圖片名稱+檔案大小
         maxFileSize: 5 * 1024 * 1024, //限制上傳檔案大小
         // maxFileCount: 1, //每次可上傳的檔案總數,也就是總共可以傳幾個
         multiple: false, //是否可多檔案上傳,也就是一次可以選幾個檔案上傳
         dragDrop: false, //是否可拖拉檔案,預設true
         showDelete: true, //是否顯示刪除鈕 預設FALSE
         fileCounterStyle: ' - ', // 顯示的格式
         uploadStr: '上傳檔案',
         abortStr: '終止',
         deleteStr: '刪除',
         dynamicFormData: function () {
            var data = {
               // phone: phone,
               _r: _random,
            }
            return data;
         },
         onSelect: function (files) {
            // let _size = files[0].size;
            // let _file = files[0].name;

            // phone = $('#phone').val();

            // if (phone == '') {
            //    $('#phone').parent('.form-group').addClass('has-error');
            //    document.petition_form.phone.focus();
            //    swal("聯絡電話不可空白", "上傳檔案前請先填入聯絡電話", "warning");

            //    return false;
            // } else {
            //    if (phone.length < 8) {
            //       $('#phone').parent('.form-group').addClass('has-error');
            //       document.petition_form.phone.focus();
            //       swal("聯絡電話位數錯誤", "電話號碼不可少於8位", "warning");

            //       return false;
            //    } else {
            //       if (isNaN(phone)) {
            //          $('#phone').parent('.form-group').addClass('has-error');
            //          document.petition_form.phone.focus();
            //          swal("電話需為數字");

            //          return false;
            //       } else {
            //          return true;
            //       }
            //    }
            // }
         },
         onSuccess: function (files, data, xhr, pd) {
            // console.log(files);
            // arr.push(files);
            // $('#hidden').val(arr);
         },
         //利用AJAX CALL 刪除的API 將檔名與OP送過去可處理
         deleteCallback: function (data, pd) {
            let img = data.replace('["', '');
            img = img.replace('"]', '');

            $.ajax({
               type: 'POST',
               url: baseURL + 'assets/plugins/jquery-upload-file/php/myDelete.php',
               data: {
                  // phone: phone
                  img: img,
                  _r: _random
               },
               dataType: 'JSON',
               success: function (response) {
                  // console.log('deleteCallback-response', response);
               }
            });
         },
         onSubmit: function (files, xhr) {
            // console.log('onSubmit');
         },
         onCancel: function (files, pd) {},
         onError: function (files, status, errMsg) {},
         afterUploadAll: function (e) {},
      });

      $.validator.setDefaults({
         errorClass: 'has-error',
         highlight: function (element) {
            // 在input加入form-group會有紅方框,但是error message也會有
            $(element).closest('.form-group').addClass('has-error');
         },
         unhighlight: function (element) {
            $(element).closest('.form-group').removeClass('has-error');
         },
      })

      $('#petition_form').validate({
         onkeyup: function (element, event) {
            //去除左側空白
            var value = this.elementValue(element).replace(/^\s+/g, "");
            $(element).val(value);
         },
         // 好像mail也是要加入
         rules: {
            mail: {
               required: true,
               email: true
            },
            username: {
               required: true,
            },
            phone: {
               required: true,
               number: true,
               minlength: 8,
            },
            textarea: 'required',
         },
         messages: {
            mail: {
               required: '必填',
               email: '請輸入有效的email'
            },
            username: {
               required: '必填',
            },
            phone: {
               required: '必填',
               number: '電話需為數字',
               minlength: '不得少於8位',
            },
            textarea: '必填',
         },
         // jquery驗證 & google驗證
         submitHandler: function (form) {
            if (grecaptcha.getResponse() == '') {
               swal('請勾選下方「我不是機器人」完成驗證作業，謝謝您的配合');
               return false;
            }

            swal('正在準備送出...');
            form.submit(); //没有這一句表單不會提交
         }
      });
   });
</script>