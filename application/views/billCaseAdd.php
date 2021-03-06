<script src="<?php echo base_url('assets/plugins/selectizejs/dist/js/standalone/selectize.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/selectizejs/js/index.js'); ?>"></script>
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
						<form role="form" action="<?php echo base_url('bills/billCaseAddSend'); ?>" method="post" id="formSubmit"
							role="form" enctype="multipart/form-data">
							<!-- box-body padding:0 here only -->
							<div class="box-body" style="padding:0">
								<table class="table table-bordered">
									<thead>
										<tr>
											<th colspan="2" scope="col">資料設定</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<th scope="row">
												<span class="must">*</span>類別
											</th>
											<td>
												<select style="padding-top:0;padding-bottom:0" class="form-control" id=""
													name="category" placeholder="請選擇類別">
													<?php
if (!empty($getBillCategory)) {
    foreach ($getBillCategory as $items) {
        ?>
													<option value="<?php echo $items->sort; ?>">
														<?php echo $items->title; ?>
													</option>
													<?php
}
}
?>
												</select>
												<?php echo form_error('category'); ?>
											</td>
										</tr>
										<tr>
											<th scope="row">
												<span class="must">*</span>屆期
											</th>
											<td>
												<div class="form-group">
													<!-- name記得加上[],才能以陣列形式回傳 -->
													<select id="select-years" name="years[]" placeholder="請選擇屆期">
														<option value="">請選擇屆期</option>
														<?php
if (!empty($getYearsList)) {
    foreach ($getYearsList as $items) {
        ?>
														<option value="<?php echo $items->sort; ?>">
															<?php echo $items->title; ?>
														</option>
														<?php
}
}
?>
													</select>
													<?php echo form_error('years'); ?>
												</div>
											</td>
										</tr>
										<tr>
											<th scope="row">
												<span class="must">*</span>標題
											</th>
											<td>
												<div class="form-group">
													<input type="text" class="form-control" id="titlename" name="titlename" value="">
													<?php echo form_error('titlename'); ?>
												</div>
											</td>
										</tr>
										<tr>
											<th scope="row">
												<span class="must">*</span>簡介
											</th>
											<td>
												<div class="form-group">
													<input type="text" class="form-control" id="introduction" name="introduction"
														value="">
													<?php echo form_error('introduction'); ?>
												</div>
											</td>
										</tr>
										<tr>
											<th scope="row">
												狀態
											</th>
											<td>
												<select style="padding-top:0;padding-bottom:0" class="form-control" id=""
													name="status" placeholder="請選擇狀態">
													<?php
if (!empty($getBillStatus)) {
    foreach ($getBillStatus as $items) {
        ?>
													<option value="<?php echo $items->status_id; ?>">
														<?php echo $items->name; ?>
													</option>
													<?php
}
}
?>
												</select>
												<?php echo form_error('status'); ?>
											</td>
										</tr>
										<tr>
											<th scope="row">
												外部連結
											</th>
											<td>
												<div class="form-group">
													<input type="text" class="form-control" id="link" name="link" value="">
													<?php echo form_error('link'); ?>
												</div>
											</td>
										</tr>
										<tr>
											<th scope="row">
												內容
											</th>
											<td>
												<textarea class="form-control" name="editor1" id="editor1"></textarea>
												<script>
													CKEDITOR.replace("editor1", {
														filebrowserBrowseUrl: "<?php echo base_url('assets/plugins/ckeditor4/filemanager/dialog.php?type=2&editor=ckeditor&fldr='); ?>",
														filebrowserUploadUrl: "<?php echo base_url('assets/plugins/ckeditor4/filemanager/dialog.php?type=2&editor=ckeditor&fldr='); ?>",
														filebrowserImageBrowseUrl: "<?php echo base_url('assets/plugins/ckeditor4/filemanager/dialog.php?type=1&editor=ckeditor&fldr='); ?>",
														// width: '100%',
														height: 500,
														// language: '',
														toolbarCanCollapse: true, // ui可縮起來
													});
												</script>
											</td>
										</tr>
									</tbody>
								</table>
							</div><!-- /.box-body -->
						</form>
					</div>
					<!-- add-edit-scroll -->
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

	$('#select-years').selectize({
		maxItems: null,
		plugins: ['remove_button'],
		sortField: { //排序
			field: 'id', // text:依據文本排序，id：依據value排序
			direction: 'asc' // 升序降序
		}
	});
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
<?php
$error = $this->session->flashdata('error');
if ($error) {
    ?>
<div id="alert-error" class="alert-absoulte error-width alert alert-danger alert-dismissable">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	<?php echo $error; ?>
</div>
<?php
}
?>
<style>
	.selectize-dropdown{
		top:35px !important;
	}

	.table.table-bordered tbody th {
		width: 10%;
	}
</style>
<!-- <?php echo validation_errors('<div id="alert-error" class="alert-absoulte alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?> -->