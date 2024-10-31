<div class="wrap"><div id="icon-options-general" class="icon32"><br></div><h2>RBX Slider Images</h2></div>
<h3>Add images for RBXslider</h3>
<div class="updated settings-error" id="msg_success" style="display: none;"><p><strong>Images successfully saved.</strong></p></div>
<div class="updated settings-error" id="msg_no_img" style="display: none;"><p><strong>Please select at least one image.</strong></p></div>
<form name='rbximagesupload' id="rbximagesupload" action="#" method='post'>
	<div>
		<input value='Upload Image' class='button-primary upload-image' type='button' id="upload_rbx_gallery_images" style='cursor:pointer;' /><input type='button' name="saveimages" id="saveimages" onclick="saverbximages();" class='savebtn button-primary' value='Save'>
	</div>
	<div id="rbxsliderimages">
	</div>
</form>
<script type="text/javascript">
	var arr =[];
	var ar = [];
	var thumb_array = [];
	var count = 0;
	jQuery('#upload_rbx_gallery_images').live('click', function( event ){
		event.preventDefault();
		file_frame = wp.media.frames.file_frame = wp.media({
			title: "Upload Images in RBX Slider [Press Shift or Ctrl Key Select Multiple Images]",
			button: {
				text: "Select Images",
			},
			multiple: true
		});
		
		file_frame.on( 'select', function() {
			var selection = file_frame.state().get('selection');
			selection.map( function( attachment ) {
				
					attachment = attachment.toJSON();
					var dynamicId = Math.floor((Math.random() * 1000)+1);
					thumb_array.push(attachment.url);
					arr.push(attachment.url);
					ar.push(dynamicId);
					var main_div = jQuery("<div class=\"block\" id=\""+dynamicId+"\" >");
					var block = jQuery("<div class=\"block\" style=\"margin-right:1%;float:left\">");
					var img = jQuery("<img class=\"imgHolder\" style=\"border:2px solid #e5e5e5;margin-top:10px;cursor: pointer;\" id=\"up_img\"/>");
					img.attr('src', attachment.url);
					img.attr('width', '200px');
					img.attr('height', '200px');
					block.append(img);
					var title = jQuery("<br/><input type='text' id=\"title_"+dynamicId+"\" name=\"title_"+dynamicId+"\" placeholder='Image Title' title='Image Title' style='width: 100%;' />");
					block.append(title);
					var description = jQuery("<br/><textarea id=\"desc_"+dynamicId+"\" name=\"desc_"+dynamicId+"\" placeholder='Image Description' title='Image Description' style='width: 100%;margin-bottom: 0px;' ></textarea>");
					block.append(description);
					var slidelink = jQuery("<br/><input type='text' id=\"slink_"+dynamicId+"\" name=\"slink_"+dynamicId+"\" placeholder='Image Link' title='Image link' style='width: 100%;margin-top: 0px;' />");
					block.append(slidelink);
					var del = jQuery("<br/><a class=\"imgHolder orange\" style=\"margin-left: 30px;cursor: pointer;\" id=\"del_img\" onclick=\"delete_pic("+dynamicId+")\"><span style='margin-right: 4px;top: 2px;' class='glyphicon glyphicon-remove'></span>Remove Image</a>");
					block.append(del);
					block.append("</div>");
					main_div.append(block);
					main_div.append("</div>");
					
					jQuery("#rbxsliderimages").append(main_div);
					count++;
			});
		});
		file_frame.open();
	});
	
	function delete_pic(id)
	{
		jQuery("#"+id).remove();
		if(ar.indexOf(id) > -1) 
		{
			var index = ar.indexOf(id);
			arr.splice(index, 1);
			ar.splice(index, 1);
			thumb_array.splice(index, 1);
			count--;
		}
	}
	
	function saverbximages()
	{
		if(count == 0)
		{
			jQuery("#msg_no_img").css("display","block");
			setTimeout(function(){
				jQuery("#msg_no_img").css("display","none");
			},2000);
		}
		else
		{
			jQuery.post(ajaxurl, jQuery("#rbximagesupload").serialize() + "&dids=" + ar + "&paths="+ arr + "&param=save_rbx_images&action=rbxgallerylib", function(data)
			{
				jQuery("#msg_success").css("display","block");
				setTimeout(function(){
					window.location.reload();
				},2000);
			});
		}
	}
</script>
