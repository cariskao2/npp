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
										<a class="btn btn-primary" href="<?php echo base_url('issues/issuesAllAdd'); ?>"><i
												class="fa fa-plus"></i> 新增</a>
									</div>
								</div>
								<div class="col-xs-6">
									<div class="box-tools">
										<form action="<?php echo base_url('issues/issuesAllList'); ?>" method="POST"
											id="searchList">
											<!-- input-group可讓icon跟input合併 -->
											<div class="input-group">
												<input type="text" name="searchText" value="<?php echo $searchText; ?>"
													class="form-control input-sm pull-right" style="width: 250px;height:30px"
													placeholder="可搜尋議題列表名稱" />
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
							<table class="table table-hover title-center">
								<tr class="title-center">
									<th>議題列表名稱</th>
									<th>類別</th>
									<th style="width:50px">狀態</th>
									<th style="width:100px" class="text-center">可執行動作</th>
								</tr>
								<?php
if (!empty($issuesAllList)) {
    foreach ($issuesAllList as $item) {
        $id    = $item->ia_id;
        $show  = $item->showup;
        $title = $item->title;
        $name  = $item->name;
        $img   = $item->img;
        ?>
								<tr class="tr-css">
									<td><?php echo $title; ?></td>
									<td><?php echo $name; ?></td>
									<td>
										<?php if ($show == 1) {?>
										<img style="background-color:green" src="<?php echo base_url(); ?>assets/images/show.png"
											alt="">
										<?php } else {?>
										<img style="background-color:red" src="<?php echo base_url(); ?>assets/images/hide.png"
											alt="">
										<?php }?>
									</td>
									<td class=" text-center">
										<a class="btn btn-sm btn-info"
											href="<?php echo base_url() . 'issues/issuesAllEdit/' . $id; ?>" title="編輯"><i
												class="fa fa-pencil"></i></a>
										<a class="btn btn-sm btn-danger deleteIssuesAll" data-img=<?php echo $img; ?> data-id="<?php echo $id; ?>"
											title="刪除"><i class="fa fa-trash fa-lg"></i></a>
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
	// 分頁
	jQuery(document).ready(function () {
		pagination('issues/issuesAllList/');
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