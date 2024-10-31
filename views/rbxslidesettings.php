<?php
global $wpdb;
$slides = $wpdb->get_results
(
	$wpdb->prepare
	(
		"SELECT * FROM ". rbx_gallery() ." ORDER BY id ASC",""
	)
);	
?>
<div class="wrap"><div id="icon-options-general" class="icon32"><br></div><h2>RBX Settings</h2>
<div id="slidershortcode" class="updated settings-error"> 
	<p style="float: left;"><strong>Shortcode for Slider: [rbxslider]</strong></p>
	<p style="margin-left: 25%;"><strong>Shortcode for Gallery: [rbxgallery]</strong></p>
</div>

<table class="wp-list-table widefat fixed posts" cellpadding="0">
	<thead>
		<tr>
			<th style="width: 6%;">Order</th>
			<th><a href="javascript:void(0);"><span>Title</span></a></th>
			<th>Thumbnail</th>
			<th style="width: 18%;">Description</th>
			<th style="width: 18%;">Slide Link</th>
			<th style="width: 18%;">Effect</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
	<?php
	$upload_dir = wp_upload_dir();
	if(count($slides) == 0){
		?>
			<tr><td>No Slide Uploaded Yet.</td></tr>
		<?php
	}
	else{
			
		foreach ($slides as $slide) {
			?>
			<tr id="<?php echo 'row_'.$slide->id; ?>">

				<td><input type="text" name="id" class="id numeric" value="<?php echo $slide->id; ?>" size="2" /></td>
				<td><input type="text" class="title" name="title" value="<?php echo $slide->title; ?>" size="12" /></td>
				<td><img src="<?php echo $slide->path;  ?>" style="height:70px; width:100px;"  /></td>
				<td><textarea class="description" name="description"><?php echo $slide->description; ?></textarea></td>
				<td><input type="text" name="slide_link" class="slide_link"  value="<?php echo $slide->slide_link; ?>" /><br /><span class="description">e.g. "http://www.google.com"</span></td>
				<td>
					<select name="effect" class="effect">
						<option <?php if($slide->effect=='random'){ echo 'selected="selected"';} ?> value="random">Random</option>
						<option <?php if($slide->effect=='sliceDown'){ echo 'selected="selected"';} ?> value="sliceDown">Slice Down</option>
						<option <?php if($slide->effect=='sliceUp'){ echo 'selected="selected"';} ?> value="sliceUp">Slice Up</option>
						<option <?php if($slide->effect=='sliceUpDown'){ echo 'selected="selected"';} ?> value="sliceUpDown">Slice Up Down</option>
						<option <?php if($slide->effect=='sliceUpLeft'){ echo 'selected="selected"';} ?> value="sliceUpLeft">Slice Up Left</option>
						<option <?php if($slide->effect=='sliceUpDownLeft'){ echo 'selected="selected"';} ?> value="sliceUpDownLeft">Slice Up Down Left</option>
						<option <?php if($slide->effect=='fold'){ echo 'selected="selected"';} ?> value="fold">Fold</option>
						<option <?php if($slide->effect=='fade'){ echo 'selected="selected"';} ?> value="fade">Fade</option>
						<option <?php if($slide->effect=='slideInRight'){ echo 'selected="selected"';} ?> value="slideInRight">Slide In Right</option>
						<option <?php if($slide->effect=='slideInLeft'){ echo 'selected="selected"';} ?> value="slideInLeft">Slide In Left</option>
						<option <?php if($slide->effect=='boxRandom'){ echo 'selected="selected"';} ?> value="boxRandom">Box Random</option>
						<option <?php if($slide->effect=='boxRain'){ echo 'selected="selected"';} ?> value="boxRain">Box Rain</option>
						<option <?php if($slide->effect=='boxRainReverse'){ echo 'selected="selected"';} ?> value="boxRainReverse">Box Rain Reverse</option>
						<option <?php if($slide->effect=='boxRainGrow'){ echo 'selected="selected"';} ?> value="boxRainGrow">Box Rain Grow</option>
						<option <?php if($slide->effect=='boxRainGrowReverse'){ echo 'selected="selected"';} ?> value="boxRainGrowReverse">Box Rain Grow Reverse</option>
					</select>
				</td>
				<td>
					<form id="<?php echo 'updateForm_'.$slide->id; ?>" >
						<input class="button-primary" type="button" value="Update" onclick="updateRow(<?php echo $slide->id; ?>);"  />
					</form>
					<form id="<?php echo 'deleteForm_'.$slide->id; ?>" >
						<input class="button-primary" type="button" id="settingdel" value="Delete" onclick="deleteRow(<?php echo $slide->id; ?>);" />
					</form>
				</td>
				
			</tr>
			<?php
		}
	}
	?>
	</tbody>
</table>

<fieldset class="field">
<legend><h2>Slider Settings</h2></legend>
<form action="#" onsubmit="return updateRBXSetting(this);" >
	<table class="form-table">
		<tr><td>Height</td><td><input type="text" name="height" class="height numeric"  value="<?php echo get_option('rbx_height') ?>" />px</td></tr>
		<tr><td>Width</td><td><input type="text" name="width" class="width numeric" value="<?php echo get_option('rbx_width') ?>" />px</td></tr>
		<tr><td>margin</td><td><input type="text" name="margin" class="margin margin numeric"  value="<?php echo get_option('rbx_margin') ?>" />px</td></tr>
		<tr><td>Theme</td><td>
			<select name="theme" id="theme" class="theme">
				<option <?php if(get_option('rbx_theme')=='default'){ echo 'selected="selected"';} ?> value="default">Default</option>
				<option <?php if(get_option('rbx_theme')=='orman'){ echo 'selected="selected"';} ?> value="orman">Orman</option>
				<option <?php if(get_option('rbx_theme')=='pascal'){ echo 'selected="selected"';} ?> value="pascal">Pascal</option>
				<option <?php if(get_option('rbx_theme')=='dark'){ echo 'selected="selected"';} ?> value="dark">Dark</option>
				<option <?php if(get_option('rbx_theme')=='light'){ echo 'selected="selected"';} ?> value="light">Light</option>
				<option <?php if(get_option('rbx_theme')=='bar'){ echo 'selected="selected"';} ?> value="bar">Bar</option>
			</select></td>
		</tr>
		<tr><td>Show Next Prev</td><td>
			<select name="show_next_prev" class="show_next_prev">
				<option <?php if(get_option('show_next_prev_rbx')=='true'){ echo 'selected="selected"';} ?> value="true">true</option>
				<option <?php if(get_option('show_next_prev_rbx')=='false'){ echo 'selected="selected"';} ?> value="false">false</option>
			</select></td>
		</tr>
		<tr><td>Show Navigation</td><td>
			<select name="rbx_show_navigation" class="rbx_show_navigation">
				<option <?php if(get_option('rbx_show_navigation')=='true'){ echo 'selected="selected"';} ?> value="true">true</option>
				<option <?php if(get_option('rbx_show_navigation')=='false'){ echo 'selected="selected"';} ?> value="false">false</option>
			</select></td>
		</tr>
		<tr><td>Duration time</td><td><input type="text" name="rbx_duration" class="rbx_duration numeric"  value="<?php echo get_option('rbx_duration') ?>" />seconds</td></tr>
		<tr><td>Speed</td><td><input type="text" name="rbx_speed" class="rbx_speed numeric"  value="<?php echo get_option('rbx_speed') ?>" /></td></tr>
		<tr><td></td><td><input class="button-primary" type="submit" value="Save"  /></td></tr>
	</table>
</form>
</fieldset>
</div>
<div class="powerd">Plugin by <a href="http://www.rudrainnovatives.com" target="_blank">Rudra Innovative Software</a></div>
<script type="text/javascript">
		jQuery(document).ready(function() {
			jQuery(".numeric").keydown(function(event) {
				if ( event.keyCode == 46 || event.keyCode == 8 ) {
				}
				else {
					// Ensure that it is a number and stop the keypress
					if ((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
						event.preventDefault();
					}
				}
			});
			
		});

		function deleteRow(id){
			if(confirm ("Are you sure?")){
				jQuery.post(ajaxurl, "id=" + id + "&param=delete_rbx_image&action=rbxgallerylib", function(data)
				{
					jQuery( "#row_"+ id).remove();
				});
			}
		}
		
		function updateRow(id){
			
				var jQueryform = jQuery("#updateForm_"+id);
				title = jQueryform.parent().parent().find( ".title" ).val();
				description = jQueryform.parent().parent().find( ".description" ).val();;
				slide_order = jQueryform.parent().parent().find( ".slide_order" ).val();
				slide_link = jQueryform.parent().parent().find( ".slide_link" ).val();
				effect = jQueryform.parent().parent().find( ".effect" ).val();
				var datapost = "id=" + id +"&title="+title+"&description=" + description +"&slide_order=" +slide_order+"&slide_link=" + slide_link+"&effect=" + effect;
				
				jQuery.post(ajaxurl, datapost + "&param=update_rbx_image&action=rbxgallerylib", function(data)
				{
					jQuery( "#row_"+ id).css("display", "none");
					jQuery( "#row_"+ id).fadeIn("slow");
				});
			
		}
		
		function updateRBXSetting(id){
			
			var jQueryform = jQuery(id);
			height = jQueryform.find( ".height" ).val();
			width = jQueryform.find( ".width" ).val();;
			margin = jQueryform.find( ".margin" ).val();
			theme = jQueryform.find( ".theme" ).val();
			url = jQueryform.attr( "action" );
			show_next_prev = jQueryform.find( ".show_next_prev" ).val();
			rbx_show_navigation =jQueryform.find(".rbx_show_navigation").val();
			rbx_duration =jQueryform.find(".rbx_duration").val();
			rbx_speed =jQueryform.find(".rbx_speed").val();
			datapost = "height="+height+"&width=" + width +"&margin=" +margin+"&theme="+theme+"&show_next_prev="+show_next_prev+"&rbx_show_navigation="+rbx_show_navigation+"&rbx_duration="+rbx_duration+"&rbx_speed="+rbx_speed;
			
			jQuery.post(ajaxurl, datapost + "&param=updateRBXSetting&action=rbxgallerylib", function(data)
			{
				jQueryform.css("display", "none");
				jQueryform.fadeIn("slow");
			});
				
			return false;
		}
</script>