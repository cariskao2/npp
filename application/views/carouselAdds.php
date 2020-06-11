<div class="content-wrapper">
	<!-- <section class="content"> -->
	<section>
		<div class="functoin-on-top">
			<div class="row">
				<div class="col-xs-12">
					<div class="box" style="border-top:none;border-radius:0">
						<div class="box-header">
							<div class="row">
								<div class="col-xs-12">
									<div class="form-group">
										<a class="btn btn-warning" href="<?php echo base_url($this->session->userdata('myRedirect')); ?>">返回</a>
									</div>
								</div>
							</div>
						</div><!-- /.box-header -->
					</div>
				</div>
			</div>
		</div>
		<div class="div-h"></div>
		<div style="border-top:none">
			<div class="row">
				<!-- left column -->
				<div class="col-md-12">
					<!-- general form elements -->
					<div class="box box-primary" style="border:none;">
						<!-- form start -->
						<!--  enctype="multipart/form-data"記得加 -->
						<form role="form" action="<?php echo base_url('website/carouselAddSend'); ?>" method="post" id=""
							role="form" enctype="multipart/form-data">
							<div class="box-body">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label for="img" class="must">選擇圖片(支援格式：jpg png gif)</label>
											<input class="form-control" id="img" type="file" name="file" size="20" />
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
								</div>
								<div class="row">
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
									<div class="col-md-6">
										<div class="form-group">
											<label for="introduction">簡介</label>
											<textarea class="form-control" name="introduction" id="introduction" cols="30"
												rows="5"></textarea>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label for="link">連結</label>
											<input type="text" class="form-control" id="link" name="link" value="">
											<?php echo form_error('link'); ?>
										</div>
									</div>
								</div>
							</div><!-- /.box-body -->
							<input type="submit" class="btn btn-success submit-pos" value="儲存" />
						</form>
					</div>
					<!-- box -->
				</div>
				<!-- <div class="col-md-12"> -->
				<?php
$this->load->helper('form');
$check = $this->session->flashdata('check');
if ($check) {
    ?>
				<div id="alert-error" class="alert-absoulte error-width alert alert-danger alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					<?php echo $check . '!<br>請修正以下提示錯誤!'; ?>
				</div>
				<?php
unset($_SESSION['check']);
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
unset($_SESSION['success']);
}
?>
				<style>
				</style>
				<!-- <?php echo validation_errors('<div id="alert-error" class="alert-absoulte alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?> -->
			</div>
			<!-- row -->
		</div>
		<!-- add-fixed-top-css -->
	</section>
</div>
<!-- content-wrapper -->