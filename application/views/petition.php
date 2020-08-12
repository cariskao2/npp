<?php
$editor = $getPetition->editor;
?>

<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<!-- <section class="content-header"> -->
	<section>
		<h1>網站管理 - 其它設定</h1>
	</section>
	<div class="function-on-top">
		<div class="row">
			<div class="col-xs-12">
				<div class="box" style="border-top:none;border-radius:0">
					<div class="box-header">
						<div class="row">
							<div class="col-xs-12">
								<div class="form-group">
									<a class="btn btn-warning" style="visibility:hidden"
										href="<?php echo base_url($this->session->userdata('myRedirect')); ?>">返回</a>
									<!-- <a class="btn btn-warning" onclick="history.back()" href="#">返回</a> -->
								</div>
							</div>
						</div>
					</div><!-- /.box-header -->
				</div>
			</div>
		</div>
	</div>
	<div class="div-setup-h"></div>
	<!-- 後臺灰色底色 -->
	<section class="content" style="background:#ECF0F5">
		<div class="row">
			<!-- left column -->
			<div class="col-md-12">
				<!-- general form elements -->

				<div class="box box-primary">
					<div class="box-header">
						<!-- <h3 class="box-title">編輯委員資料</h3> -->
					</div><!-- /.box-header -->
					<!-- form start -->

					<!--  enctype="multipart/form-data"記得加 -->
					<form role="form" action="<?php echo base_url('website/petitionSend') ?>" method="post"
						id="legislatorEditPage" role="form" enctype="multipart/form-data">
						<div class="box-body">
							<div class="row">
								<div class="col-md-12 contact">
									<label for="editor1">內文</label>
									<textarea name="editor1" id="editor1"><?php echo $editor; ?></textarea>
									<script>
										CKEDITOR.replace("editor1", {
											filebrowserBrowseUrl: "<?php echo base_url('assets/plugins/ckeditor4/filemanager/dialog.php?type=2&editor=ckeditor&fldr='); ?>",
											filebrowserUploadUrl: "<?php echo base_url('assets/plugins/ckeditor4/filemanager/dialog.php?type=2&editor=ckeditor&fldr='); ?>",
											filebrowserImageBrowseUrl: "<?php echo base_url('assets/plugins/ckeditor4/filemanager/dialog.php?type=1&editor=ckeditor&fldr='); ?>",
											// width: 1000,
											height: 500,
											// language: '',
											toolbarCanCollapse: true, // ui可縮起來
										});
									</script>
								</div>
							</div>
						</div><!-- /.box-body -->
						<input type="submit" class="btn btn-success submit-pos" value="儲存" />
						<!-- <input type="submit" class="btn btn-primary" value="儲存" /> -->
					</form>
				</div>
			</div>
			<!-- <div class="col-md-12"> -->
			<script language='javascript' type='text/javascript'>
				$(function () {
					setTimeout(function () {
						$("#alert-success").hide();
					}, 3000);
				})
			</script>
			<?php
$this->load->helper('form');
$check = $this->session->flashdata('check');
if ($check) {
    ?>
			<div id="alert-error" class="alert-absoulte error-width alert alert-danger alert-dismissable">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<?php echo $check; ?>
			</div>
			<?php
unset($_SESSION['check']);
}
?>
			<?php
$success = $this->session->flashdata('success');
if ($success) {
    ?>
			<div id="alert-success" class="alert-absoulte alert success-width alert-success alert-dismissable">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<?php echo $success; ?>
			</div>
			<?php
unset($_SESSION['success']);
}
?>
			<style>
				.div-setup-h {
					height: 34px;
				}

				@media (max-width: 767px) {
					.div-setup-h {
						height: 84px;
					}
				}

				.box-body .row>div {
					margin-bottom: 40px;
				}
			</style>
			<!-- <?php echo validation_errors('<div id="alert-error" class="alert-absoulte alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?> -->
		</div>
	</section>
</div>