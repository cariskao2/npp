<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<div class="content-wrapper">
	<!-- <section class="content"> -->
	<section>
		<div class="row">
			<!-- left column -->
			<div class="col-md-12">
				<!-- general form elements -->
				<div class="box box-primary" style="border:none;">
					<div class="add-edit-scroll">
						<div class="box-body">
							<div id="sortlist">
								<?php
if (!empty($issuesClassSort)) {
    foreach ($issuesClassSort as $record) {
        ?>
								<div class="ui-state-default" dbid="<?php echo $record->ic_id; ?>">
									<i class="ion-ios-drag handle"></i>
									<span class="sort-text"><?php echo $record->name; ?></span>
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
						<!-- box-body -->
					</div>
					<!-- add-edit-scroll -->
				</div>
				<!-- box -->
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
							<button id="save" class="btn btn-success">儲存</button>
						</div>
					</div>
				</div>
			</div><!-- /.box-header -->
		</div>
	</div>
</template>
<!-- content-wrapper -->
<script language='javascript' type='text/javascript'>
	new Sortable(sortlist, {
		animation: 150,
		handle: '.handle',
	});

	$(function () {
		// sortableJS
		$("#save").click(function () {
			const obj = {
				url: 'issues/issuesClassSortSend',
				redirect: 'issues/issuesClassSort',
			};

			sortJS(obj);
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