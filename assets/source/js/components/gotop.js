jQuery(document).ready(function () {
   // gotop
   $(window).scroll(function () {
      if ($(this).scrollTop() > 750) {
         $('#gotop').fadeIn("fast");
      } else {
         $('#gotop').fadeOut("fast");
      }
   });

   if ($(this).scrollTop() > 750) {
      $('#gotop').fadeIn("fast");
   } else {
      $('#gotop').fadeOut("fast");
   }

   $("#gotop").click(function () {
      $("html,body").animate({
         scrollTop: 0
      }, 750);
   });
});