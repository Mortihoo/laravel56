let E = window.wangEditor;
let editor = new E('#editor');
if ($("#editor")) {
    let $text1 = $('#content');
    editor.customConfig.onchange = function (html) {
        // 监控变化，同步更新到 textarea
        $text1.val(html);
    };
    editor.customConfig.debug = true;
    editor.customConfig.uploadImgServer = '/posts/upload';
    editor.customConfig.uploadImgHeaders = {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    };
// 或者 var editor = new E( document.getElementById('editor') )
    editor.create();
}

$(".preview_input").change(function (event) {
    console.log("change avatar");
    let file = event.currentTarget.files[0];
    let url = window.URL.createObjectURL(file);
    $(event.target).next(".preview_img").attr("src", url);
});

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(".like-button").click(function (event) {
    let target = $(event.target);
    let current_like = target.attr("like-value");
    let user_id = target.attr("like-user");
    //var _token = target.attr("_token");
    // 已经关注了
    if (current_like == 1) {
        // 取消关注
        $.ajax({
            url: "/user/" + user_id + "/unfan",
            method: "POST",
            //data: {"_token": _token},
            dataType: "json",
            success: function success(data) {
                if (data.error != 0) {
                    alert(data.msg);
                    return;
                }

                target.attr("like-value", 0);
                target.text("关注");
            }
        });
    } else {
        // 取消关注
        $.ajax({
            url: "/user/" + user_id + "/fan",
            method: "POST",
            //data: {"_token": _token},
            dataType: "json",
            success: function success(data) {
                if (data.error != 0) {
                    alert(data.msg);
                    return;
                }

                target.attr("like-value", 1);
                target.text("取消关注");
            }
        });
    }
});