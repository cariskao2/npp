<div class="content-wrapper list-bottom-bg">
	<!-- <section class="content"> -->
	<section id="list-input">
		<div class="row">
			<div class="col-xs-12">
				<div class="box box-scroll">
					<div class="box-body table-responsive no-padding thead-outside thead-has-input item-4">
						<table class="table">
							<tr>
								<td>標題</td>
								<td>發布時間</td>
								<td>狀態</td>
								<td>功能</td>
							</tr>
						</table>
					</div>
					<div class="box-body table-responsive no-padding tbody-outside item-4">
						<table class="table table-hover">
							<?php
if (!empty($listItems)) {
    foreach ($listItems as $record) {
        ?>
							<tr>
								<!-- <td><img style="width:50px;height:50px;"
											src="<?php echo base_url('assets/uploads/news_upload/' . $record->pr_type_id . '/' . $record->img); ?>">
									</td> -->
								<td>
									<?php echo '<b>' . $record->main_title . '</b>'; ?></td>
								<td><?php
if ($record->date_start == '' && $record->time_start == '') {
            echo '無設定';
        } else {
            if ($record->date_start != '' && $record->time_start != '') {
                echo $record->date_start . '<br>' . $record->time_start;
            } elseif ($record->date_start != '') {
                echo $record->date_start;
            } elseif ($record->time_start != '') {
                echo $record->time_start;
            }
        }
        ?>
								</td>
								<!-- <td>
										<?php echo mb_strimwidth(strip_tags($record->editor), 0, 100, '...') ?></td> -->
								<!-- <td>
										<?php if (!empty($getTagsChoice)): ?>
										<?php foreach ($getTagsChoice as $choice): ?>
										<?php if ($record->pr_id == $choice->pr_id): ?>
										<p><?=$choice->name;?></p>
										<?php endif;?>
										<?php endforeach;?>
										<?php endif;?>
									</td> -->
								<td>
									<?php if ($record->showup == 1) {?>
									<img style="background-color:green" src="<?php echo base_url('assets/images/show.png'); ?>"
										alt="">
									<?php } else {?>
									<img style="background-color:red" src="<?php echo base_url('assets/images/hide.png'); ?>"
										alt="">
									<?php }?>
								</td>
								<td>
									<a class="btn btn-sm btn-info"
										href="<?php echo base_url('news/newsEdit/' . $record->pr_id); ?>" title="編輯"><i
											class="fa fa-pencil"></i></a>
									<a class="btn btn-sm btn-danger newsListDel" data-delid="<?php echo $record->pr_id; ?>"
										data-typeid="<?php echo $record->pr_type_id; ?>" data-img="<?php echo $record->img; ?>"
										title="移除"><i class="fa fa-trash"></i></a>
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
	<div class="function-on-top list-input">
		<div class="box" style="border:none;border-radius:0">
			<div class="box-header">
				<div class="row">
					<div class="col-xs-12 col-sm-5">
						<div class="form-group">
							<a class="btn btn-primary" href="<?php echo base_url('news/adds/' . $type_id); ?>"><i
									class="fa fa-plus"></i> 新增</a>
						</div>
					</div>
					<div class="col-xs-12 col-sm-7">
						<div class="box-tools">
							<!-- 下方jQuery.attr會再改action屬性 -->
							<form action="<?php echo base_url('news/lists/' . $type_id); ?>" method="POST" id="searchList"
								name="form">
								<!-- input-group讓裏面的元素融合(合併)在一起 -->
								<div class="input-group">
									<input type="text" name="searchText" value="<?php echo $searchText; ?>"
										class="form-control input-sm pull-right nav-list" style="width: 250px;height:30px"
										placeholder="可搜尋標題" />
									<div class="input-group-btn">
										<button class="btn btn-sm btn-default searchList"><i class="fa fa-search"></i></button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div><!-- /.row -->
			</div><!-- /.box-header -->
		</div><!-- /.box -->
	</div>
</template>
<style>
</style>
<script type="text/javascript" src="<?php echo base_url('assets/js/common.js'); ?>" charset="utf-8"></script>
<script type="text/javascript">
	jQuery(document).ready(function () {
		/**
		 * 範例(enable_query_strings=false) & 說明
		 * 如果不寫下面url這一行 將會取最後一個/前所有值
		 * var url = link.substr(link.lastIndexOf('/', link.lastIndexOf('/') - 1) + 1); // 1/10
		 * var site = url.lastIndexOf("\/"); //获取最后一个/的位置,1
		 * 獲取最後一個「/」前面的值
		 * http://www.w3school.com.cn/jsref/jsref_lastIndexOf.asp
		 * lastIndexOf第二個參數:它的合法取值是 0 到 stringObject.length - 1。如省略该参数，则将从字符串的最后一个字符处开始检索。
		 * substr(start,length)表示從start位置開始，擷取length長度的字串。
		 * substring(start,end)表示從start到end之間的字串，包括start位置的字元但是不包括end位置的字元。
		 *
		 * 這行說明:
		 * 第二個lastIndexOf因爲沒有第二個參數(看上方說明),所以直接從最後面開始找「/」,找到後再將位置-1就變成那段字串的length,也就是最後一個字。
		 * 第一個lastIndexOf的第二個參數就是第二個lastIndexOf的結果-1,也代表第一個lastIndexOf會從倒數第二段字串的最後一個字元開始往回查詢,這樣就會避開了最後一個「/」,而搜索到倒數第二個「/」再+1獲取倒數第二個「/」後的全部字串。
		 */
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

			// console.log('link', link);
			// console.log('queryStr', queryStr);
			// console.log('key', key);
			// console.log('searchText', form.searchText.value);

			jQuery('#searchList').attr('action', baseURL + 'news/lists/' + queryStr + key);
			jQuery('#searchList').submit();
		});
	});
</script>
<?php
$success = $this->session->flashdata('success');
echo $success;
if ($success) {
    ?>
<div id="alert-success" class="alert-absoulte success-width alert alert-success alert-dismissable">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	<?php echo $success; ?>
</div>
<?php
}
?>