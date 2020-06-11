<link rel="stylesheet" type="text/css"
	href="<?php echo base_url('assets/plugins/mydatepicker/css/jquery-ui-git.css'); ?>">
<script src="<?php echo base_url('assets/plugins/mydatepicker/js/jquery-clockpicker.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/mydatepicker/js/highlight.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/mydatepicker/js/jquery-ui-git.js'); ?>"></script>
<div class="breadcrumb-bg">
	<div class="container">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li style="" class="breadcrumb-item"><a href="<?php echo base_url('fend/home'); ?>">首頁</a></li>
				<li style="" class="breadcrumb-item"><a href="<?php echo base_url('fend/news_f'); ?>">新聞訊息</a></li>
				<li class="breadcrumb-item active" aria-current="page"><?php echo $breadcrumbTag; ?></li>
			</ol>
		</nav>
	</div>
</div>
<div class="container" style="margin-bottom:20px">
	<div class="row" style="border-bottom: solid 1px gray;">
		<div class="col-md-12">
			<div class="home-title_style"><?php echo $breadcrumbTag; ?></div>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-12">
			<form action="<?php echo base_url('fend/news_f/newsFlists/' . $type_id) ?>" method="POST" id="searchList"
				class="form-inline searchList-f_form">
				<!-- autocomplete自動完成 readonly在手機點擊時才不會彈出輸入視窗 -->
				<div class="form-group form-group-custom">
					<label for="searchFrom" class="sr-only">開始時間</label>
					<input id="searchFrom" type="text" name="searchFrom" value="<?php echo $searchFrom; ?>"
						class="form-control" placeholder="開始時間" autocomplete="off" readonly />
					<button title="清除" type="button" class="btn-clear-searchdate from"><i class="fa fa-times-circle"
							aria-hidden="true"></i></button>
				</div>
				<div class="form-group form-group-custom">
					<label for="searchEnd" class="sr-only">結束時間</label>
					<input id="searchEnd" type="text" name="searchEnd" value="<?php echo $searchEnd; ?>" class="form-control"
						placeholder="結束時間" autocomplete="off" readonly />
					<button title="清除" type="button" class="btn-clear-searchdate end"><i class="fa fa-times-circle"
							aria-hidden="true"></i></button>
				</div>
				<div class="form-group form-group-custom">
					<label for="searchKey" class="sr-only">關鍵字</label>
					<input id="searchKey" type="text" name="searchKey" value="<?php echo $searchKey; ?>" class="form-control"
						placeholder="關鍵字" autocomplete="off" />
					<button title="清除" type="button" class="btn-clear-searchdate key"><i class="fa fa-times-circle"
							aria-hidden="true"></i></button>
				</div>
				<div class="form-group form-group-custom_submit">
					<button class="btn btn-default">搜尋</button>
				</div>
			</form>
		</div>
	</div>
</div>
<div class="container custom-gutters" style="margin-bottom:20px">
	<div class="row" style="border-bottom:solid 1px gray;margin-bottom:50px;padding-bottom:50px">
		<?php
if (!empty($listItems)) {
    foreach ($listItems as $record) {
        $id      = $record->pr_id;
        $type_id = $record->pr_type_id;
        $img     = $record->img;
        $m_title = $record->main_title;
        $date    = $record->date_start;
        $e       = $record->editor;
        ?>
		<div class="col-lg-4 col-md-6">
			<!-- 在controller使用input->get() -->
			<!-- <a href="<?php echo base_url('fend/news_f/newsInner?t=' . $type_id . '&d=' . $id); ?>" class="newsBlock_style"
				style="border-radius:0"> -->
			<a href="<?php echo base_url('fend/news_f/newsInner/' . $type_id . '/' . $id); ?>" class="newsBlock_style"
				style="border-radius:0">
				<div class="card mb-4 box-shadow" style="border-radius:0">
					<img class="card-img-top"
						src="<?php echo base_url('assets/uploads/news_upload/' . $type_id . '/' . $img); ?>"
						alt="Card image cap" style="border-radius:0">
					<div class="card-body">
						<h5><?php echo mb_strimwidth(strip_tags($m_title), 0, 40, '...'); ?></h5>
						<span class="data-start_fontsize">發布日期：<?php echo $date; ?></span>
						<p><?php echo mb_strimwidth(strip_tags($e), 0, 100, '...'); ?></p>
					</div>
				</div>
			</a>
		</div>
		<?php
}
}
?>
	</div>
</div>
<?php echo $this->pagination->create_links(); ?>
</div>
<div id="gotop">^</div>
<script type="text/javascript">
	var _dateFrom = '<?php echo $searchFrom; ?>';
	var _dateEnd = '<?php echo $searchEnd; ?>';
	// console.log('reFreshFrom:', _dateFrom);
	// console.log('reFreshEnd:', _dateEnd);

	jQuery(document).ready(function () {
		// RWD來更改分頁文本
		var w = $(window).width();
		// console.log(w); //獲取刷新後的值
		if (w < 992) {
			$('.first-page a').text('<<');
			$('.last-page a').text('>>');
			$('.prev-page a').text('<');
			$('.next-page a').text('>');
		}
		$(window).resize(function () {
			var rw = $(window).width();
			// console.log(rw); //獲取解析度變動後的值
			if (rw < 992) {
				$('.first-page a').text('<<');
				$('.last-page a').text('>>');
				$('.prev-page a').text('<');
				$('.next-page a').text('>');
			} else {
				$('.first-page a').text('最新文章');
				$('.last-page a').text('最舊文章');
				$('.prev-page a').text('前一頁');
				$('.next-page a').text('下一頁');
			}
		});

		// pagination
		jQuery('ul.pagination li a').click(function (e) {
			// 當點擊下方頁面時,就獲取以下資料並跳轉
			e.preventDefault();
			var link = jQuery(this).get(0).href;
			var value = link.substring(link.lastIndexOf('/') + 1);
			var url = link.substr(link.lastIndexOf('/', link.lastIndexOf('/') - 1) + 1);
			var site = url.lastIndexOf("\/");
			var type_id = url.substring(0, site);

			// console.log('link: ' + link);
			// console.log('value: ' + value);
			// console.log('url: ' + url);
			// console.log('site: ' + site);
			// console.log('type_id: ' + type_id);

			jQuery("#searchList").attr("action", baseURL + "fend/news_f/newsFlists/" + type_id + '/' +
				value);
			jQuery("#searchList").submit();
		});

		// JQuery UI datepicker
		$.datepicker.regional['zh-TW'] = {
			dayNames: ["星期日", "星期一", "星期二", "星期三", "星期四", "星期五", "星期六"],
			dayNamesMin: ["日", "一", "二", "三", "四", "五", "六"],
			monthNames: ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"],
			monthNamesShort: ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"],
			prevText: "上月",
			nextText: "次月",
			weekHeader: "週",
			currentText: "今天",
			closeText: "關閉"
		};

		$.datepicker.setDefaults($.datepicker.regional["zh-TW"]);

		$("#searchFrom").datepicker({
			//限制日期選擇範圍,d=天,w=週,m=月
			// minDate: "-1d",
			// maxDate: "+1d",
			maxDate: "+0d",
			showButtonPanel: true,
			dateFormat: 'yy-mm-dd',
			showMonthAfterYear: true,

			// 在日期面板中點選了一個日期後,觸發此事件
			onSelect: function (dateText, inst) {
				// console.log('datetext', dateText);
				// console.log('getdate', $(this).datepicker('getDate'));
				// console.log('beforeSelectFrom:', _dateFrom);
				// console.log('beforeSelectEnd:', _dateEnd);
				_dateFrom = dateText;
				// console.log('afterSelectFrom:', _dateFrom);

				if (_dateEnd != '') {
					if (_dateFrom > _dateEnd) {
						$(this).val('');
						_dateFrom = '';
						alert('開始日期「不可大於」結束日期');
					}
				}
			}
		});

		$("#searchEnd").datepicker({
			maxDate: "+0d",
			showButtonPanel: true,
			dateFormat: 'yy-mm-dd',
			showMonthAfterYear: true,

			onSelect: function (dateText, inst) {
				// console.log('beforeSelectFrom:', _dateFrom);
				// console.log('beforeSelectEnd:', _dateEnd);
				_dateEnd = dateText;
				// console.log('afterSelectEnd:', _dateEnd);

				if (_dateFrom != '') {
					if (_dateEnd < _dateFrom) {
						$(this).val('');
						_dateEnd = '';
						alert('結束日期「不可小於」開始日期');
					}
				}
			}
		});

		$('.from').click(function () {
			$('#searchFrom').val('');
			_dateFrom = '';
		});

		$('.end').click(function () {
			$('#searchEnd').val('');
			_dateEnd = '';
		});

		$('.key').click(function () {
			$('#searchKey').val('');
		});
	});
</script>