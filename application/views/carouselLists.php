<div class="content-wrapper list-bottom-bg">
	<!-- <section class="content"> -->
	<section>
		<div class="function-on-top list-noinput_pos">
			<div class="row">
				<div class="col-xs-12">
					<div class="box" style="border:none;border-radius:0">
						<div class="box-header">
							<div class="row">
								<div class="col-xs-12 col-sm-7">
									<div class="form-group">
										<a class="btn btn-primary" href="<?php echo base_url('website/carouselAdds'); ?>"><i
												class="fa fa-plus"></i> 新增</a>
										<a class="btn btn-success" href="<?php echo base_url('website/carouselSorts'); ?>"><i
												class="fa fa-sort" aria-hidden="true"></i> 排序</a>
										<span style="color:white">(最多只能建立8筆資料)</span>
									</div>
								</div>
								<!-- 註解掉版型會跑掉,讓這個結構隱藏起來就好 -->
								<div class="col-xs-5 carousel-nav-none" style="visibility: hidden;">
									<div class="box-tools">
										<form action="<?php echo base_url('website/carouselLists'); ?>" method="POST"
											id="searchList">
											<div class="input-group">
												<input type="text" name="searchText" value="<?php echo $searchText; ?>"
													class="form-control input-sm pull-right" style="width: 250px;height:30px"
													placeholder="可搜尋標題" />
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
								<td style="width:20%;">圖片</td>
								<td style="width:40%;">標題</td>
								<td style="width:20%;">狀態</td>
								<td style="width:20%;" class="text-center">功能</td>
							</tr>
						</table>
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
if (!empty($getCarouselList)) {
    foreach ($getCarouselList as $record) {
        ?>
							<tr>
								<td style="width:20%"><img style="width:150px"
										src="<?php echo base_url('assets/uploads/carousel_upload/' . $record->img); ?>"></td>
								<td style="width:40%"><?php echo $record->title; ?></td>
								<td style="width:20%">
									<?php if ($record->showup == 1) {?>
									<img style="background-color:green" src="<?php echo base_url('assets/images/show.png'); ?>"
										alt="">
									<?php } else {?>
									<img style="background-color:red" src="<?php echo base_url('assets/images/hide.png'); ?>"
										alt="">
									<?php }?>
								</td>
								<td style="width:20%" class=" text-center">
									<a class="btn btn-sm btn-info"
										href="<?php echo base_url('website/carouselEdit/' . $record->id); ?>" title="編輯"><i
											class="fa fa-pencil"></i></a>
									<a class="btn btn-sm btn-danger deleteCarousel" data-carouselid="<?php echo $record->id; ?>"
										data-img="<?php echo $record->img; ?>" title="刪除"><i class="fa fa-trash fa-lg"></i></a>
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
					<!-- <?php if ($this->pagination->create_links()): ?>
					<div class="pagination-fixed" id="pagination-fixed">
						<?php echo $this->pagination->create_links(); ?>
					</div>
					<?php endif;?> -->
				</div><!-- /.box -->
			</div>
		</div>
	</section>
</div>
<style>
	@media (max-width: 767px) {
		.carousel-nav-none {
			display: none;
		}

		.function-on-top {
			width: 100%;
		}
	}
</style>
<script>
	// 分頁
	// jQuery(document).ready(function() {
	// 	pagination('website/carouselLists/');
	// });
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
$carouselCheck = $this->session->flashdata('carouselCheck');
if ($carouselCheck) {
    ?>
<div id="alert-error" class="alert-absoulte alert alert-danger alert-dismissable" style="width:300px">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	<?php echo $this->session->flashdata('carouselCheck'); ?>
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