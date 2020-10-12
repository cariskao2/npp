<?php
$id     = $getYearInfo->yid;
$show   = $getYearInfo->showup;
$sort   = $getYearInfo->sort;
$title  = $getYearInfo->title;
$dStart = $getYearInfo->date_start;
$dEnd   = $getYearInfo->date_end;
?>
<div class="content-wrapper">
	<section>
		<div class="row">
			<!-- left column -->
			<div class="col-md-12">
				<!-- general form elements -->
				<div class="box box-primary" style="border:none;">
					<div class="" id="mobile-scroll-only">
						<!-- form start -->
						<form role="form" action="<?php echo base_url('members/yearsEditSend/' . $id) ?>" method="post" id="formSubmit"
							role="form">
							<div class="box-body">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label for="title" class="must">屆期名稱</label>
											<input type="text" class="form-control must" id="title" name="title"
												value="<?php echo $title; ?>" placeholder="必填欄位(前台顯示會將名稱與日期合併)">
											<?php echo form_error('title'); ?>
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
								<div class="row">
									<div class="col-md-3">
										<div class="form-group">
											<label for="date_start">起始日期</label>
											<div class="input-group cur">
												<input value="<?php echo $dStart; ?>" type="text" class="form-control"
													id="date_start" name="date_start" placeholder="選擇起始日期" autocomplete="off"
													readonly>
												<span class="input-group-addon" title="清除">
													<span class="glyphicon glyphicon-remove"></span>
												</span>
											</div>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label for="date_end">結束日期</label>
											<div class="input-group cur">
												<input value="<?php echo $dEnd; ?>" type="text" class="form-control" id="date_end"
													name="date_end" placeholder="選擇結束日期" autocomplete="off" readonly>
												<span class="input-group-addon" title="清除">
													<span class="glyphicon glyphicon-remove"></span>
												</span>
											</div>
										</div>
									</div>
								</div>
							</div><!-- /.box-body -->
						</form>
					</div><!-- add-edit-noscroll -->
				</div><!-- box -->
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
</script>
<?php
$check = $this->session->flashdata('check');
if ($check) {
    ?>
<div id="alert-error" class="alert-absoulte error-width alert alert-danger alert-dismissable">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	<?php echo $check ?>
</div>
<?php }?>

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
<div class="function-on-top not-list">
	<div class="row">
		<div class="col-xs-12">
			<div class="box" style="border-top:none;border-radius:0">
				<div class="box-header">
					<div class="row">
						<div class="col-xs-12">
							<div class="form-group">
								<a class="btn btn-warning" href="<?php echo $this->session->userdata('myRedirect'); ?>">返回</a>
							</div>
						</div>
					</div>
				</div><!-- /.box-header -->
			</div>
		</div>
	</div>
</div>