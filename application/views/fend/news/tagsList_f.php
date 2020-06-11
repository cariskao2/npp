<div class="breadcrumb-bg">
	<div class="container">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li style="" class="breadcrumb-item"><a href="<?php echo base_url('fend/home'); ?>">首頁</a></li>
				<li style="" class="breadcrumb-item"><a href="<?php echo base_url('fend/news_f'); ?>">新聞訊息</a></li>
				<li class="breadcrumb-item active" aria-current="page"><?php echo $breadcrumbTag; ?></li>
			</ol>
		</nav>
	</div>
</div>
<div class="container" style="margin-bottom:20px">
	<div class="row" style="border-bottom: solid 1px gray;">
		<div class="col-md-12">
			<div class="newsTags-title"><span><?php echo $breadcrumbTag; ?></span></div>
		</div>
	</div>
</div>
<div class="container" style="margin-bottom:20px">
	<div class="row" style="margin-bottom:50px">
		<?php if (!empty($tagsList)): ?>
		<?php foreach ($tagsList as $item): ?>
		<div class="col-md-12">
			<a href="<?php echo base_url('fend/news_f/newsInner/' . $item->pr_type_id . '/' . $item->pr_id); ?>"
				class="tags-block">
				<h5><?=$item->main_title;?></h5>
				<span>發布時間：<?=$item->date_start;?></span>
				<div class="content"><?=mb_strimwidth(strip_tags($item->editor), 0, 200, '...');?></div>
			</a>
		</div>
		<?php endforeach;?>
		<?php endif;?>
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