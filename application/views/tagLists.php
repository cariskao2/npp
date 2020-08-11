<div class="content-wrapper">
	<!-- <section class="content"> -->
	<section>
		<div class="function-on-top not-list" style="right:0;left:230px">
			<div class="row">
				<div class="col-xs-12">
					<div class="box" style="border-top:none;border-radius:0">
						<div class="box-header">
							<div class="row">
								<div class="col-xs-6">
									<div class="form-group">
										<a class="btn btn-primary" href="<?php echo base_url('news/tagsAdd'); ?>"><i
												class="fa fa-plus"></i> 新增</a>
									</div>
								</div>
								<!-- <div class="col-xs-6">
									<div class="box-tools">
										<form action="<?php echo base_url('news/tagLists'); ?>" method="POST" id="searchList">
											<div class="input-group">
												<input type="text" name="searchText" value="<?php echo $searchText; ?>"
													class="form-control input-sm pull-right" style="width: 250px;height:30px"
													placeholder="可搜尋標籤名稱" />
												<div class="input-group-btn">
													<button class="btn btn-sm btn-default searchList"><i
															class="fa fa-search"></i></button>
												</div>
											</div>
										</form>
									</div>
								</div> -->
							</div>
						</div><!-- /.box-header -->
						<table class="table table-hover title-center">
							<tr>
								<td style="width:60%">標籤名稱</td>
								<td style="width:20%">狀態</td>
								<td style="width:20%" class="text-center">可執行動作</td>
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
if (!empty($newsTags)) {
    foreach ($newsTags as $record) {
        ?>
								<tr>
									<td style="width:60%"><?php echo $record->name; ?></td>
									<td style="width:20%">
										<?php if ($record->showup == 1) {?>
										<img style="background-color:green" src="<?php echo base_url(); ?>assets/images/show.png"
											alt="">
										<?php } else {?>
										<img style="background-color:red" src="<?php echo base_url(); ?>assets/images/hide.png"
											alt="">
										<?php }?>
									</td>
									<td style="width:20%" class="text-center">
										<a class="btn btn-sm btn-info"
											href="<?php echo base_url() . 'news/tagsEdit/' . $record->tags_id; ?>" title="編輯"><i
												class="fa fa-pencil"></i></a>
										<a class="btn btn-sm btn-danger deleteNewsTag"
											data-tagsid="<?php echo $record->tags_id; ?>" title="刪除"><i
												class="fa fa-trash fa-lg"></i></a>
									</td>
								</tr>
								<?php
}
} else {
    ?>
								<tr>
									<td colspan="3" class="no-data">
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
	.alert-absoulte {
		width: 150px
	}
</style>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>
<script>
	// 分頁
	// jQuery(document).ready(function () {
	// 	pagination('news/tagLists/');
	// });
</script>
<?php
$this->load->helper('form');
$success = $this->session->flashdata('success');
if ($success) {
    ?>
<div id="alert-success" class="alert-absoulte alert alert-success alert-dismissable">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	<?php echo $success; ?>
</div>
<?php
unset($_SESSION['success']);
}
?>