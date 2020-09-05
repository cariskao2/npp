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
										<!-- Add尾端加上「/」selectizejs才會正常顯示 -->
										<a class="btn btn-primary" href="<?php echo base_url('members/membersAdd'); ?>"><i
												class="fa fa-plus"></i> 新增</a>
										<a class="btn btn-success" href="<?php echo base_url('members/membersSort'); ?>"><i
												class="fa fa-sort" aria-hidden="true"></i> 排序</a>
									</div>
								</div>
								<div class="col-xs-12 col-sm-7">
									<div class="box-tools">
										<!-- 下方jQuery.attr會再改action屬性 -->
										<form action="<?php echo base_url('members/membersList'); ?>" method="POST"
											id="searchList" name="form">
											<div class="input-group">
												<input type="text" name="searchText" value="<?php echo $searchText; ?>"
													class="form-control input-sm pull-right nav-list"
													style="width: 250px;height:30px" placeholder="可搜尋姓名" />
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
							<tr class="title-center">
								<td style="width:60%">姓名</td>
								<td style="width:20%">狀態</td>
								<td style="width:20%">功能</td>
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
if (!empty($listItems)) {
    foreach ($listItems as $items) {
        ?>
							<tr>
								<td style="width:60%"><?php echo $items->name; ?></td>
								<td style="width:20%">
									<?php if ($items->showup == 1) {?>
									<img style="background-color:green" src="<?php echo base_url('assets/images/show.png'); ?>"
										alt="">
									<?php } else {?>
									<img style="background-color:red" src="<?php echo base_url('assets/images/hide.png'); ?>"
										alt="">
									<?php }?>
								</td>
								<td style="width:20%">
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
					<?php if ($this->pagination->create_links()): ?>
					<div class="pagination-fixed" id="pagination-fixed">
						<?php echo $this->pagination->create_links(); ?>
					</div>
					<?php endif;?>
				</div><!-- /.box -->
			</div>
		</div>
		<!-- row -->
	</section>
</div>
<script type="text/javascript" src="<?php echo base_url('assets/js/common.js'); ?>" charset="utf-8"></script>
<script type="text/javascript">
	jQuery(document).ready(function () {
		jQuery('ul.pagination li a').click(function (e) {
			// 當點擊下方頁面時,就獲取以下資料並跳轉
			e.preventDefault();
			var link = jQuery(this).get(0).href;
			// substring(start,end)表示從start到end之間的字串，包括start位置的字元但是不包括end位置的字元。
			var queryStr = link.substring(link.lastIndexOf('/') + 1); // 1?per_page=2
			var key = 'key=' + form.searchText.value;

			if (form.searchText.value != '') {
				if (queryStr.indexOf('key') == -1) {
					if (queryStr.indexOf('per_page') >= 0) {
						key = '&' + key;
					} else {
						key = '?' + key;
					}
				}
			} else {
				key = '';
			}

			// console.log('link', link);
			// console.log('queryStr', queryStr);
			// console.log('key', key);
			// console.log('searchText', form.searchText.value);

			jQuery('#searchList').attr('action', baseURL + 'members/' + queryStr + key);
			jQuery('#searchList').submit();
		});
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