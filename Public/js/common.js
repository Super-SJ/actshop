$(function(){
    $('.btn_reset').click(function(){
        $(":text").val('');
        $(this).parents('form').find('select').each(function(){
            $(this).find('option').eq(0).attr('selected','selected');
        });
        $(this).parents('form').find(':radio').each(function(){
            $(this).prop('checked',false);
        });
        $('#strBatchMd5').val('');
        $('#strBatchFileMd5').val('');
        $(this).parents('.layui-form').submit();
    });
});

//ajax 提交
function ajaxpost(reurl,isparent) {
	var url = $("#form").attr('action');
	var data = $('#form').serialize();
	var index = null;
	$.ajax({
		type: "post",
		url: url,
		data: data,
		dataType: "json",
		beforeSend: function (request) {
			index = layer.load();
		},
		success: function (msg) {
			layer.close(index);
			if (msg.ret == "0") {
				layer.alert(msg.msg, {
					icon: 1,
					success: function(){
						$(document).on('keydown',function () {
							if (window.event && window.event.keyCode == 13) {
								window.event.returnValue = false;
							}
						});
					},
					end:function(){
						if(isparent == 1){
							if (reurl == undefined) {
								parent.window.location.reload();
							} else {
								parent.window.location.href = reurl;
							}
						}else{
							if (reurl == undefined) {
								location.href=document.referrer;
							} else {
								window.location.href = reurl;
							}
						}
					}});
			}else{
				layer.alert(msg.msg, {
					icon: 2
				});
			}
		}
	});
}

//ajax 操作
function execute(query, url, exam, reurl) {
	layer.confirm("是否" + exam + "?", {
				btn: ['确定', '取消'],
				success: function(){
					$(document).on('keydown',function () {
						if (window.event && window.event.keyCode == 13) {
							window.event.returnValue = false;
						}
					});
				}
			},
			function () {
				var index = null;
				$.ajax({
					type: "get",
					url: url,
					data: query,
					dataType: "json",
					beforeSend: function (request) {
						index = layer.load();
					},
					success: function (msg) {
						layer.close(index);
						if (msg.ret == "0") {
							layer.alert(exam + "成功", {
								icon: 1,
								end:function(){
									if (reurl == undefined) {
										window.location.reload();
									} else {
										window.location.href = reurl;
									}}});
						} else {
							layer.alert(msg.msg, {
								icon: 2,
							});
						}
					}
				});
			});
}

/**
 * 显示系统时间
 */

//第一次调用，避免需要加载1S的情况
show_cur_times();
//设置1秒调用一次show_cur_times函数
setInterval("show_cur_times()", 1000);

function show_cur_times() {
	//获取当前日期
	var date_time = new Date();
	//定义星期
	var week;
	//switch判断
	switch (date_time.getDay()) {
		case 1:
			week = "星期一";
			break;
		case 2:
			week = "星期二";
			break;
		case 3:
			week = "星期三";
			break;
		case 4:
			week = "星期四";
			break;
		case 5:
			week = "星期五";
			break;
		case 6:
			week = "星期六";
			break;
		default:
			week = "星期天";
			break;
	}

	//年
	var year = date_time.getFullYear();
	//判断小于10，前面补0
	if (year < 10) {
		year = "0" + year;
	}

	//月
	var month = date_time.getMonth() + 1;
	//判断小于10，前面补0
	if (month < 10) {
		month = "0" + month;
	}

	//日
	var day = date_time.getDate();
	//判断小于10，前面补0
	if (day < 10) {
		day = "0" + day;
	}

	//时
	var hours = date_time.getHours();
	//判断小于10，前面补0
	if (hours < 10) {
		hours = "0" + hours;
	}

	//分
	var minutes = date_time.getMinutes();
	//判断小于10，前面补0
	if (minutes < 10) {
		minutes = "0" + minutes;
	}

	//秒
	var seconds = date_time.getSeconds();
	//判断小于10，前面补0
	if (seconds < 10) {
		seconds = "0" + seconds;
	}

	//拼接年月日时分秒
	var date_str = year + "-" + month + "-"  + day +"　"+week+ "　"+ hours + ":" + minutes + ":" + seconds;

	//显示在id为showtimes的容器里
	$("#showtimes").html(date_str);
}

//获取url参数
function getQueryString(name) {
	var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
	var r = window.location.search.substr(1).match(reg);
	if (r != null) return unescape(r[2]); return null;
}

