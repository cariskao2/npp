<div class="content-wrapper list-bottom-bg">
	<!-- <section class="content"> -->
	<section>
		<div class="function-on-top list-input_pos">
			<div class="row">
				<div class="col-xs-12">
					<div class="box" style="border:none;border-radius:0">
						<div class="box-header">
							<div class="row">
								<div class="col-xs-12 col-sm-5">
									<div class="form-group">
										<a class="btn btn-primary" href="<?php echo base_url('addNew'); ?>"><i
												class="fa fa-plus"></i> 新增</a>
									</div>
								</div>
								<div class="col-xs-12 col-sm-7">
									<div class="box-tools">
										<form action="<?php echo base_url('userListing') ?>" method="POST" id="searchList">
											<div class="input-group">
												<input type="text" name="searchText" value="<?php echo $searchText; ?>"
													class="form-control input-sm pull-right nav-list"
													style="width: 250px;height:30px" placeholder="可搜尋名稱、mail、手機" />
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
						<table class="table table-hover title-center" style="margin-bottom:0;border-bottom:3px solid gray">
							<tr>
								<td style="width:25%">人員</td>
								<td style="width:30%">Email</td>
								<!-- <td style="width:10%">手機</td> -->
								<td style="width:15%">層級</td>
								<td style="width:15%">日期</td>
								<td style="width:15%" class="text-center">功能</td>
							</tr>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12">
				<div class="box" style="border-top:none;">
					<div class="box-body table-responsive no-padding list-scroll list-input-scroll">
						<table class="table table-hover title-center">
							<?php
if (!empty($userRecords)) {
    foreach ($userRecords as $record) {
        ?>
							<tr>
								<td style="width:25%"><?php echo $record->name ?></td>
								<td style="width:30%"><?php echo $record->email ?></td>
								<!-- <td style="width:10%"><?php echo $record->mobile ?></td> -->
								<td style="width:15%"><?php echo $record->role ?></td>
								<td style="width:15%"><?php echo date("Y-d-m", strtotime($record->createdDtm)) ?></td>
								<td style="width:15%" class="text-center">
									<!-- <a class="btn btn-sm btn-primary" href="<?=base_url() . 'login-history/' . $record->userId;?>" title="歷史記錄"><i class="fa fa-history"></i></a> | -->
									<a class="btn btn-sm btn-info"
										href="<?php echo base_url() . 'editOld/' . $record->userId; ?>" title="編輯"><i
											class="fa fa-pencil"></i></a>
									<a class="btn btn-sm btn-danger deleteUser" href="#"
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
					<?php if ($this->pagination->create_links()): ?>
					<div class="pagination-fixed" id="pagination-fixed">
						<?php echo $this->pagination->create_links(); ?>
					</div>
					<?php endif;?>
				</div><!-- /.box -->
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
			jQuery("#searchList").attr("action", baseURL + "userListing/" + value);
			jQuery("#searchList").submit();
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