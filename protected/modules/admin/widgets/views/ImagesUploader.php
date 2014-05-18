<!--
<div class="demo">
	<form id="uploadForm" action="/files/upload" method="post" enctype="multipart/form-data">
        <div class="upload_box">
            <div class="upload_main">
                <div class="upload_choose">
                    <input id="fileImage" type="file" size="30" name="file[]" multiple="">
					<span id="fileDragArea" class="upload_drag_area">或者将图片拖到此处</span>
                </div>
                <div id="preview" class="upload_preview"></div>
            </div>
            <div class="upload_submit">
                <button type="button" id="fileSubmit" class="upload_submit_btn">确认上传图片</button>
            </div>
            <div id="uploadInf" class="upload_inf"></div>
        </div>
    </form>
</div>
-->
<link href="/statics/backend/styles/images_manage.css" rel="stylesheet" type="text/css" />
<input id="fileImage" type="file" size="30" name="file[]" multiple="">
<button type="button" id="fileSubmit" class="upload_submit_btn">确认上传图片</button>

<input type="hidden" id="image_id" name="image_id" value="<?php echo $this->cover;?>" />
<input type="hidden" id="image_ids" name="image_ids" value="<?php echo $this->images;?>" />
<input type="hidden" id="del_image_ids" name="del_image_ids" value="" />
<div id="preview" class="upload_preview">
<!--
<div id="uploadList_0" class="upload_append_list">
	<img id="uploadImage_0" src="http://sites.wanthings.dev/images/3f08ae83e87f3652e5b859f83af92066.jpg" class="upload_image">
	<div class="progress_div">
		<strong>45646543132.jpe</strong>
		<div class="progress progress-striped active">
 			<div class="bar" style="width: 0%;"></div>
		</div>
	</div>
	<a href="javascript:" class="upload_delete" title="删除" data-index="0">删除</a>
</div>
-->
</div>

















<ul id="album">
<!--
	<li>
		<img src='http://lotusbuy.dev/images/2d5d004debb7cd7e12a464de8b112d55.jpg'>
		<a href='javascript:void(0);' onclick='javascript:setImageId("+data2.id+",$(this).parent());'>设为封面</a>
		<a target='_blank' href='"+data2.origin+"'>查看原图</a>
		<span onclick='javascript:delImage("+data2.id+",$(this).parent());'>x</span>
	</li>
-->
</ul>

<div id="uploadInf" class="upload_inf"></div>

<script>

function addImage(data)
{
	if($("#"+data).html()==null)
	{
		setImageIds(data);

		$css="";
		if($('#image_id').val()==data)
		{
			$css = "actived";
		}
		$img = 	"<li id='"+data+"' class='"+$css+"'>"
			+"<img src='/images/"+data+"_w-120_h-120_c.jpg'>"
			+"<a href='javascript:void(0);' onclick='javascript:imageActived(\""+data+"\");'>设为封面</a> "
			+"<a target='_blank' href='/images/"+data+".jpg'>查看原图</a>"
			+"<span onclick='javascript:delImage(\""+data+"\");'>x</span>"
		+"</li>";
		$('#album').append($img);
	}else{
		alert('照片已经存在');
	}
}

function imageActived(id)
{
	$('#image_id').val(id);
	$("#album").children('.actived').removeClass('actived');
	$("#"+id).addClass("actived");
}


//定义设置image_id方法
function setImageIds(args) 
{
	var $image_id = $('#image_id');//封面图片ID
	var $image_ids = $('#image_ids');
	if($image_id.val()=="")
	{
		$image_id.val(args);
	}
	if($image_ids.val()=="")
	{
		$image_ids.val(args);
	}else{
		$image_ids.val($image_ids.val()+','+args);
	}
}




delImage = function(id){
	if(id == $('#image_id').val())
	{
		alert('该图片为封面图片，请先设置其他封面图片，再点删除该图片');
		return false;
	}
	var $del_image_ids = $('#del_image_ids');

	if($del_image_ids.val()=="")
	{
		$del_image_ids.val(id);
	}else{
		$del_image_ids.val($del_image_ids.val()+','+id);
	}
	$("#"+id).remove();
}


init();
function init()
{
	if($("#image_ids").val()!='')
	{
		var $images = new Array;
		$images = $("#image_ids").val().split(',');
		$("#image_ids").val("");//清空
		for(i=0;i<$images.length;i++){
			addImage($images[i]);
		}
	}
}


</script>






<script src="/statics/plugins/zxxFile.js"></script>
<script>
var params = {
	fileInput: $("#fileImage").get(0),
//	dragDrop: $("#fileDragArea").get(0),
	upButton: $("#fileSubmit").get(0),
	url: '/files/upload',
//	url: $("#uploadForm").attr("action"),
	filter: function(files) {
		var arrFiles = [];
		for (var i = 0, file; file = files[i]; i++) {
			if (file.type.indexOf("image") == 0 || (!file.type && /\.(?:jpg|png|gif)$/.test(file.name) /* for IE10 */)) {
				if (file.size >= 5120000) {
					alert('您这张"'+ file.name +'"图片大小过大，应小于5M');	
				} else {
					arrFiles.push(file);	
				}			
			} else {
				alert('文件"' + file.name + '"不是图片。');	
			}
		}
		return arrFiles;
	},
	onSelect: function(files) {
		var html = '', i = 0;
		$("#preview").html('<div class="upload_loading"></div>');
		var funAppendImage = function() {
			file = files[i];
			if (file) {
				var reader = new FileReader()
				reader.onload = function(e) {
					html = html + '<div id="uploadList_'+ i +'" class="upload_append_list">' +
						'<img id="uploadImage_' + i + '" src="' + e.target.result + '" class="upload_image" />'+ 
						'<div class="progress_div">' +
							'<strong>' + file.name + '</strong>'+
							'<div id="uploadProgress_' + i + '" class="progress progress-striped active"><div class="bar" style="width: 0%;"></div></div>' +
						'</div><a href="javascript:" class="upload_delete" title="删除" data-index="'+ i +'">删除</a><br />' +
					'</div>';

					i++;
					funAppendImage();
				}
				reader.readAsDataURL(file);
			} else {
				$("#preview").html(html);
				if (html) {
					//删除方法
					$(".upload_delete").click(function() {
						ZXXFILE.funDeleteFile(files[parseInt($(this).attr("data-index"))]);
						return false;	
					});
					//提交按钮显示
					$("#fileSubmit").show();	
				} else {
					//提交按钮隐藏
					$("#fileSubmit").hide();	
				}
			}
		};
		funAppendImage();		
	},
	onDelete: function(file) {
		$("#uploadList_" + file.index).fadeOut();
	},
/*
	onDragOver: function() {
		$(this).addClass("upload_drag_hover");
	},
	onDragLeave: function() {
		$(this).removeClass("upload_drag_hover");
	},
*/
	onProgress: function(file, loaded, total) {
		var eleProgress = $("#uploadProgress_" + file.index), percent = (loaded / total * 100).toFixed(2) + '%';
		eleProgress.show().children('.bar').css('width',percent+'%');
	},
	onSuccess: function(file, response) {
		//$("#uploadInf").append("<p>上传成功，图片地址是："+ response +"</p>");
		data = eval("("+response+")");//转换为json对象
		addImage(data.hash);
	},
	onFailure: function(file) {
		$("#uploadInf").append("<p>图片" + file.name + "上传失败！</p>");
		$("#uploadImage_" + file.index).css("opacity", 0.2);
	},
	onComplete: function() {
		//提交按钮隐藏
		$("#fileSubmit").hide();
		//file控件value置空
		$("#fileImage").val("");
		$("#uploadInf").append("<p>当前图片全部上传完毕，可继续添加上传。</p>");
	}
};
ZXXFILE = $.extend(ZXXFILE, params);
ZXXFILE.init();
</script>
