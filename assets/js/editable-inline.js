// 行內編輯
$(function () {
	$('.title-name').editable({
		type: "text", //编辑框的类型。支持 text|textarea|select|date|checklist 等
		title: "標題名稱", //编辑框的标题
		disabled: false, //是否禁用编辑
		emptytext: "空文本", //空值的默认文本
		mode: "inline", //编辑框的模式：支持 popup 和 inline 两种模式，默认是popup
		validate: function (value) { //字段验证
			if (!$.trim(value)) {
				return '不能爲空';
			}
		},
		url: function (param) {
			var encode = '';
			for (var i = 0; i < param.value.length; i++) {
				encode += "\\u" + param.value.charCodeAt(i).toString(16);
			}

			// var encode = param.value.codePointAt();
			// var encode = encodeURIComponent(param.value)
			var hitURL = baseURL + "legislator/yearSend/" + param.pk + "/" + encode;
			console.log('value', param.value.length);
			console.log('pk', param.pk);
			console.log('encode', encode);
			$.ajax({
				type: 'POST',
				url: hitURL,
				data: {
					yearid: param.pk,
					title: encode
				},
				dataType: 'JSON',
				success: function (res) {
					if (res.message != null && res.message != '') {
						setMessage(res.message);
						// $(".editable-inline").attr("action", baseURL + 'legislator');
						// window.location.href = baseURL + 'legislator';
					}
				},
				error: function (err) {}
			});
		}
	});
});