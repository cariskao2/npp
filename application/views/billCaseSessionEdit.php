<?php
$id          = $getBillCaseSessionInfo->id;
$case_id     = $getBillCaseSessionInfo->case_id;
$ses_id      = $getBillCaseSessionInfo->ses_id;
$show        = $getBillCaseSessionInfo->showups;
$date        = $getBillCaseSessionInfo->date;
$description = $getBillCaseSessionInfo->description;
$title       = $getBillCaseSessionInfo->title;
$editor      = $getBillCaseSessionInfo->content;
$url         = $getBillCaseSessionInfo->url;
?>
<div class="content-wrapper">
	<section>
		<div class="row">
			<!-- left column -->
			<div class="col-md-12">
				<!-- general form elements -->
				<div class="box box-primary" style="border:none;">
					<div class="add-edit-scroll">
						<!-- form start -->
						<form role="form"
							action="<?php echo base_url('bills/billCaseSessionEditSend/' . $case_id . '/' . $id); ?>"
							method="post" id="formSubmit" role="form">
							<div class="box-body">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label for="sessions" class="must">會期</label>
											<select style="padding-top:0;padding-bottom:0" class="form-control" id=""
												name="sessions" placeholder="請選擇會期">
												<?php
if (!empty($getBillCaseSessionSelect)) {
    foreach ($getBillCaseSessionSelect as $item) {
        ?>
												<option value="<?php echo $item->ses_id; ?>"
													<?php if ($item->ses_id == $ses_id) {echo 'selected';}?>>
													<?php echo $item->session; ?>
												</option>
												<?php
}
}
?>
											</select>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="date_start" class="must">日期</label>
											<input type="text" class="form-control" id="date_start" name="date_start" value="<?php echo $date; ?>">
											<?php echo form_error('date_start'); ?>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label for="description" class="must">議事事件描述</label>
											<input type="text" class="form-control" id="description" name="description" value="<?php echo $description; ?>">
											<?php echo form_error('description'); ?>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="title" class="must">事件描述標題</label>
											<input type="text" class="form-control" id="title" name="title" value="<?php echo $title; ?>">
											<?php echo form_error('title'); ?>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label for="url">影音連結</label>
											<input type="text" class="form-control" id="url" name="url" value="<?php echo $url; ?>">
											<?php echo form_error('url'); ?>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="">顯示狀態</label>
											<div class="input-group">
												<div id="radioBtn" class="btn-group">
												<?php
$active    = $show == 1 ? 'active' : 'notActive';
$notActive = $show == 0 ? 'active' : 'notActive';
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
									<div class="col-md-12">
										<div class="form-group">
											<label for="editor1" class="must">事件描述的內容</label>
											<?php echo form_error('editor1'); ?>
											<textarea name="editor1" id="editor1"><?php echo $editor; ?></textarea>
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
										</div>
									</div>
								</div>
							</div><!-- /.box-body -->
						</form>
					</div><!-- add-edit-noscroll -->
				</div><!-- .box -->
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
							<a class="btn btn-warning" href="<?php echo $this->session->userdata('sessionRedirect'); ?>">返回</a>
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
<style>
	.error-width {
		width: 150px;
	}

	@font-face {
		font-family: Material-Design-Icons;
		src: url("<?php echo base_url('assets/plugins/bootstrap-material-design/font/Material-Design-Icons.ttf'); ?>");
	}
</style>
<!-- <?php echo validation_errors('<div id="alert-error" class="alert-absoulte alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?> -->