/**
 * @author Kishor Mali
 */

jQuery(document).ready(function () {
	jQuery(document).on('click', '.deleteUser', function () {
		var userId = $(this).data('delid'),
			hitURL = baseURL + 'deleteUser',
			currentRow = $(this),
			l = $('.table tbody tr').length,
			link = window.location.href

		if (l == 2) {
			reDirect = link.substring(0, link.lastIndexOf('/') + 1);
		} else {
			reDirect = link;
		}

		var confirmation = confirm('確認刪除此人員 ?')

		if (confirmation) {
			jQuery
				.ajax({
					type: 'POST',
					dataType: 'json',
					url: hitURL,
					data: {
						userId: userId,
					},
				})
				.done(function (data) {
					if (data.status) {
						alert("成功刪除");

						currentRow.parents('tr').remove()
						window.location.href = reDirect
					} else if (!data.status) {
						alert("刪除失敗!");
					} else {
						alert("拒絕訪問..!");
					}
				})
				.fail(function (jqXHR, textStatus, errorThrown) {
					// serrorFunction();
				});
		}
	})

	jQuery(document).on('click', '.newsListDel', function () {
		var pr_id = $(this).data('delid'),
			type_id = $(this).data('typeid'),
			img = $(this).data('img'),
			hitURL = baseURL + 'news/newsListDel',
			currentRow = $(this),
			l = $('.table tbody tr').length,
			link = window.location.href

		// console.log(l); // 含標題

		if (l == 2) {
			reDirect = link.substring(0, link.lastIndexOf('/') + 1);
		} else {
			reDirect = link;
		}

		switch (type_id) {
			case 1:
				var confirmation = confirm('確認刪除此法案及議事 ?')
				break
			case 2:
				var confirmation = confirm('確認刪除此懶人包及議題 ?')
				break
			case 3:
				var confirmation = confirm('確認刪除此行動紀實 ?')
				break

			default:
				break
		}

		if (confirmation) {
			jQuery
				.ajax({
					type: 'POST',
					dataType: 'json',
					url: hitURL,
					data: {
						pr_id: pr_id,
						type_id: type_id,
						img: img,
					},
				})
				.done(function (data) {
					if (data.status) {
						alert("成功刪除");

						currentRow.parents('tr').remove()
						window.location.href = reDirect
					} else if (!data.status) {
						alert("刪除失敗!");
					} else {
						alert("拒絕訪問..!");
					}
				})
		}
	})

	jQuery(document).on('click', '.deleteNewsTag', function () {
		var tagid = $(this).data('tagsid'),
			hitURL = baseURL + 'news/deleteNewsTag',
			currentRow = $(this),
			l = $('.table tbody tr').length,
			link = window.location.href

		// console.log(l); // 含標題
		if (l == 2) {
			reDirect = link.substring(0, link.lastIndexOf('/') + 1);
		} else {
			reDirect = link;
		}

		var confirmation = confirm('確認刪除此標籤 ?')

		if (confirmation) {
			jQuery
				.ajax({
					type: 'POST',
					dataType: 'json',
					url: hitURL,
					data: {
						tags_id: tagid,
					},
				})
				.done(function (data) {
					if (data.status) {
						alert("成功刪除");

						currentRow.parents('tr').remove()
						window.location.href = reDirect
					} else if (!data.status) {
						alert("刪除失敗!");
					} else {
						alert("拒絕訪問..!");
					}
				})
		}
	})

	jQuery(document).on('click', '.deleteCarousel', function () {
		var carouselid = $(this).data('carouselid'),
			img = $(this).data('img'),
			// count = $(this).data('count'),
			hitURL = baseURL + 'website/deleteCarousel',
			currentRow = $(this),
			link = window.location.href


		// var _totalPage = Math.ceil(count / 10); // 從db獲取總數計算出總頁數
		// var _curPage = link.substring(link.lastIndexOf('/') + 1); //算出當前頁數,若=_totalPage爲最後一頁
		var l = $('.table tbody tr').length; // 以上解決方案,只要算出該頁面的tr數量即可
		// console.log(l); // 含標題

		if (l == 2) {
			reDirect = link.substring(0, link.lastIndexOf('/') + 1);
		} else {
			reDirect = link;
		}

		var confirmation = confirm('確認刪除此輪播項目 ?')

		if (confirmation) {
			jQuery
				.ajax({
					type: 'POST',
					dataType: 'json',
					url: hitURL,
					data: {
						id: carouselid,
						img: img,
					},
				})
				.done(function (data) {
					if (data.status) {
						alert("成功刪除");

						currentRow.parents('tr').remove()
						window.location.href = reDirect
					} else if (!data.status) {
						alert("刪除失敗!");
					} else {
						alert("拒絕訪問..!");
					}
				})
		}
	})

	jQuery(document).on('click', '.deleteManager', function () {
		var userId = $(this).data('delid'),
			hitURL = baseURL + 'user/deleteManager',
			currentRow = $(this),
			l = $('.table tbody tr').length,
			link = window.location.href

		if (l == 2) {
			reDirect = link.substring(0, link.lastIndexOf('/') + 1);
		} else {
			reDirect = link;
		}

		var confirmation = confirm('確認刪除此人員 ?')

		if (confirmation) {
			jQuery
				.ajax({
					type: 'POST',
					dataType: 'json',
					url: hitURL,
					data: {
						userId: userId,
					},
				})
				.done(function (data) {
					if (data.status) {
						alert("成功刪除");

						currentRow.parents('tr').remove()
						window.location.href = reDirect
					} else if (!data.status) {
						alert("刪除失敗!");
					} else {
						alert("拒絕訪問..!");
					}
				})
		}
	})

	jQuery(document).on('click', '.deleteYears', function () {
		var yid = $(this).data('yid'),
			hitURL = baseURL + 'members/deleteYears',
			currentRow = $(this),
			l = $('.table tbody tr').length,
			link = window.location.href

		// console.log(l); // 含標題

		if (l == 2) {
			reDirect = link.substring(0, link.lastIndexOf('/') + 1);
		} else {
			reDirect = link;
		}

		var confirmation = confirm('確認刪除此屆期 ?')

		if (confirmation) {
			jQuery
				.ajax({
					type: 'POST',
					dataType: 'json',
					url: hitURL,
					data: {
						yid: yid,
					},
				})
				.done(function (data) {
					if (data.status) {
						alert("成功刪除");

						currentRow.parents('tr').remove()
						window.location.href = reDirect
					} else if (!data.status) {
						alert("刪除失敗!");
					} else {
						alert("拒絕訪問..!");
					}
				})
		}
	})

	jQuery(document).on('click', '.deleteIssuesAll', function () {
		var id = $(this).data('id'),
			img = $(this).data('img'),
			hitURL = baseURL + 'issues/deleteIssuesAll',
			currentRow = $(this),
			l = $('.table tbody tr').length,
			link = window.location.href

		// console.log(l); // 含標題

		if (l == 2) {
			reDirect = link.substring(0, link.lastIndexOf('/') + 1);
		} else {
			reDirect = link;
		}

		var confirmation = confirm('確認刪除此議題列表 ?')

		if (confirmation) {
			jQuery
				.ajax({
					type: 'POST',
					dataType: 'json',
					url: hitURL,
					data: {
						id: id,
						img: img,
					},
				})
				.done(function (data) {
					if (data.status) {
						alert("成功刪除");

						currentRow.parents('tr').remove()
						window.location.href = reDirect
					} else if (!data.status) {
						alert("刪除失敗!");
					} else {
						alert("拒絕訪問..!");
					}
				})
		}
	})

	jQuery(document).on('click', '.deleteIssuesClass', function () {
		var id = $(this).data('id'),
			img = $(this).data('img'),
			hitURL = baseURL + 'issues/deleteIssuesClass',
			currentRow = $(this),
			l = $('.table tbody tr').length,
			link = window.location.href

		// console.log(l); // 含標題

		if (l == 2) {
			reDirect = link.substring(0, link.lastIndexOf('/') + 1);
		} else {
			reDirect = link;
		}

		var confirmation = confirm('確認刪除此議題類別 ?')

		if (confirmation) {
			jQuery
				.ajax({
					type: 'POST',
					dataType: 'json',
					url: hitURL,
					data: {
						ic_id: id,
						img: img,
					},
				})
				.done(function (data) {
					if (data.status) {
						alert("成功刪除");

						currentRow.parents('tr').remove()
						window.location.href = reDirect
					} else if (!data.status) {
						alert("刪除失敗!");
					} else {
						alert("拒絕訪問..!");
					}
				})
		}
	})

	jQuery(document).on('click', '.deleteMembers', function () {
		var id = $(this).data('id'),
			img = $(this).data('img'),
			hitURL = baseURL + 'members/deleteMembers',
			currentRow = $(this),
			l = $('.table tbody tr').length,
			link = window.location.href

		if (l == 2) {
			reDirect = link.substring(0, link.lastIndexOf('/') + 1);
		} else {
			reDirect = link;
		}

		var confirmation = confirm('確認刪除此黨員 ?')

		if (confirmation) {
			jQuery
				.ajax({
					type: 'POST',
					dataType: 'json',
					url: hitURL,
					data: {
						id: id,
						img: img
					},
				})
				.done(function (data) {
					if (data.status) {
						alert("成功刪除");

						currentRow.parents('tr').remove()
						window.location.href = reDirect
					} else if (!data.status) {
						alert("刪除失敗!");
					} else {
						alert("拒絕訪問..!");
					}
				})
		}
	})

	// var link = window.location.href,
	// 	_lastValue = link.substring(link.lastIndexOf('/') + 1),
	// 	ary = link.split('/'),
	// 	arySplit = ary[ary.length - 1].split('#')
	// jQuery(document).on('click', '.searchList', function () {})
})