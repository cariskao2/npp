<div class="content-wrapper list-bottom-bg">
	<!-- <section class="content"> -->
	<section>
		<div class="row">
			<div class="col-xs-12">
				<div class="box box-scroll">
					<div class="box-body table-responsive no-padding thead-outside thead-carousel-input item-4">
						<table class="table">
							<tr>
								<td>圖片</td>
								<td>標題</td>
								<td>狀態</td>
								<td>功能</td>
							</tr>
						</table>
					</div>
					<div class="box-body table-responsive no-padding tbody-outside item-4">
						<table class="table table-hover">
							<?php
if (!empty($getCarouselList)) {
    foreach ($getCarouselList as $record) {
        ?>
							<tr>
								<td><img style="width:150px"
										src="<?php echo base_url('assets/uploads/carousel_upload/' . $record->img); ?>"></td>
								<td><?php echo $record->title; ?></td>
								<td>
									<?php if ($record->showup == 1) {?>
									<img style="background-color:green" src="<?php echo base_url('assets/images/show.png'); ?>"
										alt="">
									<?php } else {?>
									<img style="background-color:red" src="<?php echo base_url('assets/images/hide.png'); ?>"
										alt="">
									<?php }?>
								</td>
								<td class=" text-center">
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
				</div><!-- /.box -->
			</div>
		</div>
	</section>
</div>
<template id="function-on-top">
	<div class="function-on-top">
		<div class="box" style="border:none;border-radius:0">
			<div class="box-header">
				<div class="row">
					<div class="col-xs-10 col-sm-7">
						<div class="form-group">
							<a class="btn btn-primary" href="<?php echo base_url('website/carouselAdds'); ?>"><i
									class="fa fa-plus"></i> 新增</a>
							<a class="btn btn-success" href="<?php echo base_url('website/carouselSorts'); ?>"><i
									class="fa fa-sort" aria-hidden="true"></i> 排序</a>
							<br class="br"><span style="color:white">(最多只能建立8筆資料)</span>
						</div>
					</div>
					<!-- 註解掉版型會跑掉,讓這個結構隱藏起來就好 -->
					<div class="col-xs-2 col-sm-5" style="visibility: hidden;">
						<div class="box-tools" style="margin-top:2px">
							<form action="<?php echo base_url('website/carouselLists'); ?>" method="POST" id="searchList">
								<div class="input-group">
									<input type="text" name="searchText" value="<?php echo $searchText; ?>"
										class="form-control input-sm pull-right" style="width: 250px;height:30px"
										placeholder="可搜尋標題" />
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
</template>
<style>
	@media (min-width: 768px) {
		.br {
			display: none;
		}
	}
	@media (max-width: 767px) {
		.br {
			display: block;
		}
	}
</style>
<script>
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
}
?>