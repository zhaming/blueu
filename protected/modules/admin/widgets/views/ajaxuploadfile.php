<div class="select-file-div">
    <div class="s-f-title">
        <div class="tit">文件上传</div>
        <div class="tit-msg"><?php echo $this->msg;?></div>
        <div class="add-file">添加文件<input id="1" type="file" title="添加文件" name="ufile"></div>
    </div>
    <div class="s-f-demo">
        <span class="file-name">未添加文件</span>
        <span class="del">删除</span>
        <span class="progress"></span>
    </div>
    <div class="s-f-submit">
        <div id="submit-upload" class="B01-BLUE btn-info btn-small">立即上传</div>
    </div>
</div>
<script>
$(function(){
     $(document).click(function(e){
        if($(e.target).closest(".upload-div").length == 0){
            if($('.upload-div').addClass('open')){
                $('.upload-div').slideUp();
            }
        }
    }); 
    $('.button-add').click(function(){
        $('.upload-div').slideDown(function(){$(this).addClass('open')});
        return false;
    });
    $('.s-f-onefile>span.del,.s-f-uploaded>span.del').die().live('click',function(){
        $(this).parent().slideUp(function(){
            $(this).remove();
        })
    });
    
    $('.add-file>input[type=file]').die().live("change",function(){
        var html = $('.s-f-demo');
        $('.s-f-submit').before(html.clone().removeClass('s-f-demo').addClass('s-f-onefile').prepend($(this)));
        var str = $(this).val();
        var path = str.split("\\");
        $(this).next().html(path[path.length-1]);
        var id=parseInt($(this).attr('id'));
        $(this).attr('id','file'+id);
        $('.add-file').prepend('<input id="'+(id+1)+'" type="file" title="添加文件" name="ufile"></div>');
    });
    $('#submit-upload').click(function(){
        upload();
    });
});

function upload(){
    if($('.uploading')[0]) return false;
    if(!$('.s-f-onefile')[0]) return false;
    var thisDiv = $('.s-f-onefile').eq(0);
    var id = $(thisDiv).children('input[type=file]').attr('id');
    <?php if('image'==$this->type){ ?>
    var filename=$('#'+id).val();
    var rgx=/(jpg|gif|png|rar)/i;
    var ext=filename.substring(filename.lastIndexOf(".")+1).toLowerCase();
    if(!rgx.test(ext)){
        alert("文件格式不支持！");
        return false;
    }
    <?php } ?>  
    $(thisDiv).children('.progress').html('正在上传...');
    $(thisDiv).addClass('uploading');
    $.ajaxFileUpload({
        url: <?php echo !empty($this->url)?'"'.$this->url.'"':'"/admin/file/upload"';?>,
        secureuri:false,
        fileElementId:id,
        dataType: 'json',
        success: function(data){
            if(data.status){
                $(thisDiv).children('.progress').html('上传完成');
                $(thisDiv).children('.del').html('隐藏');
                $(thisDiv).append('<input type="hidden" class="file-id" value="'+data.id+'">');
                $(thisDiv).removeClass('s-f-onefile').removeClass('uploading').addClass('s-f-uploaded');
                uploadCallBack(data);
                try{
                    eval(<?php echo $this->callback?>(data));    
                }catch(er){
                    // console.error(er);
                }
                upload();
            }else{
                $(thisDiv).children('.progress').html('上传失败');
            }
        },error:function(e){
            uploadError(e);
        }
    });
    return false;
}
function isUploadOver(){
    if($('.s-f-onefile')[0]){
        return false;
    }
    return true;
}
function hideUploaded(){
    $('.s-f-uploaded').slideUp(function(){
        $(this).remove();
    });
}
function uploadCallBack(data){}
function uploadError(e){}
</script>
