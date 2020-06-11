<?php
$id      = $getInnerInfo->pr_id;
$type_id = $getInnerInfo->pr_type_id;
$img     = $getInnerInfo->img;
$m_title = $getInnerInfo->main_title;
$s_title = $getInnerInfo->sub_title;
$date    = $getInnerInfo->date_start;
$e       = $getInnerInfo->editor;

$prev = !empty($innerPrevNews) ? $innerPrevNews->pr_id : '';
$next = !empty($innerNextNews) ? $innerNextNews->pr_id : '';
?>
<div class="breadcrumb-bg">
	<div class="container">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li style="" class="breadcrumb-item"><a href="<?php echo base_url('fend/home'); ?>">首頁</a></li>
				<li style="" class="breadcrumb-item"><a href="<?php echo base_url('fend/news_f'); ?>">新聞訊息</a></li>
				<li style="" class="breadcrumb-item"><a
						href="<?php echo base_url('fend/news_f/newsFlists/' . $type_id); ?>"><?php echo $breadcrumbTag; ?></a>
				</li>
				<!-- 讓連結不會出現藍字 -->
				<li style="display:none" class="breadcrumb-item active" aria-current="page"></a></li>
			</ol>
		</nav>
	</div>
</div>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="inner-title" style="margin-top:30px;margin-bottom:30px">
				<h3><?php echo $m_title; ?></h3>
				<h5 style="margin-top:20px"><?php echo $s_title; ?></h5>
			</div>
		</div>
		<div class="col-md-12">
			<div class="inner-share">
				<span style="font-size:14px;font-weight:bold">發布時間：<?php echo $date; ?></span>
				<!-- 社群分享列 -->
				<div class="share-buttons">
					<!-- addthis -->
					<div class="addthis_inline_share_toolbox"></div>
					<!-- copythis -->
					<a class="copy-hover" href="javascript:void(0)" onclick="CopyTextToClipboard('copythis')">
						<img alt="Share" src="<?php echo base_url('assets/f_imgs/'); ?>share_icon_grey.svg" />
					</a>
					<div id="copythis"></div>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<img style="width:100%" src="<?php echo base_url('assets/uploads/news_upload/' . $type_id . '/' . $img); ?>"
				alt="img not found">
		</div>
		<div class="col-md-12">
			<div class="e">
				<?php echo $e; ?>
			</div>
		</div>
		<div class="col-md-12">
			<nav class="newsInner-tags">
				<ul>
					<?php if (!empty($getTagsChoice)): ?>
					<li class="img"><img src="<?php echo base_url('assets/f_imgs/tag.png'); ?>" alt=""></li>
					<?php foreach ($getTagsChoice as $item): ?>
					<li><a href="<?php echo base_url('fend/news_f/tagsList/' . $item->tags_id); ?>"><?=$item->name?></a></li>
					<?php endforeach;?>
					<?php endif;?>
				</ul>
			</nav>
		</div>
	</div>
	<nav class="newsInner-pagination">
		<ul>
			<?php if ($prev != ''): ?>
			<li class="newsInner-prev"><a
					href="<?php echo base_url('fend/news_f/newsInner/' . $type_id . '/' . $prev); ?>">上一則</a></li>
			<?php endif;?>
			<li class="newsInner-list"><a href="<?php echo base_url('fend/news_f/newsFlists/' . $type_id); ?>">回列表</a></li>
			<?php if ($next != ''): ?>
			<li class="newsInner-next"><a
					href="<?php echo base_url('fend/news_f/newsInner/' . $type_id . '/' . $next); ?>">下一則</a></li>
			<?php endif;?>
		</ul>
	</nav>
</div>
<div id="gotop">^</div>
<div id="loader"><div class="loader"></div></div>
<script type="text/javascript">
	function CopyTextToClipboard(id) {
		document.getElementById(id).style.display = "inline-block";
		document.getElementById(id).innerHTML = location.href;

		var TextRange = document.createRange();
		TextRange.selectNode(document.getElementById(id));

		sel = window.getSelection();
		sel.removeAllRanges();
		sel.addRange(TextRange);

		document.execCommand("copy");
		document.getElementById(id).style.display = "none";

		alert("網址複製完成！");
	}
</script>
<!-- addthis分享列 -->
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5e4611d57249fac6"></script>