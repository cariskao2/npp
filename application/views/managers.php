<div class="content-wrapper">
	<!-- <section class="content"> -->
	<section>
		<div class="functoin-on-top not-list">
			<div class="row">
				<div class="col-xs-12">
					<div class="box" style="border-top:none;border-radius:0">
						<div class="box-header">
							<div class="row">
								<div class="col-xs-6">
									<div class="form-group">
										<a class="btn btn-primary" href="<?php echo base_url('user/addManager'); ?>"><i
												class="fa fa-plus"></i> 新增</a>
									</div>
								</div>
								<div class="col-xs-6">
									<div class="box-tools">
										<form action="<?php echo base_url('user/managerListing') ?>" method="POST" id="searchList">
											<div class="input-group">
												<input type="text" name="searchText" value="<?php echo $searchText; ?>"
													class="form-control input-sm pull-right" style="width: 250px;height:30px"
													placeholder="可搜尋名稱、mail、手機" />
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
					</div>
				</div>
			</div>
		</div>
		<div class="div-h"></div>
		<div style="border-top:none">
			<div class="row">
				<div class="col-xs-12">
					<div class="box" style="border-top:none;">
						<div class="box-body table-responsive no-padding">
							<table class="table table-hover">
								<tr>
									<th>人員名稱</th>
									<th>Email</th>
									<th>手機</th>
									<th>層級</th>
									<th>建立日期</th>
									<th class="text-center">可執行動作</th>
								</tr>
								<?php
if (!empty($userRecords)) {
    foreach ($userRecords as $record) {
        ?>
								<tr>
									<td><?php echo $record->name ?></td>
									<td><?php echo $record->email ?></td>
									<td><?php echo $record->mobile ?></td>
									<td><?php echo $record->role ?></td>
									<td><?php echo date("Y-d-m", strtotime($record->createdDtm)) ?></td>
									<td class="text-center">
										<!-- <a class="btn btn-sm btn-primary" href="<?=base_url() . 'login-history/' . $record->userId;?>" title="歷史記錄"><i class="fa fa-history"></i></a> | -->
										<a class="btn btn-sm btn-info"
											href="<?php echo base_url() . 'user/managerOld/' . $record->userId; ?>" title="編輯"><i
												class="fa fa-pencil"></i></a>
										<a class="btn btn-sm btn-danger deleteManager" href="#"
											data-delid="<?php echo $record->userId; ?>" title="移除"><i class="fa fa-trash"></i></a>
									</td>
								</tr>
								<?php
}
} else {
    ?>
								<div style="text-align:center;color:red;font-size:30px;font-weight:bolder">
									無相關資料!
								</div>
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
</style>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>
<script type="text/javascript">
	// alert(baseURL);
	jQuery(document).ready(function () {
		jQuery('ul.pagination li a').click(function (e) {
			e.preventDefault();
			// alert(jQuery(this)); // 物件
			var link = jQuery(this).get(0).href;
			var value = link.substring(link.lastIndexOf('/') + 1);
			jQuery("#searchList").attr("action", baseURL + "user/managerListing/" + value);
			jQuery("#searchList").submit();1
		});
	});
</script>
<?php
$success = $this->session->flashdata('success');
if ($success) {
    ?>
<div id="alert-success" class="alert-absoulte success-width alert alert-success alert-dismissable">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	<?php echo $success; ?>
</div>
<?php
unset($_SESSION['success']);
}
?>