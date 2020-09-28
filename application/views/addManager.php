<div class="content-wrapper">
	<section>
		<div class="row">
			<!-- left column -->
			<div class="col-md-8">
				<!-- general form elements -->
				<div class="box box-primary" style="border:none;">
					<div class="" id="mobile-scroll-only">
						<!-- form start -->
						<?php $this->load->helper("form");?>
						<form role="form" id="addUser" action="<?php echo base_url() ?>user/addNewManager" method="post"
							role="form">
							<div class="box-body">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label for="fname">名稱</label>
											<input type="text" class="form-control required"
												value="<?php echo set_value('fname'); ?>" id="fname" name="fname" maxlength="128">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="email">Email(帳號)</label>
											<input type="text" class="form-control required email" id="email"
												value="<?php echo set_value('email'); ?>" name="email" maxlength="128">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label for="password">密碼</label>
											<input type="password" class="form-control required" id="password" name="password"
												maxlength="20">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="cpassword">密碼確認</label>
											<input type="password" class="form-control required equalTo" id="cpassword"
												name="cpassword" maxlength="20">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label for="mobile">手機</label>
											<input type="text" class="form-control required digits" id="mobile"
												value="<?php echo set_value('mobile'); ?>" name="mobile" maxlength="10">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="role">層級</label>
											<select class="form-control required" id="role" name="role"
												style="padding-top:0;padding-bottom:0">
												<option value="0">未選擇</option>
												<?php
if (!empty($roles)) {
    foreach ($roles as $rl) {
        ?>
												<option value="<?php echo $rl->roleId ?>" <?php if ($rl->roleId == set_value('role')) {
            echo "selected=selected";
        }?>><?php echo $rl->role ?></option>
												<?php
}
}
?>
											</select>
										</div>
									</div>
								</div>
							</div><!-- /.box-body -->
						</form>
					</div><!-- add-edit-noscroll -->
				</div><!-- box -->
			</div>
			<div class="col-md-4">
				<?php
$error = $this->session->flashdata('error');
if ($error) {
    ?>
				<div class="alert alert-danger alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					<?php echo $error; ?>
				</div>
				<?php
}
?>
				<?php
$success = $this->session->flashdata('success');
if ($success) {
    ?>
				<div id="alert-success" class="alert alert-success alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					<?php echo $success; ?>
				</div>
				<?php
}
?>

				<div class="row">
					<div class="col-md-12">
						<!-- <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?> -->
					</div>
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
		jQuery('#addUser').submit();
	}
</script>
<style>
</style>
<script src="<?php echo base_url(); ?>assets/js/addUser.js" type="text/javascript"></script>