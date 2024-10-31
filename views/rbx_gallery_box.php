<?php

global $post;
edit_multiple_image_gallery_img($post);
$myPostType = get_post_type();
?>
<div style="clear: both; width: 100%; padding-top: 10px;">
<p>
	<strong<?php if (isset($display)) echo $display; ?>>
		<a href="media-upload.php?parent_page=<?php echo $myPostType; ?>
			&post_id=<?php echo $post->ID; ?>&type=image&tab=gallery&TB_iframe=1&width=640&height=566" class="thickbox" title="Add Your RBXGallery Images">
			<?php _e('Add RBX Gallery Images'); ?>
		</a>
	</strong>
</p>
</div>
<strong><div>Short Code for Gallery:  [rbxgallery]</div> <div>Short Code for Slider:  [rbxslider]</div></strong>
<?php

	
function edit_multiple_image_gallery_img($post)
{
	global $wpdb;
	$postimages = $wpdb->get_results
	(
		$wpdb->prepare
		(
			"SELECT * FROM ".rbx_post_images()." WHERE postid = %d",
			$post->ID
		)
	);
	for($flag = 0; $flag < count($postimages); $flag++)
	{
		?>
		<div id="divrbx<?php echo $flag; ?>" style="height: 70px; width: 70px;float: left; display: block; margin-right: 5px;">
			<img id="rbxchild<?php echo $flag; ?>" onclick="delrbximg(<?php echo $postimages[$flag]->id; ?>, <?php echo $flag; ?>);" src="<?php echo site_url(); ?>/wp-content/plugins/RBXGallery/assets/css/close.png" style="position: relative; top: 18px; width: 16px; display: block; cursor: pointer;" />
			<img id="<?php echo $flag; ?>" src="<?php echo $postimages[$flag]->path; ?>" style="height: 70px; width: 70px;" />
		</div>
		<?php
	}
	
}

?>
<script type="text/javascript">
	
	function delrbximg(id, flg)
	{
		var conf = confirm("Are You sure to delete image?");
		if(conf)
		{
			jQuery.post(ajaxurl, "id="+ id + "&param=deletepostimages&action=rbxgallerylib", function(data)
			{
				jQuery("#divrbx"+flg).remove();
				
			});
		}
	}
	
</script>