<?php
$id    = $getBillStatusInfo->status_id;
$show  = $getBillStatusInfo->shows;
$name  = $getBillStatusInfo->name;
$color = $getBillStatusInfo->color_id;
?>
<div class="content-wrapper">
	<section>
		<div class="row">
			<!-- left column -->
			<div class="col-md-12">
				<!-- general form elements -->
				<div class="box box-primary" style="border:none;">
					<div class="add-edit-noscroll">
						<!-- form start -->
						<form role="form" action="<?php echo base_url('bills/billStatusEditSend/' . $id); ?>" method="post"
							id="formSubmit" role="form" enctype="multipart/form-data">
							<div class="box-body">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label for="name" class="must">名稱</label>
											<input type="text" class="form-control must" id="name" name="name"
												value="<?php echo $name; ?>" placeholder="">
											<?php echo form_error('name'); ?>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label for="color">顏色</label><br>
											<div class="color-center">
												<?php foreach ($status_color as $colors): ?>
												<input type="radio" name="color" value="<?php echo $colors->color_id; ?>" <?php if ($color == $colors->color_id) {echo 'checked';}?>>
												<span class="r-<?php echo $colors->color_name; ?> r-set"></span>
												<?php endforeach;?>
											</div>
										</div>
									</div>
								</div>
								<div class="row">
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
							</div>
							<!-- /.box-body -->
						</form>
					</div><!-- add-edit-noscroll -->
				</div>
				<!-- .box -->
			</div>
			<!-- .col-md-12 -->
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

	$(function () {
		setTimeout(function () {
			$("#alert-success").hide();
		}, 3000);
	})

	// 顯示狀態
	$('#radioBtn a').on('click', function () {
		var sel = $(this).data('title');
		var tog = $(this).data('toggle');
		// console.log('sel', sel);
		// console.log('tog', tog);
		$('#' + tog).prop('value', sel); //將該被點擊的data-title值寫入到id="happy"的value中。

		// 當點擊爲Y,就把不爲Y的元素移除active並加上notActive
		$('a[data-toggle="' + tog + '"]').not('[data-title="' + sel + '"]').removeClass('active').addClass(
			'notActive');
		// 當點擊爲Y,就把爲Y的元素移除notActive並加上active
		$('a[data-toggle="' + tog + '"][data-title="' + sel + '"]').removeClass('notActive').addClass('active');
	})
</script>
<?php
$this->load->helper('form');
$check = $this->session->flashdata('check');
if ($check) {
    ?>
<div id="alert-error" class="alert-absoulte error-width alert alert-danger alert-dismissable">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	<?php echo $check ?>
</div>
<?php
}
?>

<style>
	.error-width {
		width: 150px;
	}

	.color-center {
		display: flex;
		align-items: center;
	}

	.color-center input {
		margin-top: 0;
		margin-left: 10px;
	}

	.r-set {
		width: 30px;
		height: 15px;
		margin-left: 10px;
	}

	.r-black {
		background-color: black;
	}

	.r-red {
		background-color: red;
	}

	.r-green {
		background-color: green;
	}

	.r-orange {
		background-color: orange;
	}
</style>
<!-- <?php echo validation_errors('<div id="alert-error" class="alert-absoulte alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?> -->