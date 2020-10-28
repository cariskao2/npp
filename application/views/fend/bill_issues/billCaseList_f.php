<div class="breadcrumb-bg">
	<div class="container">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="<?php echo base_url('fend/home'); ?>">首頁</a></li>
				<li class="breadcrumb-item"><a href="<?php echo base_url('fend/bill_issues_f'); ?>">法案議題</a>
				<li class="breadcrumb-item active" aria-current="page">提出法案列表</li>
			</ol>
		</nav>
	</div>
</div>
<div class="container" style="margin-bottom:20px">
	<div class="row" style="border-bottom: solid 1px gray;">
		<div class="col-md-12">
			<div class="home-title_style">提出法案列表</div>
		</div>
	</div>
</div>
<div class="container custom-gutters" style="margin-bottom:20px">
	<table class="table bill-case-list-f">
		<thead>
			<tr>
				<th>法案名稱</th>
				<th>法案狀態</th>
				<th>相關連結</th>
			</tr>
		</thead>
		<tbody>
		<?php
if (!empty($getBillCaseList)) {
    foreach ($getBillCaseList as $item) {
        $gory_id = $item->gory_id;
        ?>
			<tr>
				<td><?php echo $item->titlename; ?></td>
				<td><?php echo $item->name; ?></td>
				<td><a href="<?php echo base_url('fend/bill_f/billCaseCarousel/' . $gory_id); ?>"><img style="width:30px;" src="<?php echo base_url('assets/f_imgs/bill_issues/link2.png'); ?>" alt="無此圖片"></a></td>
			</tr>
         <?php
}
}
?>
		</tbody>
	</table>
</div>
<?php echo $this->pagination->create_links(); ?>
</div>
<div id="gotop">⬆</div>
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
<style>
</style>