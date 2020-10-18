<div class="content-wrapper list-bottom-bg">
	<!-- <section class="content"> -->
	<section id="list-input">
		<div class="row">
			<div class="col-xs-12">
				<div class="box box-scroll">
					<div class="box-body table-responsive no-padding thead-outside thead-has-input item-3">
						<table class="table">
							<tr>
								<td>名稱</td>
								<td>層級</td>
								<td>功能</td>
							</tr>
						</table>
					</div>
					<div class="box-body table-responsive no-padding tbody-outside item-3">
						<table class="table table-hover">
							<?php
if (!empty($userRecords)) {
    foreach ($userRecords as $record) {
        ?>
							<tr>
								<td><?php echo $record->name ?></td>
								<td><?php echo $record->role ?></td>
								<!-- <td><?php echo date("Y-d-m", strtotime($record->createdDtm)) ?></td> -->
								<td class="text-center">
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
							<tr>
								<td colspan="3" class="no-data">
									無相關資料!
								</td>
							</tr>
							<?php }?>
						</table>
					</div><!-- /.box-body -->
					<?php if ($this->pagination->create_links()): ?>
					<div class="pagination-bottom" id="pagination-bottom">
						<?php echo $this->pagination->create_links(); ?>
					</div>
					<?php endif;?>
				</div><!-- /.box -->
			</div>
		</div>
	</section>
</div>
<template id="function-on-top">
	<div class="function-on-top list-input" id="list-input">
		<div class="box" style="border:none;border-radius:0">
			<div class="box-header">
				<div class="row">
					<div class="col-xs-12 col-sm-5">
						<div class="form-group">
							<a class="btn btn-primary" href="<?php echo base_url('addNew'); ?>"><i class="fa fa-plus"></i>
								新增</a>
						</div>
					</div>
					<div class="col-xs-12 col-sm-7">
						<div class="box-tools" style="margin-top:2px">
							<form action="<?php echo base_url('userListing') ?>" method="POST" id="searchList" name="form">
								<div class="input-group">
									<input type="text" name="searchText" value="<?php echo $searchText; ?>"
										class="form-control input-sm pull-right nav-list" style="width: 250px;height:30px"
										placeholder="可搜尋名稱" />
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
</style>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>
<script type="text/javascript">
	// alert(baseURL);
	jQuery(document).ready(function () {
		jQuery('ul.pagination li a').click(function (e) {
			// 當點擊下方頁面時,就獲取以下資料並跳轉
			e.preventDefault();
			var link = jQuery(this).get(0).href; // 獲取當前link
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

			// console.log('queryStr', queryStr);
			// console.log('key', key);
			// console.log('link', link);
			// console.log('searchText', form.searchText.value);

			jQuery('#searchList').attr('action', baseURL + 'user/' + queryStr + key);
			jQuery('#searchList').submit();
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
}
?>