<?php
$mail        = $getSetupInfo->mail;
$fb          = $getSetupInfo->fb;
$address     = $getSetupInfo->address;
$num         = $getSetupInfo->num;
$fax         = $getSetupInfo->fax;
$servicetime = $getSetupInfo->servicetime;
?>
<footer class="container-fluid container-footer_style">
	<div class="row">
		<div class="col-lg-6 col-md-12">
			<div class="hvcenter-flexbox">
				<main>
					<a class="logo logo-footer_center" href="#"><img src="<?php echo base_url(); ?>assets/f_imgs/header/LY-logo.svg" alt="圖片不存在"></a>
					<address>
						<div><span>地址 </span><a target="blank" href="https://www.google.com.tw/maps/place/%E7%AB%8B%E6%B3%95%E9%99%A2%E9%9D%92%E5%B3%B6%E4%B8%89%E9%A4%A8/@25.0442613,121.5205838,19z/data=!3m1!4b1!4m5!3m4!1s0x3442a971746339c3:0x841664d7ac9478bc!8m2!3d25.0442613!4d121.521131">100台北市中正區青島東路1-3號2樓</a></div>
						<div><span>信箱 </span><a target="blank" href="mailto:<?php echo $mail; ?>"><?php echo $mail; ?></a></div>
						<div><span>電話 </span><a target="blank" href="tel:<?php echo $num; ?>"><?php echo $num; ?></a></div>
						<div><span>傳真 </span><?php echo $fax; ?></div>
						<div><span>服務時間 </span><?php echo $servicetime; ?></div>
					</address>
				</main>
			</div>
		</div>
		<div class="col-lg-6 col-md-12">
			<div class="hvcenter-flexbox">
				<main class="iframe">
					<div class="f-footer_bg">
						<img src="<?php echo base_url('assets/f_imgs/footer/f_footer_bg.png'); ?>" alt="找不到圖片">
						<div class="linear-gd child" style="z-index:1"></div>
						<a style="z-index:2" class="child child-bg" href="<?php echo $fb; ?>" target="_blank">
							<img style="border: 2px solid white;" src="<?php echo base_url('assets/f_imgs/footer/f_footer_logo.png'); ?>" alt="找不到圖片">
						</a>
						<a class="child child-bg" href="<?php echo $fb; ?>" target="_blank" style="z-index:2;width:100%">
							<h6 class="child child-title">時代力量立法院黨團</h6>
						</a>
						<iframe class="child" style="border: none; overflow: hidden;z-index:2;width:150px;left:200px;top:100px" src="https://www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2Fnpp.2016ly%2F&width=450&layout=button_count&action=like&size=small&show_faces=true&share=true&height=80&appId" width="450" height="80" frameborder="0" scrolling="no"></iframe>
					</div>
				</main>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12 f-footer_under">
			時代力量 New Power Party © 2019 All Rights Reserved
		</div>
	</div>
</footer>

<script src="<?php echo base_url(); ?>assets/js/jquery.validate-1.17.1-pre.js" type="text/javascript"></script>
<!-- 前台使用舊版會error -->
<!-- <script src="<?php echo base_url(); ?>assets/js/jquery.validate.js" type="text/javascript"></script> -->
<script src="<?php echo base_url(); ?>assets/public/js/all.js" type="text/javascript"></script>
<script type="text/javascript">
	var windowURL = window.location.href;
	pageURL = windowURL.substring(0, windowURL.lastIndexOf('/'));
	var x = $('a[href="' + pageURL + '"]');
	x.addClass('active');
	x.parent().addClass('active');
	var y = $('a[href="' + windowURL + '"]');
	y.addClass('active');
	y.parent().addClass('active');
</script>
</body>

</html>