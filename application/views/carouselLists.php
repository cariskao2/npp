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
										<a class="btn btn-primary" href="<?php echo base_url('website/carouselAdds'); ?>"><i class="fa fa-plus"></i> 新增</a>
										<a class="btn btn-success" href="<?php echo base_url('website/carouselSorts'); ?>"><i class="fa fa-sort" aria-hidden="true"></i> 排序</a>
									</div>
								</div>
								<div class="col-xs-6">
									<div class="box-tools">
										<form action="<?php echo base_url('website/carouselLists'); ?>" method="POST" id="searchList">
											<!-- input-group讓裏面的元素融合(合併)在一起 -->
											<div class="input-group">
												<input type="text" name="searchText" value="<?php echo $searchText; ?>" class="form-control input-sm pull-right" style="width: 250px;height:30px" placeholder="可搜尋標題" />
												<div class="input-group-btn">
													<button class="btn btn-sm btn-default searchList"><i class="fa fa-search"></i></button>
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
									<th>圖片</th>
									<th style="width:250px;">標題</th>
									<th>簡介</th>
									<th>連結</th>
									<th style="width:50px">狀態</th>
									<th style="width:100px" class="text-center">可執行動作</th>
								</tr>
								<?php
if (!empty($getCarouselList)) {
    foreach ($getCarouselList as $record) {
        ?>
										<tr>
											<td><img style="width:200px;height:50px;" src="<?php echo base_url('assets/uploads/carousel_upload/' . $record->img); ?>"></td>
											<td><?php echo $record->title; ?></td>
											<td><?php echo mb_strimwidth(strip_tags($record->introduction), 0, 100, '...') ?></td>
											<td><?php echo $record->link; ?></td>
											<td>
												<?php if ($record->showup == 1) {?>
													<img style="background-color:green" src="<?php echo base_url('assets/images/show.png'); ?>" alt="">
												<?php } else {?>
													<img style="background-color:red" src="<?php echo base_url('assets/images/hide.png'); ?>" alt="">
												<?php }?>
											</td>
											<td class=" text-center">
												<a class="btn btn-sm btn-info" href="<?php echo base_url('website/carouselEdit/' . $record->id); ?>" title="編輯"><i class="fa fa-pencil"></i></a>
												<a class="btn btn-sm btn-danger deleteCarousel" data-carouselid="<?php echo $record->id; ?>" data-img="<?php echo $record->img; ?>" title="刪除"><i class="fa fa-trash fa-lg"></i></a>
											</td>
										</tr>
									<?php
}
} else {
    ?>
								<tr>
									<td colspan="6" class="no-data">
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
</style>
<script>
	// 分頁
	jQuery(document).ready(function() {
		pagination('website/carouselLists/');
	});
</script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>
<?php
$this->load->helper('form');
$error = $this->session->flashdata('error');
if ($error) {
    ?>
	<div id="alert-error" class="alert-absoulte alert alert-danger alert-dismissable">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		<?php echo $this->session->flashdata('error'); ?>
	</div>
<?php }?>
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