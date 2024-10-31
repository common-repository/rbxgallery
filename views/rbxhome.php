<div class="wrap"><div id="icon-options-general" class="icon32"><br></div><h2>RBXGallery Options</h2></div>
<div class="wrap">
	<div class="updated settings-error" id="msg_save_rbx" style="display: none;"><p><strong>Settings saved.</strong></p></div>
	<form action="#" method="post" id="imageeffectform" name="imageeffectform">
		<table class="form-table">
			<tr>
				<th>Image Effect</th>
				<td>
					<select name="effect" id="effect">
						<option value="none" <?php if (get_option('rbx_effect') == 'none') {echo 'selected="selected"';} ?>>None</option>
						<option value="light_box" <?php if (get_option('rbx_effect') == 'light_box') { echo 'selected="selected"';} ?>>Light Box</option>
						<option value="jq_zoom" <?php if (get_option('rbx_effect') == 'jq_zoom') { echo 'selected="selected"'; } ?>>JQ Zoom</option>
					</select>
					<span class="description">Select the effect for gallery images.</span>
				</td>
			</tr>
			<tr>
				<th>JQ Zoom Height</th>
				<td>
					<input type="text" class="numeric" id="imgheight" name="imgheight" value="<?php echo get_option('rbx_zoom_imgheight'); ?>"/>px
				</td>
			</tr>
			<tr>
				<th>JQ Zoom Width</th>
				<td>
					<input type="text" class="numeric" id="imgwidth" name="imgwidth" value="<?php echo get_option('rbx_zoom_imgwidth'); ?>"/>px
				</td>
			</tr>
			<tr>
				<th>Image Border</th>
				<td>
					<input type="text" class="numeric" id="imgborder" name="imgborder" value="<?php echo get_option('rbx_gal_imgborder'); ?>"/>px
				</td>
			</tr>
			<tr>
				<th>Border Color</th>
				<td>
					<input type="text" id="imgbordercolor" name="imgbordercolor" value="<?php echo get_option('rbx_gal_imgbordercolor'); ?>"/>
				</td>
			</tr>
		</table>
		<p class="submit">
			<input type="button" onclick="submitrabximageeffect();" class="button-primary"  value="Save" name="submit" />
		</p>
	</form>
</div>


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
			
			jQuery('#imgbordercolor').ColorPicker({
			color: '#0000ff',
				onShow: function (colpkr) {
					jQuery(colpkr).fadeIn(500);
					return false;
				},
				onHide: function (colpkr) {
					jQuery(colpkr).fadeOut(500);
					return false;
				},
				onChange: function (hsb, hex, rgb) {
					jQuery('#imgbordercolor').val("#"+hex);
				}
			});
			
		});
	
	function submitrabximageeffect()
	{
		jQuery.post(ajaxurl, jQuery("#imageeffectform").serialize() + "&param=save_image_effect_settings&action=rbxgallerylib", function(data)
		{
			jQuery("#msg_save_rbx").css("display","block");
			setTimeout(function(){
				window.location.reload();
			},2000);
		});
	}
	
	
</script>

