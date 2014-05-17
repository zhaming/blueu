<script language="javascript" type="text/javascript" src="/statics/plugins/xheditor/xheditor-1.1.14-zh-cn.min.js"></script>
<textarea name='content' id="editor" class="input-xlarge"><?php echo $this->content?></textarea>
<script type='text/javascript'>
$(document).ready(function(){
	$('#editor').xheditor({skin:'nostyle',internalStyle:true,inlineStyle:true,linkTag:true,width:<?php echo $this->width;?>,height:300,tools:'Cut,Copy,Paste,Pastetext,Blocktag,Fontface,FontSize,Bold,Italic,Underline,Strikethrough,FontColor,BackColor,SelectAll,Removeformat,Align,List,Outdent,Indent,Link,Unlink,Img,Table,Source,Fullscreen',upImgUrl:'/files/editorUpload',html5Upload:false});
});
</script>
