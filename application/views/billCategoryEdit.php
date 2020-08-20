<?php
$id    = $getBillCategoryInfo->gory_id;
$show  = $getBillCategoryInfo->showsup;
$title = $getBillCategoryInfo->title;
$img   = $getBillCategoryInfo->img;
?>
<div class="content-wrapper">
	<section>
		<div class="function-on-top not-list">
			<div class="row">
				<div class="col-xs-12">
					<div class="box" style="border-top:none;border-radius:0">
						<div class="box-header">
							<div class="row">
								<div class="col-xs-12">
									<div class="form-group">
										<a class="btn btn-warning"
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
		<div class="row">
			<!-- left column -->
			<div class="col-md-12">
				<!-- general form elements -->
				<div class="box box-primary not-list-L-scroll">
					<!-- form start -->
					<form role="form" action="<?php echo base_url('bills/billCategoryEditSend/' . $id); ?>" method="post"
						id="" role="form" enctype="multipart/form-data">
						<div class="box-body">
							<div class="row">
								<div class="col-md-6 col-xs-12">
									<div class="form-group">
										<img style="width:300px"
											src="<?php echo base_url('assets/uploads/bill_category/' . $img); ?>">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label for="file" class="">更換圖片(不換則不用選擇,支援格式：jpg png,且圖片尺寸爲1024x420)</label>
										<input type="file" name="file" id="file" />
										<?php echo form_error('file'); ?>
										<input type="hidden" name="img_name" value="<?php echo $img; ?>">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="title" class="must">標題</label>
										<input type="text" class="form-control must" id="title" name="title"
											value="<?php echo $title; ?>" placeholder="">
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
						</div>
						<!-- /.box-body -->
						<input type="submit" class="btn btn-success submit-pos" value="儲存" />
					</form>
				</div>
				<!-- box -->
			</div>
			<!-- col-md-12 -->
		</div>
	</section>
</div>
<script language='javascript' type='text/javascript'>
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
	<?php echo $check; ?>
</div>
<?php }?>

<style>
	.error-width {
		width: 150px;
	}
</style>
<!-- <?php echo validation_errors('<div id="alert-error" class="alert-absoulte alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?> -->