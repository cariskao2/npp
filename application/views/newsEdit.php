<?php
$pr_id      = $userInfo->pr_id;
$type_id    = $userInfo->pr_type_id;
$img        = $userInfo->img;
$m_title    = $userInfo->main_title;
$s_title    = $userInfo->sub_title;
$date_start = $userInfo->date_start;
$time_start = $userInfo->time_start;
$editor     = $userInfo->editor;

$myRedirect = $this->session->userdata('myRedirect');
?>
<link rel="stylesheet" href="<?php echo base_url('assets/plugins/clockpicker/css/bootstrap-clockpicker.css'); ?>">
<script src="<?php echo base_url('assets/plugins/clockpicker/js/bootstrap-clockpicker.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/selectizejs/dist/js/standalone/selectize.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/selectizejs/js/index.js'); ?>"></script>
<div id="loader"><div class="loader"></div></div>
<div class="content-wrapper">
	<section>
		<div class="functoin-on-top">
			<div class="row">
				<div class="col-xs-12">
					<div class="box" style="border-top:none;border-radius:0">
						<div class="box-header">
							<div class="row">
								<div class="col-xs-12">
									<div class="form-group">
										<a class="btn btn-warning" href="<?php echo base_url($myRedirect); ?>">返回</a>
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
						<form role="form" action="<?php echo base_url('news/editSend/' . $pr_id); ?>" method="post" id=""
							role="form" enctype="multipart/form-data">
							<div class="box-body">
								<div class="row">
									<div class="col-md-6 col-xs-12">
										<div class="form-group">
											<div class="row">
												<img class="col-md-12 col-xs-12"
													src="<?php echo base_url('assets/uploads/news_upload/' . $type_id . '/' . $img); ?>">
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label for="img">更換圖片(不換則不用選擇 支援格式：jpg png gif)</label>
											<input style="border:none" class="form-control" id="img" type="file" name="file" size="20" />
											<?php echo form_error('file'); ?>
											<input type="hidden" name="img_name" value="<?php echo $img; ?>">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label for="m_title" class="must">大標</label>
											<input type="text" class="form-control" id="m_title" name="m_title"
												value="<?php echo $m_title; ?>">
											<?php echo form_error('m_title'); ?>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label for="s_title">次標</label>
											<input type="text" class="form-control" id="s_title" name="s_title"
												value="<?php echo $s_title; ?>">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label for="select-tools">標籤</label>
											<!-- name記得加上[],才能以陣列形式回傳。並加上multiple="multiple"才能在一開始就同時顯示selected的全部元素 -->
											<select id="select-tools" name="tags[]" placeholder="請選取標籤" multiple="multiple">
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
											<input type="hidden" name="type_id" id="type_id" value="<?php echo $type_id; ?>">
										</div>
									</div>
									<div class="col-md-2">
										<div class="form-group">
											<label for="date_start">建立日期</label>
											<div class="input-group clockpicker">
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
											<label for="time_start">建立時間</label>
											<div class="input-group clockpicker">
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
													<?php
$active    = $userInfo->showup == 1 ? 'active' : 'notActive';
$notActive = $userInfo->showup == 0 ? 'active' : 'notActive';
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
										<label for="editor1">內文</label>
										<textarea name="editor1" id="editor1"><?php echo $editor; ?></textarea>
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
							<input type="submit" class="btn btn-success submit-pos" value="儲存" />
					</div>
					</form>
				</div>
				<!-- box -->
			</div>
			<!-- <div class="col-md-12"> -->

			<script language='javascript' type='text/javascript'>
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

				var selectTools = $('#select-tools')[0].selectize;
				var jsArray = <?php echo json_encode($getTagsID); ?>;
				// console.log('jsArray', jsArray);
				selectTools.setValue(jsArray, true);
			</script>
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
			<!-- <?php echo validation_errors('<div id="alert-error" class="alert-absoulte alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?> -->
		</div>
		<!-- row -->
		<!-- add-fixed-top-css -->
	</section>
</div>
<!-- content-wrapper -->