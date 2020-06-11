/**
 * File : addUser.js
 *
 * This file contain the validation of add user form
 *
 * Using validation plugin : jquery.validate.js
 *
 * @author Kishor Mali
 */

$(document).ready(function () {

	var addUserForm = $("#addUser");

	var validator = addUserForm.validate({

		rules: {
			fname: {
				required: true
			},
			email: {
				required: true,
				email: true,
				remote: {
					url: baseURL + "checkEmailExists", //直接到User.php的checkEmailExists驗證
					type: "post"
				}
			},
			password: {
				required: true
			},
			cpassword: {
				required: true,
				equalTo: "#password"
			},
			mobile: {
				required: true,
				digits: true
			},
			role: {
				required: true,
				selected: true
			}
		},
		messages: {
			fname: {
				required: "這是必填欄"
			},
			email: {
				required: "這是必填欄",
				email: "請輸入有效的電子郵件地址",
				remote: "郵件地址已存在"
			},
			password: {
				required: "這是必填欄"
			},
			cpassword: {
				required: "這是必填欄",
				equalTo: "請輸入相同的密碼"
			},
			mobile: {
				required: "這是必填欄",
				digits: "請只輸入數字"
			},
			role: {
				required: "這是必填欄",
				selected: "請選擇至少一個選項"
			}
		}
	});
});