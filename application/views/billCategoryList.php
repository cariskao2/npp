<div class="content-wrapper">
	<!-- <section class="content"> -->
	<section>
		<div class="functoin-on-top not-list" style="width:100%">
			<div class="row">
				<div class="col-xs-12">
					<div class="box" style="border-top:none;border-radius:0">
						<div class="box-header">
							<div class="row">
								<div class="col-xs-12">
									<div class="form-group">
										<a class="btn btn-primary" href="<?php echo base_url('bills/billCategoryAdd'); ?>"><i
												class="fa fa-plus"></i> 新增</a>
												<a class="btn btn-success" href="<?php echo base_url('bills/billCategorySort'); ?>"><i class="fa fa-sort" aria-hidden="true"></i> 排序</a>
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
									<th>標題</th>
									<th style="width:50px">狀態</th>
									<th style="width:100px" class="text-center">可執行動作</th>
								</tr>
								<?php
if (!empty($getBillCategoryList)) {
    foreach ($getBillCategoryList as $item) {
        $id   = $item->gory_id;
        $show = $item->showsup;
        $name = $item->title;
        $img  = $item->img;
        ?>
								<tr class="tr-css">
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
											href="<?php echo base_url() . 'bills/billCategoryEdit/' . $id; ?>" title="編輯"><i
												class="fa fa-pencil"></i></a>
										<!-- <a class="btn btn-sm btn-danger deleteBills" data-id="<?php echo $id; ?>"
											data-deltype="bill-category" data-img="<?php echo $img; ?>" title="刪除"><i
												class="fa fa-trash fa-lg"></i></a> -->
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
</script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>
<?php
$this->load->helper('form');

// 返回上一頁並刷新
$isCategorySort   = $this->session->userdata('bill-category-sort');
$isCategoryUpdate = $this->session->userdata('bill-category-update');

if ($isCategorySort) {
    echo '<script>window.location.reload();</script>';
    unset($_SESSION['bill-category-sort']);
}

if ($isCategoryUpdate) {
    echo '<script>window.location.reload();</script>';
    unset($_SESSION['bill-category-update']);
}

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