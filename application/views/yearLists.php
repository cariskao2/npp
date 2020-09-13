<div class="content-wrapper list-bottom-bg">
	<!-- <section class="content"> -->
	<section>
		<div class="function-on-top list-noinput_pos">
			<div class="row">
				<div class="col-xs-12">
					<div class="box" style="border:none;border-radius:0">
						<div class="box-header">
							<div class="row">
								<div class="col-xs-6">
									<div class="form-group">
										<a class="btn btn-primary" href="<?php echo base_url('members/yearsAdd'); ?>"><i
												class="fa fa-plus"></i> 新增</a>
										<a class="btn btn-success" href="<?php echo base_url('members/yearsSort'); ?>"><i
												class="fa fa-sort" aria-hidden="true"></i> 排序</a>
									</div>
								</div>
								<!-- 註解掉版型會跑掉,讓這個結構隱藏起來就好 -->
								<div class="col-xs-6 form-none" style="visibility: hidden;">
									<div class="box-tools">
										<form action="<?php echo base_url('members/yearLists'); ?>" method="POST" id="searchList">
											<div class="input-group">
												<input type="text" name="searchText" value="<?php echo $searchText; ?>"
													class="form-control input-sm pull-right" style="width: 250px;height:30px"
													placeholder="可搜尋屆期名稱" />
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
		<div class="row">
			<div class="col-xs-12">
				<div class="box" style="border-top:none;">
					<div class="box-body table-responsive no-padding list-scroll list-noinput-scroll">
						<table class="table table-hover title-center">
							<?php
if (!empty($yearLists)) {
    foreach ($yearLists as $items) {
        $yid        = $items->yid;
        $show       = $items->showup;
        $title      = $items->title;
        $date_start = $items->date_start;
        $date_end   = $items->date_end;
        ?>
							<tr class="tr-css">
								<td style="width:40%"><?php echo $title; ?></td>
								<td style="width:30%">
									<?php echo $date_start; ?> ~ <?php echo $date_end; ?>
								</td>
								<td style="width:15%">
									<?php if ($show == 1) {?>
									<img style="background-color:green" src="<?php echo base_url(); ?>assets/images/show.png"
										alt="">
									<?php } else {?>
									<img style="background-color:red" src="<?php echo base_url(); ?>assets/images/hide.png"
										alt="">
									<?php }?>
								</td>
								<td class=" text-center" style="width:15%">
									<a class="btn btn-sm btn-info" href="<?php echo base_url() . 'members/yearsEdit/' . $yid; ?>"
										title="編輯"><i class="fa fa-pencil"></i></a>
									<!-- <a class="btn btn-sm btn-danger deleteYears" data-yid="<?php echo $yid; ?>" title="刪除"><i class="fa fa-trash fa-lg"></i></a> -->
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
<template id="table-header-temp">
	<table id="table-header" class="table table-header title-center">
		<tr>
			<td style="width:40%">屆期名稱</td>
			<td style="width:30%">屆期起訖</td>
			<td style="width:15%">狀態</td>
			<td style="width:15%" class="text-center">功能</td>
		</tr>
	</table>
</template>
<style>
	tr.tr-css td {
		line-height: 37px !important;
	}
</style>
<script>
</script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>
<?php
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