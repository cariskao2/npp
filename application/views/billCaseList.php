<div class="content-wrapper list-bottom-bg">
	<!-- <section class="content"> -->
	<section id="list-input">
		<div class="row">
			<div class="col-xs-12">
				<div class="box box-scroll">
					<div class="box-body table-responsive no-padding thead-outside thead-has-input">
						<table class="table">
							<tr>
								<td>No</td>
								<td>標題</td>
								<td>狀態</td>
								<td>功能</td>
							</tr>
						</table>
					</div>
					<div class="box-body table-responsive no-padding tbody-outside">
						<table class="table table-hover">
							<?php
if (!empty($getBillCaseList)) {
    foreach ($getBillCaseList as $items) {
        $id     = $items->case_id;
        $f_id   = $items->float_id;
        $n      = $items->titlename;
        $status = $items->name;
        ?>
							<tr class="tr-css">
								<td><?php echo $f_id; ?></td>
								<td><?php echo $n; ?></td>
								<td><?php echo $status; ?></td>
								<td>
									<a class="btn btn-sm btn-info" href="<?php echo base_url() . 'bills/billCaseEdit/' . $id; ?>"
										title="編輯"><i class="fa fa-pencil"></i></a>
									<a class="btn btn-sm btn-success"
										href="<?php echo base_url() . 'bills/legislative/' . $id; ?>" title="立法程序">立法程序</a>
									<a class="btn btn-sm btn-danger deleteBillCase" data-id="<?php echo $id; ?>" title="刪除"><i
											class="fa fa-trash fa-lg"></i></a>
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
							<a class="btn btn-primary" href="<?php echo base_url('bills/billCaseAdd'); ?>"><i
									class="fa fa-plus"></i> 新增</a>
						</div>
					</div>
					<div class="col-xs-12 col-sm-7">
						<div class="box-tools">
							<form action="<?php echo base_url('bills/billCaseList'); ?>" method="POST" id="searchList"
								name="form">
								<!-- input-group讓裏面的元素融合(合併)在一起 -->
								<div class="input-group">
									<input type="text" name="searchText" value="<?php echo $searchText; ?>"
										class="form-control input-sm pull-right nav-list" style="width: 250px;height:30px"
										placeholder="可搜尋草案標題" />
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
	.thead-outside td:nth-child(2),
	.tbody-outside td:nth-child(2) {
		width: 50%;
	}

	.thead-outside td:nth-child(3),
	.tbody-outside td:nth-child(3) {
		width: 20%;
	}

	.thead-outside td:nth-child(4),
	.tbody-outside td:nth-child(4) {
		width: 25%;
	}

	@media (max-width: 767px) {

		.thead-outside td:nth-child(2),
		.tbody-outside td:nth-child(2) {
			width: 50%;
		}

		.thead-outside td:nth-child(3),
		.tbody-outside td:nth-child(3) {
			width: 20%;
		}

		.thead-outside td:nth-child(4),
		.tbody-outside td:nth-child(4) {
			width: 25%;
		}
	}
</style>
<script>
	jQuery(document).ready(function () {
		jQuery('ul.pagination li a').click(function (e) {
			// 當點擊下方頁面時,就獲取以下資料並跳轉
			e.preventDefault();
			var link = jQuery(this).get(0).href; // http://localhost/npp/news/lists/1/10
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

			jQuery('#searchList').attr('action', baseURL + 'bills/' + queryStr + key);
			jQuery('#searchList').submit();
		});
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
}
?>