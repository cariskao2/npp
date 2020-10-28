<div class="content-wrapper list-bottom-bg">
	<!-- <section class="content"> -->
	<section id="list-input">
		<div class="row">
			<div class="col-xs-12">
				<div class="box box-scroll">
					<div class="box-body table-responsive no-padding thead-outside thead-has-select">
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
        $title  = $items->titlename;
        $status = $items->name;
        $notice = $items->notice;
        ?>
							<tr class="tr-css">
								<td><?php echo $f_id; ?></td>
								<td><?php echo $title; ?></td>
								<td><?php echo $status . '<br>'; ?><span style="color:red"><?php echo $notice; ?></span></td>
								<td>
									<a class="btn btn-sm btn-info" href="<?php echo base_url() . 'bills/billCaseEdit/' . $id; ?>"
										title="編輯"><i class="fa fa-pencil"></i></a>
									<a class="btn btn-sm btn-success"
										href="<?php echo base_url() . 'bills/billCaseSessionList/' . $id; ?>"
										title="立法程序">立法程序</a>
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
				<div class="flex">
					<div class="flex-add">
						<a class="btn btn-primary" href="<?php echo base_url('bills/billCaseAdd'); ?>"><i
								class="fa fa-plus"></i> 新增</a>
						<a class="btn btn-warning" href="<?php echo base_url('bills/billCaseList'); ?>">清除查詢</a>
					</div>
					<div class="flex-select">
						<div class="input-group">
							<span class="input-group-btn">
								<button class="btn btn-default btn-sm" type="button">狀態</button>
							</span>
							<select name="billStatusSelect" id="billstatus-select" class="form-control">
								<option <?php if (0 == $statusId) {echo 'selected';}?> value="0">顯示全部</option>
								<?php
if (!empty($getBillStatus)) {
    foreach ($getBillStatus as $item) {
        $id = $item->status_id;
        ?>
								<option <?php if ($id == $statusId) {echo 'selected';}?>
									value="<?php echo $item->status_id; ?>"><?php echo $item->name; ?></option>
								<?php
}
}
?>
							</select>
						</div>
					</div>
					<div class="flex-search">
						<div class="box-tools pull-right" style="margin-top:2px;">
							<form action="<?php echo base_url('bills/billCaseList'); ?>" method="POST" id="searchList"
								name="form">
								<!-- input-group讓裏面的元素融合(合併)在一起 -->
								<div class="input-group">
									<input type="text" name="searchText" value="<?php echo $searchText; ?>"
										class="form-control input-sm pull-right nav-list" placeholder="搜尋標題" />
									<div class="input-group-btn">
										<button id="searchBtn" class="btn btn-sm btn-default searchList"><i
												class="fa fa-search"></i></button>
									</div>
								</div>
								<input type="hidden" name="hide" id="hide">
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
		width: 40%;
	}

	.thead-outside td:nth-child(3),
	.tbody-outside td:nth-child(3) {
		width: 20%;
	}

	.thead-outside td:nth-child(4),
	.tbody-outside td:nth-child(4) {
		width: 30%;
	}
</style>
<script>
	$(document).on('change', '#billstatus-select', function () {
		$('#hide').val($("#billstatus-select :selected").val());
		$('#searchList').submit();
	});

	jQuery(document).ready(function () {
		$('#searchBtn').click(function () {
			$('#hide').val($("#billstatus-select").val());
			$('#searchList').submit();
		})

		jQuery('ul.pagination li a').click(function (e) {
			// 當點擊下方頁面時,就獲取以下資料並跳轉
			e.preventDefault();
			var link = jQuery(this).get(0).href;
			// substring(start,end)表示從start到end之間的字串，包括start位置的字元但是不包括end位置的字元。
			var queryStr = link.substring(link.lastIndexOf('/') + 1); // 1?per_page=2
			var key = 'key=' + form.searchText.value;
			var sId = 'id=' + $("#billstatus-select").val();

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

			if (queryStr.indexOf('key') == -1 && queryStr.indexOf('per_page') == -1) {
				sId = '?' + sId;
			} else {
				sId = '&' + sId;
			}

			// console.log('link', link);
			// console.log('queryStr', queryStr);
			// console.log('key', key);
			// console.log('sId', sId);

			jQuery('#searchList').attr('action', baseURL + 'bills/' + queryStr + key + sId);
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