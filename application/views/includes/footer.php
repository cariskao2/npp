<footer class="main-footer text-center">
	數位玩家資訊科技有限公司 高雄市楠梓區高雄大學路700號 07-5911329 服務時間：週一至週五 9：00 - 18：00 聯絡信箱：service@geekers.tw
</footer>
<script src="<?php echo base_url(); ?>assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/dist/js/adminlte.js" type="text/javascript"></script>
<!-- <script src="<?php echo base_url(); ?>assets/dist/js/pages/dashboard.js" type="text/javascript"></script> -->
<script src="<?php echo base_url(); ?>assets/b/build/js/all.js" type="text/javascript"></script>

<script type="text/javascript">
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

	// 無內頁時的側邊欄導航active
	var windowURL = window.location.href;
	var _activeLeftnav = $('a[href="' + windowURL + '"]');
	_activeLeftnav.addClass('active');
	_activeLeftnav.parent().addClass('active');
	_activeLeftnav.parents('.treeview').addClass('active');

	// 進入內頁或下方分頁,側邊欄導航也會active
	var _navPath = "<?php if (!empty($navActive)) {echo $navActive;}?>";
	// console.log(_navPath);
	var _navActive = $('a[href="' + _navPath + '"]');
	var _myParent = _navActive.parents('.treeview');
	_myParent.addClass('active');
	_myParent.find('a[href="' + _navPath + '"]').addClass('active');
	_myParent.find('a[href="' + _navPath + '"]').parent().addClass('active');

	$(document).ready(function () {
		// 偵測瀏覽器
		var explorer = navigator.userAgent;
		var _brower = false;

		if (explorer.indexOf("Firefox") >= 0) {
			// console.log("Firefox");
			_brower = true;
		} else if (explorer.indexOf("Chrome") >= 0) {
			// console.log("Chrome & Opera");
		} else if (explorer.indexOf("Safari") >= 0) {
			// console.log("Safari");
			_brower = true;
		}

		var _isPhone = false;

		$('.sidebar-toggle').click(function () {
			if (_brower) {
				if (!_isPhone) {
					$('.functoin-on-top').css('left', '50px');
					_isPhone = true;
				} else {
					$('.functoin-on-top').css('left', '230px');
					_isPhone = false;
				}
			}
			setTimeout(function () {
				var w = $('.sidebar-menu').width();
				// alert(w);
				if (w <= 50) {
					$('.skin-blue .sidebar-menu .treeview-menu>li').css('padding-left', '0');
					$('.treeview>a').css('cursor', 'pointer');
				} else {
					$('.skin-blue .sidebar-menu .treeview-menu>li').css('padding-left', '30px');
					$('.treeview>a').css('cursor', 'text');
				}
			}, 500);
		});
	});
</script>
</body>

</html>