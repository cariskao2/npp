<?php
$mail        = $getSetupInfo->mail;
$fb          = $getSetupInfo->fb;
$address     = $getSetupInfo->address;
$num         = $getSetupInfo->num;
$fax         = $getSetupInfo->fax;
$servicetime = $getSetupInfo->servicetime;
?>
<div class="content-wrapper">
	<section>
		<div class="row">
			<!-- left column -->
			<div class="col-md-12">
				<!-- general form elements -->
				<div class="box box-primary" style="border:none;">
					<div class="add-edit-noscroll" style="padding-top:30px">
						<!-- form start -->
						<!--  enctype="multipart/form-data"記得加 -->
						<form role="form" action="<?php echo base_url('website/setupSend') ?>"
							method="post" id="" role="form" enctype="multipart/form-data">
							<div class="box-body">
								<div class="row">
									<div class="col-md-6">
										<div class="bg-color">
											<p>頁首設定</p>
											<div class="form-group">
												<label for="mail">Email</label>
												<input type="text" class="form-control" id="mail" name="mail"
													value="<?php echo $mail; ?>">
												<?php echo form_error('mail'); ?>
												<label for="fb">臉書</label>
												<input type="text" class="form-control" id="fb" name="fb"
													value="<?php echo $fb; ?>">
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="bg-color">
											<p>頁尾設定</p>
											<div class="form-group">
												<label for="address">地址</label>
												<input type="text" class="form-control" id="address" name="address"
													value="<?php echo $address; ?>">
												<label for="num">電話</label>
												<input type="text" class="form-control" id="num" name="num"
													value="<?php echo $num; ?>">
												<label for="fax">傳真</label>
												<input type="text" class="form-control" id="fax" name="fax"
													value="<?php echo $fax; ?>">
												<label for="cell_phone">服務時間</label>
												<input type="text" class="form-control" id="servicetime" name="servicetime"
													value="<?php echo $servicetime; ?>">
											</div>
										</div>
									</div>
								</div>
							</div><!-- /.box-body -->
							<input type="submit" class="btn btn-success submit-pos" value="儲存" />
						</form>
					</div><!-- add-edit-noscroll -->
				</div><!-- box -->
			</div>
		</div><!-- row -->
	</section>
</div>
<template id="function-on-top">
	<div class="function-on-top">
		<div class="box" style="border-top:none;border-radius:0">
			<div class="box-header">
				<div class="row">
					<div class="col-xs-12">
						<div class="form-group">
							<a class="btn btn-warning" style="visibility:hidden">返回</a>
						</div>
					</div>
				</div>
			</div><!-- /.box-header -->
		</div>
	</div>
</template>
<script language='javascript' type='text/javascript'>
	$(function () {
		setTimeout(function () {
			$("#alert-success").hide();
		}, 3000);
	})
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
<div id="alert-success" class="alert-absoulte alert success-width alert-success alert-dismissable">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	<?php echo $success; ?>
</div>
<?php
}
?>
<style>
	.seat input {
		width: 100px;
		margin: 0 40px;
	}

	.box-body .row>div {
		margin-bottom: 40px;
	}
</style>
<!-- <?php echo validation_errors('<div id="alert-error" class="alert-absoulte alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?> -->