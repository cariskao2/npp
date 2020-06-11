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
<div class="container" style="margin-bottom:20px">
	<div class="row" style="border-bottom: solid 1px gray;">
		<div class="col-md-12">
			<div class="home-title_style"><?php echo $breadcrumbTag; ?></div>
		</div>
	</div>
</div>
<div class="container custom-gutters" style="margin-bottom:20px">
	<div class="row" style="border-bottom:solid 1px gray;margin-bottom:50px;padding-bottom:50px">
		<?php
if (!empty($issuesAllList)) {
    foreach ($issuesAllList as $record) {
        $ia_id        = $record->ia_id;
        $ic_id        = $record->ic_id;
        $img          = $record->img;
        $title        = $record->title;
        $introduction = $record->introduction;
        $e            = $record->editor;
        $name         = $record->name;
        ?>
		<div class="col-lg-4 col-md-6">
			<a href="<?php echo base_url('fend/issues_f/issuesAllInner_f/' . $ia_id); ?>" class="newsBlock_style"
				style="border-radius:0">
				<div class="card mb-4 box-shadow" style="border-radius:0">
					<img class="card-img-top" src="<?php echo base_url('assets/uploads/issuesAll_uplaod/' . $img); ?>"
						alt="Card image cap" style="border-radius:0">
					<div class="card-body">
						<h5><?php echo mb_strimwidth(strip_tags($title), 0, 40, '...'); ?></h5>
						<span class="data-start_fontsize">類別：<?php echo $name; ?></span>
						<p><?php echo mb_strimwidth(strip_tags($e), 0, 100, '...'); ?></p>
					</div>
				</div>
			</a>
		</div>
		<?php
}
}
?>
	</div>
</div>
<?php echo $this->pagination->create_links(); ?>
</div>
<div id="gotop">^</div>
<script type="text/javascript">
	jQuery(document).ready(function () {
		// RWD來更改分頁文本
		var w = $(window).width();
		// console.log(w); //獲取刷新後的值
		if (w < 992) {
			$('.first-page a').text('<<');
			$('.last-page a').text('>>');
			$('.prev-page a').text('<');
			$('.next-page a').text('>');
		}
		$(window).resize(function () {
			var rw = $(window).width();
			// console.log(rw); //獲取解析度變動後的值
			if (rw < 992) {
				$('.first-page a').text('<<');
				$('.last-page a').text('>>');
				$('.prev-page a').text('<');
				$('.next-page a').text('>');
			} else {
				$('.first-page a').text('最新文章');
				$('.last-page a').text('最舊文章');
				$('.prev-page a').text('前一頁');
				$('.next-page a').text('下一頁');
			}
		});
	});
</script>