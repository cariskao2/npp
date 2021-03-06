<?php
$memid      = $getMemberInfo->memid;
$show       = $getMemberInfo->showup;
$img        = $getMemberInfo->img;
$name       = $getMemberInfo->name;
$name_en    = $getMemberInfo->name_en;
$education  = $getMemberInfo->education;
$experience = $getMemberInfo->experience;
$districts  = $getMemberInfo->districts;
$committee  = $getMemberInfo->committee;
$fb         = $getMemberInfo->fb;
$ig         = $getMemberInfo->ig;
$line       = $getMemberInfo->line;
$yt         = $getMemberInfo->yt;
?>
<script src="<?php echo base_url('assets/plugins/selectizejs/dist/js/standalone/selectize.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/selectizejs/js/index.js'); ?>"></script>
<div id="loader">
	<div class="loader"></div>
</div>
<div class="content-wrapper">
	<section>
		<div class="row">
			<!-- left column -->
			<div class="col-md-12">
				<!-- general form elements -->
				<div class="box box-primary" style="border:none;">
					<div class="add-edit-scroll">
						<!-- form start -->
						<!--  enctype="multipart/form-data"記得加 -->
						<form role="form" action="<?php echo base_url('members/membersEditSend/' . $memid); ?>" method="post"
							id="formSubmit" role="form" enctype="multipart/form-data">
							<!-- box-body padding:0 here only -->
							<div class="box-body" style="padding:0">
								<div class="row">
									<div class="col-md-12">
										<table class="table table-bordered">
											<thead>
												<tr>
													<th colspan="2" scope="col">基本資料</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<th scope="row">
														<label for="img">更換照片</label>
													</th>
													<td>
														<div class="form-group" style="text-align:left">
															<img style="width:120px"
																src="<?php echo base_url('assets/uploads/members_upload/' . $img); ?>">
															<p style="color:red;margin-bottom:0">僅支援 jpg、png、gif</p>
															<!-- 沒加form-control上下會不平均 -->
															<input style="border:none" type="file" name="file"
																class="form-control" />
															<?php echo form_error('file'); ?>
															<input type="hidden" name="img_name" value="<?php echo $img; ?>">
														</div>
													</td>
												</tr>
												<tr>
													<th scope="row">
														<span class="must">*</span>姓名
													</th>
													<td>
														<div class="form-group">
															<input type="text" class="form-control" name="name"
																value="<?php echo $name; ?>">
															<?php echo form_error('name'); ?>
														</div>
													</td>
												</tr>
												<tr>
													<th scope="row">
														<span class="must">*</span>英文姓名
													</th>
													<td>
														<div class="form-group">
															<input type="text" class="form-control" name="name_en"
																value="<?php echo $name_en; ?>">
															<?php echo form_error('name_en'); ?>
														</div>
													</td>
												</tr>
												<tr>
													<th scope="row">
														<span class="must">*</span>屆期
													</th>
													<td>
														<div class="form-group">
															<!-- name記得加上[],才能以陣列形式回傳。並加上multiple="multiple"才能在一開始就同時顯示selected的全部元素 -->
															<select id="select-years" name="years[]" placeholder="請選擇屆期"
																multiple="multiple">
																<option value="">請選擇屆期</option>
																<?php
if (!empty($getYearsList)) {
    foreach ($getYearsList as $items) {
        ?>
																<option value="<?php echo $items->sort; ?>">
																	<?php echo $items->title; ?>
																</option>
																<?php
}
}
?>
															</select>
															<?php echo form_error('years'); ?>
														</div>
													</td>
												</tr>
												<tr>
													<th scope="row">
														關注議題
													</th>
													<td class="">
														<div class="form-group">
															<!-- name記得加上[],才能以陣列形式回傳 -->
															<select id="select-issues" name="issues[]" placeholder="請選擇議題">
																<option value="">請選擇議題</option>
																<?php
if (!empty($getIssuesClassList)) {
    foreach ($getIssuesClassList as $items) {
        ?>
																<option value="<?php echo $items->sort; ?>">
																	<?php echo $items->name; ?>
																</option>
																<?php
}
}
?>
															</select>
														</div>
													</td>
												</tr>
												<tr>
													<th scope="row">
														狀態
													</th>
													<td>
														<div class="input-group">
															<div id="radioBtn" class="btn-group">
																<?php
$active    = $show == 1 ? 'active' : 'notActive';
$notActive = $show == 0 ? 'active' : 'notActive';
?>
																<a class="btn btn-primary btn-sm <?php echo $active; ?>"
																	data-toggle="happy" data-title="Y">顯示</a>
																<a class="btn btn-primary btn-sm <?php echo $notActive; ?>"
																	data-toggle="happy" data-title="N">隱藏</a>
															</div>
															<input type="hidden" name="happy" id="happy">
														</div>
													</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<table class="table table-bordered">
											<thead>
												<tr>
													<th colspan="4" scope="col">學經歷</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<!-- <th>才會自帶粗體 -->
													<th class="text-center" scope="row">學歷</th>
													<td><textarea onkeyup="autogrow(this);" class="form-control"
															name="education"><?php echo $education; ?></textarea></td>
												</tr>
												<tr>
													<th class="text-center" scope="row">經歷</th>
													<td><textarea onkeyup="autogrow(this);" class="form-control"
															name="experience"><?php echo $experience; ?></textarea></td>
												</tr>
												<tr>
													<th class="text-center" scope="row">分區/不分區</th>
													<td><textarea onkeyup="autogrow(this);" class="form-control"
															name="districts"><?php echo $districts; ?></textarea></td>
												</tr>
												<tr>
													<th class="text-center" scope="row">各會期委員會</th>
													<td><textarea onkeyup="autogrow(this);" class="form-control"
															name="committee"><?php echo $committee; ?></textarea></td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<table class="table table-bordered" id="contact-table">
											<thead>
												<tr>
													<th colspan="3" scope="col">聯絡方式</th>
												</tr>
											</thead>
											<tbody class="not-tbody">
												<tr>
													<!-- <th>才會自帶粗體 -->
													<th class="text-center" style="width:170px;" scope="row">項目<input type="button"
															class="btn btn-sm btn-info btnAdd" style="margin-left:10px" value="新增" />
													</th>
													<th class="text-center" colspan="2" scope="row">內容</th>
												</tr>
												<?php
if (!empty($getContactChoice)) {
    foreach ($getContactChoice as $choice) {
        $getConId   = $choice->con_id;
        $getContact = $choice->records;
        ?>
												<tr class="contact-item">
													<th scope="row">
														<div class="form-group">
															<select style="padding:0 0 0 10px" class="form-control"
																name="contactList[]">
																<?php
if (!empty($getContactList)) {
            foreach ($getContactList as $items) {
                $conid   = $items->con_id;
                $contact = $items->contact;
                ?>
																<option value="<?php echo $conid; ?>"
																	<?php if ($conid == $getConId) {echo 'selected';}?>>
																	<?php echo $contact; ?>
																</option>
																<?php
}
        }
        ?>
															</select>
														</div>
													</th>
													<td>
														<div class="form-group">
															<input type="text" class="form-control" name="contact[]"
																value="<?php echo $getContact; ?>">
														</div>
													</td>
													<td style="width:50px">
														<div class="form-group">
															<input type="button" class="btn btn-danger btnRemove" value="移除" />
														</div>
													</td>
												</tr>
												<?php
}
} else {
    ?>
												<tr class="contact-item">
													<th scope="row">
														<div class="form-group">
															<select style="padding:0 0 0 10px" class="form-control"
																name="contactList[]">
																<?php
if (!empty($getContactList)) {
        foreach ($getContactList as $items) {
            ?>
																<option value="<?php echo $items->con_id; ?>"
																	<?php if ($items->con_id == 1) {echo 'selected';}?>>
																	<?php echo $items->contact; ?>
																</option>
																<?php
}
    }
    ?>
															</select>
														</div>
													</th>
													<td>
														<div class="form-group">
															<input type="text" class="form-control" name="contact[]" value="">
														</div>
													</td>
													<td style="width:50px">
														<div class="form-group">
															<input type="button" class="btn btn-danger btnRemove" value="移除" />
														</div>
													</td>
												</tr>
												<?php
}
?>
											</tbody>
										</table>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<table class="table table-bordered">
											<thead>
												<tr>
													<th colspan="2" scope="col">社群連結</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<th scope="row">
														Facebook
													</th>
													<td>
														<div class="form-group">
															<input type="text" class="form-control" id="fb" name="fb"
																value="<?php echo $fb; ?>">
														</div>
													</td>
												</tr>
												<tr>
													<th scope="row">
														Instagram
													</th>
													<td>
														<div class="form-group">
															<input type="text" class="form-control" id="ig" name="ig"
																value="<?php echo $ig; ?>">
														</div>
													</td>
												</tr>
												<tr>
													<th scope="row">
														Line
													</th>
													<td>
														<div class="form-group">
															<input type="text" class="form-control" id="line" name="line"
																value="<?php echo $line; ?>">
														</div>
													</td>
												</tr>
												<tr>
													<th scope="row">
														Youtube
													</th>
													<td>
														<div class="form-group">
															<input type="text" class="form-control" id="yt" name="yt"
																value="<?php echo $yt; ?>">
														</div>
													</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div><!-- /.box-body -->
						</form>
					</div><!-- add-edit-scroll -->
				</div><!-- box -->
			</div>
		</div>
		<!-- row -->

		<!-- 聯絡方式模板 -->
		<template class="temp">
			<tr class="contact-item">
				<th scope="row">
					<div class="form-group">
						<select style="padding:0 0 0 10px" class="form-control" name="contactList[]">
							<?php
if (!empty($getContactList)) {
    foreach ($getContactList as $items) {
        ?>
							<option value="<?php echo $items->con_id; ?>" <?php if ($items->con_id == 1) {echo 'selected';}?>>
								<?php echo $items->contact; ?>
							</option>
							<?php
}
}
?>
						</select>
					</div>
				</th>
				<td>
					<div class="form-group">
						<input type="text" class="form-control" name="contact[]" value="">
					</div>
				</td>
				<td style="width:50px">
					<div class="form-group">
						<input type="button" class="btn btn-danger btnRemove" value="移除" />
					</div>
				</td>
			</tr>
		</template>
	</section>
</div>
<template id="function-on-top">
	<div class="function-on-top">
		<div class="box" style="border-top:none;border-radius:0">
			<div class="box-header">
				<div class="row">
					<div class="col-xs-12">
						<div class="form-group">
							<a class="btn btn-warning" href="<?php echo $this->session->userdata('myRedirect'); ?>">返回</a>
							<input type="submit" class="btn btn-success" value="儲存" onclick="subMit();" />
						</div>
					</div>
				</div>
			</div><!-- /.box-header -->
		</div>
	</div>
</template>
<script language='javascript' type='text/javascript'>
	function subMit() {
		jQuery('#formSubmit').submit();
	}

	jQuery(document).ready(function () {
		// textarea自動依照內容增加高度
		function autogrow(textarea) {
			var adjustedHeight = textarea.clientHeight;

			adjustedHeight = Math.max(textarea.scrollHeight, adjustedHeight);
			if (adjustedHeight > textarea.clientHeight) {
				textarea.style.height = adjustedHeight + 'px';
			}
		}

		$('#select-issues').selectize({
			maxItems: null,
			plugins: ['remove_button'],
			sortField: { //排序
				field: 'id', // text:依據文本排序，id：依據value排序
				direction: 'asc' // 升序降序
			}
		});

		$('#select-years').selectize({
			maxItems: null,
			plugins: ['remove_button'],
			sortField: { //排序
				field: 'id', // text:依據文本排序，id：依據value排序
				direction: 'asc' // 升序降序
			}
		});

		var $selectYears = $('#select-years')[0].selectize;
		var yearArray = <?php echo json_encode($getYearsChoice); ?>;
		$selectYears.setValue(yearArray, true);

		var $selectIssues = $('#select-issues')[0].selectize;
		var issuesArray = <?php echo json_encode($getIssuesClassChoice); ?>;
		$selectIssues.setValue(issuesArray, true);

		// console.log($('link:last-of-type').attr('href'));
		// console.log($('link:last-child').attr('href'));
		// console.log($('link:last').attr('href'));
		// console.log($('link').last().attr('href'));
	});
</script>
<?php
$check = $this->session->flashdata('check');
if ($check) {
    ?>
<div id="alert-error" class="alert-absoulte error-width alert alert-danger alert-dismissable">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	<?php echo $check . '!<br>請修正以下提示錯誤!'; ?>
</div>
<?php
}
?>
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
<?php
$error = $this->session->flashdata('error');
if ($error) {
    ?>
<div id="alert-error" class="alert-absoulte error-width alert alert-danger alert-dismissable">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	<?php echo $error; ?>
</div>
<?php
}
?>
<style>
	.selectize-dropdown {
		top: 35px !important;
	}

	.table.table-bordered tbody:not(.not-tbody) th {
		width: 10%;
	}
</style>
<!-- <?php echo validation_errors('<div id="alert-error" class="alert-absoulte alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?> -->