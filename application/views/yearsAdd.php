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
						<form role="form" action="<?php echo base_url() ?>members/yearsAddSend" method="post" id=""
							role="form">
							<div class="box-body">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label for="title" class="must">屆期名稱</label>
											<input type="text" class="form-control must" id="title" name="title" value=""
												placeholder="必填欄位(前台顯示會將名稱與日期合併)">
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
									<div class="col-md-3">
										<div class="form-group">
											<label for="date_start">起始日期</label>
											<div class="input-group cur">
												<input type="text" class="form-control" id="date_start" name="date_start"
													placeholder="選擇起始日期" autocomplete="off" readonly>
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
												<input type="text" class="form-control" id="date_end" name="date_end"
													placeholder="選擇結束日期" autocomplete="off" readonly>
												<span class="input-group-addon" title="清除">
													<span class="glyphicon glyphicon-remove"></span>
												</span>
											</div>
										</div>
									</div>
								</div>
							</div>
					</div><!-- /.box-body -->
					<input type="submit" class="btn btn-success submit-pos" value="儲存" />
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

				// 顯示狀態
				$('#radioBtn a').on('click', function () {
					var sel = $(this).data('title');
					var tog = $(this).data('toggle');
					console.log('sel', sel);
					console.log('tog', tog);
					$('#' + tog).prop('value', sel); //將該被點擊的data-title值寫入到id="happy"的value中。

					// 當點擊爲Y,就把不爲Y的元素移除active並加上notActive
					$('a[data-toggle="' + tog + '"]').not('[data-title="' + sel + '"]').removeClass('active').addClass(
						'notActive');
					// 當點擊爲Y,就把爲Y的元素移除notActive並加上active
					$('a[data-toggle="' + tog + '"][data-title="' + sel + '"]').removeClass('notActive').addClass('active');
				})

				$("#date_start").datepicker({
					// maxDate: "+0d",
					showButtonPanel: true,
					dateFormat: 'yy-mm-dd',
					showMonthAfterYear: true,
					changeMonth: true,
					changeYear: true,

					onSelect: function (dateText, inst) {
						// console.log(this.id);
						$("#date_end").datepicker("option", "minDate", dateText);

						// 起始到結束之間的日期計算
						// var _dateFrom = '';
						// var _tDayTimestamp = Date.parse(new Date());
						// console.log(_tDayTimestamp);
						// _dateFromTimestamp = Date.parse(dateText);
						// console.log(_dateFromTimestamp);
						// var _count = parseInt((_tDayTimestamp - _dateFromTimestamp) / (1000 * 60 * 60 * 24));
						// console.log(_count);
					}
				});

				$("#date_end").datepicker({
					// minDate:'-10d',
					showButtonPanel: true,
					dateFormat: 'yy-mm-dd',
					showMonthAfterYear: true,
					changeMonth: true,
					changeYear: true,

					onSelect: function (dateText, inst) {
						$("#date_start").datepicker("option", "maxDate", dateText);
					}
				});
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
			<?php }?>

			<style>
				.ui-datepicker .ui-datepicker-title {
					display: flex;
					justify-content: center;
				}

				.ui-datepicker .ui-datepicker-title .ui-datepicker-month {
					padding-bottom: 3px;
				}

				.error-width {
					width: 150px;
				}
			</style>
			<!-- <?php echo validation_errors('<div id="alert-error" class="alert-absoulte alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?> -->
		</div>
</div>
</section>
</div>