<div id="loader">
	<div class="loader"></div>
</div>
<!-- bootstrap-clockpicker -->
<link rel="stylesheet" href="<?php echo base_url('assets/plugins/clockpicker/css/bootstrap-clockpicker.css'); ?>">
<script src="<?php echo base_url('assets/plugins/clockpicker/js/bootstrap-clockpicker.js'); ?>"></script>
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
						<form role="form" action="<?php echo base_url('news/addsSend/' . $type_id); ?>" method="post"
							id="formSubmit" role="form" enctype="multipart/form-data">
							<div class="box-body">
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label for="img" class="must">新增圖片<span style="color:red;">(僅支援
													jpg、png、gif)</span></label>
											<input type="file" name="file" />
											<?php echo form_error('file'); ?>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label for="m_title" class="must">大標</label>
											<input type="text" class="form-control" id="m_title" name="m_title" value="">
											<?php echo form_error('m_title'); ?>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label for="s_title">次標</label>
											<input type="text" class="form-control" id="s_title" name="s_title" value="">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label for="select-tools">標籤</label>
											<!-- name記得加上[],才能以陣列形式回傳 -->
											<select id="select-tools" name="tags[]" placeholder="請選取標籤">
												<option value="">請選取標籤</option>
												<?php
if (!empty($getTagsList)) {
    foreach ($getTagsList as $record) {
        ?>
												<option value="<?php echo $record->tags_id; ?>"><?php echo $record->name; ?>
												</option>
												<?php
}
}
?>
											</select>
										</div>
									</div>
									<div class="col-md-2">
										<div class="form-group">
											<label for="date_start">發布日期</label>
											<div class="input-group">
												<input type="text" class="form-control" id="date_start" name="date_start"
													placeholder="選擇日期" autocomplete="off" readonly>
												<span class="input-group-addon" title="清除">
													<span class="glyphicon glyphicon-remove"></span>
												</span>
											</div>
										</div>
									</div>
									<div class="col-md-2">
										<div class="form-group">
											<label for="time_start">發布時間</label>
											<div class="input-group">
												<input type="text" class="form-control" id="time_start" name="time_start"
													placeholder="選擇時間" autocomplete="off" readonly>
												<span class="input-group-addon" title="清除">
													<span class="glyphicon glyphicon-remove"></span>
												</span>
											</div>
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
				</div><!-- box -->
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
<script language='javascript' type='text/javascript'>
	function subMit() {
		jQuery('#formSubmit').submit();
	}

	$('#time_start').clockpicker();

	// 標籤
	$('#select-tools').selectize({
		maxItems: 5,
		plugins: ['remove_button'],
		sortField: { //排序
			field: 'id', // text:依據文本排序，id：依據value排序
			direction: 'asc' // 升序降序
		}
	});

	// console.log($('link:last-of-type').attr('href'));
	// console.log($('link:last-child').attr('href'));
	// console.log($('link:last').attr('href'));
	// console.log($('link').last().attr('href'));
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
	@font-face {
		font-family: Material-Design-Icons;
		src: url("<?php echo base_url('assets/plugins/bootstrap-material-design/font/Material-Design-Icons.ttf'); ?>");
	}
</style>
<!-- <?php echo validation_errors('<div id="alert-error" class="alert-absoulte alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?> -->