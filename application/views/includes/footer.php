<footer class="main-footer text-center navbar-fixed-bottom footer-style">
	數位玩家資訊科技有限公司 高雄市楠梓區高雄大學路700號 07-5911329 服務時間：週一至週五 9：00 - 18：00 聯絡信箱：service@geekers.tw
</footer>
<style>
	.footer-style {
		padding: 2px;
		background-color: #222d32;
		color: white;
		border: none;
		white-space: nowrap;
	}
</style>
<script src="<?php echo base_url(); ?>assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/0.5.10/js/material.min.js"></script>
<script type="text/javascript" src="http://momentjs.com/downloads/moment-with-locales.min.js"></script>
<script
	src="<?php echo base_url('assets/plugins/bootstrap-material-design/js/bootstrap-material-datetimepicker.js'); ?>">
</script>
<script src="<?php echo base_url(); ?>assets/dist/js/adminlte.js" type="text/javascript"></script>
<!-- <script src="<?php echo base_url(); ?>assets/dist/js/pages/dashboard.js" type="text/javascript"></script> -->
<script src="<?php echo base_url(); ?>assets/b/build/js/all.js" type="text/javascript"></script>
<script type="text/javascript">
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
</script>
</body>

</html>