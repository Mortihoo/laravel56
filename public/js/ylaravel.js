let E = window.wangEditor;
let editor = new E('#editor');
if($("#editor")){
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

$(".preview_input").change(function(event){
    console.log("change avatar");
    let file = event.currentTarget.files[0];
    let url = window.URL.createObjectURL(file);
    $(event.target).next(".preview_img").attr("src",url);
});