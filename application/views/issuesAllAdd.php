<div id="loader">
	<div class="loader"></div>
</div>
<div class="content-wrapper">
	<section>
		<div class="row">
			<!-- left column -->
			<div class="col-md-12">
				<!-- general form elements -->
				<div class="box box-primary" style="border:none;">
					<div class="add-edit-scroll">
						<!-- form start -->
						<!--  enctype="multipart/form-data"記得加 -->
						<form role="form" action="<?php echo base_url('issues/issuesAllAddSend'); ?>" method="post" id="formSubmit"
							role="form" enctype="multipart/form-data">
							<div class="box-body">
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label for="img" class="must">新增圖片<span style="color:red;">(僅支援 jpg、png、gif)</span></label>
											<input type="file" name="file" id="file" />
											<?php echo form_error('file'); ?>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label for="title" class="must">標題</label>
											<input type="text" class="form-control" id="title" name="title" value="">
											<?php echo form_error('title'); ?>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label for="ic" class="must">類別</label>
											<select name="ic" id="ic" class="form-control mb-3"
												style="padding-top:0;padding-bottom:0">
												<option value="0">請選擇類別</option>
												<?php
if (!empty($issuesClassSort)) {
    foreach ($issuesClassSort as $item) {
        ?>
												<option value="<?php echo $item->ic_id; ?>"><?php echo $item->name; ?></option>
												<?php
}
}
?>
											</select>
											<?php echo form_error('ic'); ?>
										</div>
									</div>
									<div class="col-md-2">
										<div class="form-group">
											<label for="">顯示狀態</label>
											<div class="input-group">
												<div id="radioBtn" class="btn-group">
													<a class="btn btn-primary btn-sm active" data-toggle="happy"
														data-title="Y">顯示</a>
													<a class="btn btn-primary btn-sm notActive" data-toggle="happy"
														data-title="N">隱藏</a>
												</div>
												<input type="hidden" name="happy" id="happy">
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label for="introduction">簡介</label>
											<input type="text" class="form-control" id="introduction" name="introduction" value="">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<label for="editor1">內文</label>
										<textarea name="editor1" id="editor1"></textarea>
										<script>
											CKEDITOR.replace("editor1", {
												filebrowserBrowseUrl: "<?php echo base_url('assets/plugins/ckeditor4/filemanager/dialog.php?type=2&editor=ckeditor&fldr='); ?>",
												filebrowserUploadUrl: "<?php echo base_url('assets/plugins/ckeditor4/filemanager/dialog.php?type=2&editor=ckeditor&fldr='); ?>",
												filebrowserImageBrowseUrl: "<?php echo base_url('assets/plugins/ckeditor4/filemanager/dialog.php?type=1&editor=ckeditor&fldr='); ?>",
												// width: 1000,
												height: 800,
												// language: '',
												toolbarCanCollapse: true, // ui可縮起來
											});
										</script>
									</div>
								</div>
							</div><!-- /.box-body -->
						</form>
					</div><!-- add-edit-scroll -->
				</div>
				<!-- box -->
			</div>
		</div>
		<!-- row -->
	</section>
</div>
<template id="function-on-top">
	<div class="function-on-top">
		<div class="box" style="border-top:none;border-radius:0">
			<div class="box-header">
				<div class="row">
					<div class="col-xs-12">
						<a class="btn btn-warning" href="<?php echo $this->session->userdata('myRedirect'); ?>">返回</a>
						<input type="submit" class="btn btn-success" value="儲存" onclick="subMit();" />
					</div>
				</div>
			</div>
		</div><!-- /.box-header -->
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
	<?php echo $check . '!<br>請修正以下提示錯誤!'; ?>
</div>
<?php
}
?>
<style>
</style>
<!-- <?php echo validation_errors('<div id="alert-error" class="alert-absoulte alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?> -->