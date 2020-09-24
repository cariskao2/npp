<?php
$id           = $getCarouselInfo->id;
$showup       = $getCarouselInfo->showup;
$img          = $getCarouselInfo->img;
$title        = $getCarouselInfo->title;
$introduction = $getCarouselInfo->introduction;
$link         = $getCarouselInfo->link;
?>
<div class="content-wrapper">
	<section>
		<div class="row">
			<!-- left column -->
			<div class="col-md-12">
				<!-- general form elements -->
				<div class="box box-primary" style="border:none;">
					<div class="" id="mobile-scroll-only">
						<!--  enctype="multipart/form-data"記得加 -->
						<form role="form" action="<?php echo base_url('website/carouselEditSend/' . $id); ?>" method="post"
							id="formSubmit" role="form" enctype="multipart/form-data">
							<div class="box-body">
								<div class="row">
									<div class="col-md-6 col-xs-12">
										<div class="form-group">
											<img style="width:300px"
												src="<?php echo base_url('assets/uploads/carousel_upload/' . $img); ?>">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label for="img" class="must">更換圖片<span style="color:red;">(僅支援 jpg、png、gif)</span></label>
											<input id="img" type="file" name="file" size="20" />
											<?php echo form_error('file'); ?>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label for="title" class="must">標題</label>
											<input type="text" class="form-control" id="title" name="title"
												value="<?php echo $title; ?>">
											<?php echo form_error('title'); ?>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-2">
										<div class="form-group">
											<label for="">顯示狀態</label>
											<div class="input-group">
												<div id="radioBtn" class="btn-group">
													<?php
$active    = $showup == 1 ? 'active' : 'notActive';
$notActive = $showup == 0 ? 'active' : 'notActive';
?>
													<a class="btn btn-primary btn-sm <?php echo $active; ?>" data-toggle="happy"
														data-title="Y">顯示</a>
													<a class="btn btn-primary btn-sm <?php echo $notActive; ?>" data-toggle="happy"
														data-title="N">隱藏</a>
												</div>
												<input type="hidden" name="happy" id="happy">
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label for="introduction">簡介</label>
											<textarea class="form-control" name="introduction" id="introduction" cols="30"
												rows="5"><?php echo $introduction; ?></textarea>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label for="link">連結</label>
											<input type="text" class="form-control" id="link" name="link"
												value="<?php echo $link; ?>">
											<?php echo form_error('link'); ?>
										</div>
									</div>
								</div>
							</div><!-- /.box-body -->
						</form>
					</div><!-- add-edit-noscroll -->
				</div>
			</div>
		</div>
	</section>
</div>
<template id="function-on-top">
	<div class="function-on-top">
		<div class="box" style="border-top:none;border-radius:0">
			<div class="box-header">
				<div class="row">
					<div class="col-xs-12">
						<div class="form-group">
							<a class="btn btn-warning" href="<?php echo $this->session->userdata('myRedirect'); ?>">返回</a>
							<input type="submit" class="btn btn-success" value="儲存" onclick="subMit();" />
						</div>
					</div>
				</div>
			</div><!-- /.box-header -->
		</div>
	</div>
</template>
<script>
	function subMit() {
		jQuery('#formSubmit').submit();
	}
</script>
<?php
$check = $this->session->flashdata('check');
if ($check) {
    ?>
<div id="alert-error" class="alert-absoulte error-width alert alert-danger alert-dismissable">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	<?php echo $check; ?>
</div>
<?php
}
?>
<?php
$success = $this->session->flashdata('success');
if ($success) {
    ?>
<div id="alert-success" class="alert-absoulte success-width alert alert-success alert-dismissable">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	<?php echo $success; ?>
</div>
<?php
}
?>
<style>
	.error-width {
		width: 150px;
	}
</style>
<!-- <?php echo validation_errors('<div id="alert-error" class="alert-absoulte alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?> -->