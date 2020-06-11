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
										<!-- Add尾端加上「/」selectizejs才會正常顯示 -->
										<a class="btn btn-primary" href="<?php echo base_url('members/membersAdd'); ?>"><i
												class="fa fa-plus"></i> 新增</a>
										<a class="btn btn-success" href="<?php echo base_url('members/membersSort'); ?>"><i
												class="fa fa-sort" aria-hidden="true"></i> 排序</a>
									</div>
								</div>
								<div class="col-xs-6">
									<div class="box-tools">
										<!-- 列表尾端加上「/」在下方第一頁分頁才會正常顯示 -->
										<form action="<?php echo base_url('members/membersList/'); ?>" method="POST"
											id="searchList">
											<div class="input-group">
												<input type="text" name="searchText" value="<?php echo $searchText; ?>"
													class="form-control input-sm pull-right" style="width: 250px;height:30px"
													placeholder="可搜尋姓名" />
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
									<th>姓名</th>
									<th style="width:50px">狀態</th>
									<th style="width:100px">可執行動作</th>
								</tr>
								<?php
if (!empty($listItems)) {
    foreach ($listItems as $items) {
        ?>
								<tr>
									<td><?php echo $items->name; ?></td>
									<td>
										<?php if ($items->showup == 1) {?>
										<img style="background-color:green"
											src="<?php echo base_url('assets/images/show.png'); ?>" alt="">
										<?php } else {?>
										<img style="background-color:red" src="<?php echo base_url('assets/images/hide.png'); ?>"
											alt="">
										<?php }?>
									</td>
									<td>
										<a class="btn btn-sm btn-info"
											href="<?php echo base_url('members/membersEdit/' . $items->memid); ?>" title="編輯"><i
												class="fa fa-pencil"></i></a>
<a class="btn btn-sm btn-danger deleteMembers" data-id="<?php echo $items->memid; ?>"
											data-img="<?php echo $items->img; ?>" title="移除"><i class="fa fa-trash"></i></a>
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
<script type="text/javascript" src="<?php echo base_url('assets/js/common.js'); ?>" charset="utf-8"></script>
<script type="text/javascript">
	jQuery(document).ready(function () {
		pagination('members/membersList/');
	});
</script>
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