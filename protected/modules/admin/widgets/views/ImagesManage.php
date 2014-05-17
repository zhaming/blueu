<link href="/statics/backend/styles/images_manage.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/statics/plugins/ajaxfileupload.js"></script>
<input type="hidden" id="image_id" name="image_id" value="<?php echo $this->cover;?>" />
<input type="hidden" id="image_ids" name="image_ids" value="<?php echo $this->images;?>" />
<input type="hidden" id="del_image_ids" name="del_image_ids" value="" />
<?php
if(empty($this->viewer))
{
?>
<!--<input id="fileToUpload" type="file" size="45" name="file[]"  multiple>-->
<input id="fileToUpload" type="file" size="45" name="file"  multiple>
<button class="button" id="buttonUpload" onclick="return ajaxFileUpload();">Upload</button>
<?php
}
?>
<ul id="blacklist">
<!--
	<li>
		<img src='http://lotusbuy.dev/images/2d5d004debb7cd7e12a464de8b112d55.jpg'>
		<a href='javascript:void(0);' onclick='javascript:setImageId("+data2.id+",$(this).parent());'>设为封面</a>
		<a target='_blank' href='"+data2.origin+"'>查看原图</a>
		<span onclick='javascript:delImage("+data2.id+",$(this).parent());'>x</span>
	</li>
-->
</ul>



<script type="text/javascript">
function ajaxFileUpload()
{
//		$("#loading")
//		.ajaxStart(function(){
//			$(this).show();
//		})
//		.ajaxComplete(function(){
//			$(this).hide();
//		});

	$.ajaxFileUpload
	(
		{
			url:'/files/upload',
			secureuri:false,
			fileElementId:'fileToUpload',
			dataType: 'json',
			success: function (data, status)
			{
				if(typeof(data.error) != 'undefined')
				{
					alert(data.error);
				}else{
					addImage(data.hash);
				}
			},
			error: function (data, status, e)
			{
				alert(e);
			}
		}
	)
	return false;
}

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
		$('#blacklist').append($img);
	}else{
		alert('照片已经存在');
	}
}

function imageActived(id)
{
	$('#image_id').val(id);
	$("#blacklist").children('.actived').removeClass('actived');
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
