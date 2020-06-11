/**
 * File : editUser.js
 *
 * This file contain the validation of edit user form
 *
 * @author Kishor Mali
 */
$(document).ready(function () {

	var editUserForm = $("#editUser");

	var validator = editUserForm.validate({

		rules: {
			fname: {
				required: true
			},
			email: {
				required: true,
				email: true,
				remote: {
					url: baseURL + "checkEmailExists",
					type: "post",
					data: {
						userId: function () {
							return $("#userId").val();
						}
					}
				}
			},
			cpassword: {
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
			cpassword: {
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

	var editProfileForm = $("#editProfile");

	var validator = editProfileForm.validate({

		rules: {
			fname: {
				required: true
			},
			mobile: {
				required: true,
				digits: true
			},
			email: {
				required: true,
				email: true,
				remote: {
					url: baseURL + "checkEmailExists",
					type: "post",
					data: {
						userId: function () {
							return $("#userId").val();
						}
					}
				}
			},
		},
		messages: {
			fname: {
				required: "這是必填欄"
			},
			mobile: {
				required: "這是必填欄",
				digits: "請只輸入數字"
			},
			email: {
				required: "這是必填欄",
				email: "請輸入有效的電子郵件地址",
				remote: "郵件地址已存在"
			},
		}
	});

});