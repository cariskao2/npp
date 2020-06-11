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
										<a class="btn btn-warning"
											href="<?php echo base_url($this->session->userdata('myRedirect')); ?>">返回</a>
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
						<button id="save" class="btn btn-success submit-pos">儲存</button>
						<div class="box-body">
							<div class="row">
								<div class="col-md-12">
									<div id="sortlist">
										<?php
if (!empty($getMembersList)) {
    foreach ($getMembersList as $record) {
        ?>
										<div class="ui-state-default" dbid="<?php echo $record->memid; ?>">
											<?php echo $record->name; ?>
										</div>
										<?php
}
} else {
    ?>
										<div style="text-align:center;color:red;font-size:30px;font-weight:bolder">
											無相關資料!
										</div>
										<?php }?>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- box -->
				</div>
				<!-- <div class="col-md-12"> -->

				<script language='javascript' type='text/javascript'>
					$(function () {
						// jquery UI sortable
						$("#save").click(function () {
							var _sort = new Array();
							var hitURL = baseURL + 'members/sortSend';

							$(".ui-state-default").each(function () {
								_sort.push($(this).attr('dbid'));
							});
							// console.log(_sort);

							$.ajax({
								type: "POST",
								url: hitURL,
								dataType: "text",
								data: {
									newSort: _sort,
									who: 'members'
								},
								success: function (data) {
									// console.log('ok');
									// 這裏在controller用$this->xx()會吃不到成功訊息。
									window.location.href = baseURL + 'members/membersList/';
								},
								error: function (jqXHR) {
									console.log('發生錯誤: ', jqXHR.status);
								}
							})
						})

						$('.ui-state-default').mouseover(function () {
							$(this).css({
								'cursor': 'move',
								'opacity': .7,
							});
						});

						$('.ui-state-default').mouseout(function () {
							$(this).css({
								'opacity': 1,
							});
						});

						var $list = $('#sortlist');

						$list.sortable({
							opacity: 0.7,
							revert: true,
							cursor: 'move',

							start: function (event, ui) {},

							update: function (event, ui) {
								$('.ui-state-default').css({
									'opacity': 1,
								});
							},
						})
					})
				</script>
				<?php
$this->load->helper('form');
$success = $this->session->flashdata('success');
if ($success) {
    ?>
				<div id="alert-success" class="alert-absoulte success-width alert alert-success alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					<?php echo $success; ?>
				</div>
				<?php
}
?>
				<?php
$error = $this->session->flashdata('error');
if ($error) {
    ?>
				<div id="alert-success" class="alert-absoulte error-width alert alert-danger alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					<?php echo $error; ?>
				</div>
				<?php
}
?>
				<!-- <?php echo validation_errors('<div id="alert-error" class="alert-absoulte alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?> -->
			</div>
			<!-- row -->
		</div>
		<!-- add-fixed-top-css -->
	</section>
</div>
<!-- content-wrapper -->