<div id="loader">
	<div class="loader"></div>
</div>
<div class="content-wrapper">
	<!-- <section class="content"> -->
	<section>
		<div class="function-on-top not-list">
			<div class="row">
				<div class="col-xs-12">
					<div class="box" style="border-top:none;border-radius:0">
						<div class="box-header">
							<div class="row">
								<div class="col-xs-6">
									<div class="form-group">
										<a class="btn btn-primary" href="<?php echo base_url('bills/billCaseAdd'); ?>"><i
												class="fa fa-plus"></i> 新增</a>
									</div>
								</div>
								<div class="col-xs-6">
									<div class="box-tools">
										<form action="<?php echo base_url('bills/billCaseList'); ?>" method="POST"
											id="searchList">
											<!-- input-group讓裏面的元素融合(合併)在一起 -->
											<div class="input-group">
												<input type="text" name="searchText" value="<?php echo $searchText; ?>"
													class="form-control input-sm pull-right" style="width: 250px;height:30px"
													placeholder="可搜尋草案標題" />
												<div class="input-group-btn">
													<button class="btn btn-sm btn-default searchList"><i
															class="fa fa-search"></i></button>
												</div>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div><!-- /.box-header -->
						<table class="table table-hover title-center">
							<tr class="title-center">
								<td style="width:17%">No</td>
								<td style="width:49%">標題</td>
								<td style="width:17%">狀態</td>
								<td style="width:17%">可執行動作</td>
							</tr>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div class="div-list-h"></div>
		<div style="border-top:none">
			<div class="row">
				<div class="col-xs-12">
					<div class="box" style="border-top:none;">
						<div class="box-body table-responsive no-padding">
							<table class="table table-hover title-center">
								<?php
if (!empty($getBillCaseList)) {
    foreach ($getBillCaseList as $items) {
        $id     = $items->case_id;
        $f_id   = $items->float_id;
        $n      = $items->titlename;
        $status = $items->name;
        ?>
								<tr class="tr-css">
									<td style="width:17%"><?php echo $f_id; ?></td>
									<td style="width:49%"><?php echo $n; ?></td>
									<td style="width:17%"><?php echo $status; ?></td>
									<td style="width:17%">
										<a class="btn btn-sm btn-info"
											href="<?php echo base_url() . 'bills/billCaseEdit/' . $id; ?>" title="編輯"><i
												class="fa fa-pencil"></i></a>
										<a class="btn btn-sm btn-success"
											href="<?php echo base_url() . 'bills/legislative/' . $id; ?>" title="立法程序">立法程序</a>
										<a class="btn btn-sm btn-danger deleteBillCase" data-id="<?php echo $id; ?>" title="刪除"><i
												class="fa fa-trash fa-lg"></i></a>
									</td>
								</tr>
								<?php
}
} else {
    ?>
								<tr>
									<td colspan="4" class="no-data">
										無相關資料!
									</td>
								</tr>
								<?php }?>
							</table>

						</div><!-- /.box-body -->
						<div class="box-footer clearfix">
							<?php echo $this->pagination->create_links(); ?>
						</div>
					</div><!-- /.box -->
				</div>
			</div>
		</div>
	</section>
</div>
<style>
	tr.tr-css td {
		line-height: 37px !important;
	}
</style>
<script>
	if ($.cookie('bill-add-refresh') == 'ok' || $.cookie('bill-edit-refresh') == 'ok') {
		$.removeCookie('bill-add-refresh', {
			path: '/'
		});

		$.removeCookie('bill-edit-refresh', {
			path: '/'
		});

		window.location.reload();

	} else {
		$('#loader').hide(0); // 在下方的頁數切換時不會產生動畫,只有進入新增或是編輯才會產生動畫
	}

	// 分頁
	jQuery(document).ready(function () {
		pagination('bills/billCaseList/');
	});
</script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>
<?php
$this->load->helper('form');
$success = $this->session->flashdata('success');
if ($success) {
    ?>
<div id="alert-success" class="alert-absoulte alert success-width alert-success alert-dismissable">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	<?php echo $success; ?>
</div>
<?php
unset($_SESSION['success']);
}
?>