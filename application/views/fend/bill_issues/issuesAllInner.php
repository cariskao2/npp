<?php
$ia_id        = $getIssuesAllInnerInfo->ia_id;
$ic_id        = $getIssuesAllInnerInfo->ic_id;
$img          = $getIssuesAllInnerInfo->img;
$title        = $getIssuesAllInnerInfo->title;
$introduction = $getIssuesAllInnerInfo->introduction;
$e            = $getIssuesAllInnerInfo->editor;
$name         = $getIssuesAllInnerInfo->name;
?>
<div class="breadcrumb-bg">
	<div class="container">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li style="" class="breadcrumb-item"><a href="<?php echo base_url('fend/home'); ?>">首頁</a></li>
				<li style="" class="breadcrumb-item"><a href="<?php echo base_url('fend/bill_issues_f'); ?>">法案議題</a></li>
				<li style="" class="breadcrumb-item"><a
						href="<?php echo base_url('fend/issues_f/issues_class_f'); ?>">關注議題</a></li>
				<li style="" class="breadcrumb-item"><a
						href="<?php echo base_url('fend/issues_f/issuesAllList_f/' . $ic_id); ?>"><?php echo $name; ?></a></li>
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
				<h3><?php echo $title; ?></h3>
				<h5 style="margin-top:20px"><?php echo $introduction; ?></h5>
			</div>
		</div>
		<div class="col-md-12">
			<img style="width:100%" src="<?php echo base_url('assets/uploads/issuesAll_uplaod/' . $img); ?>"
				alt="img not found">
		</div>
		<div class="col-md-12">
			<div class="e">
				<?php echo $e; ?>
			</div>
		</div>
	</div>
</div>
<div id="gotop">^</div>
<div id="loader">
	<div class="loader"></div>
</div>