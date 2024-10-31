<?php
echo media_upload_header();
global $wpdb;
$post_id = intval($_REQUEST['post_id']);
$images = $wpdb->get_results
(
	$wpdb->prepare
	(
		"SELECT * FROM " . rbx_gallery() ." ORDER BY id ASC",""
	)
);
?>
<form  method="post" action="#" class="media-upload-form rbxform" id="rbx-form">

	<div class="rbxdivpostmsg">
	Select RBXGallery Images in your Post
	</div>
	<div>
		<input type="button" id="selctallimg" name="selctallimg" value="Select All" class="button-primary" onclick="select_all_rbximages();" />
	</div>

	<hr/>
	<p></p>
	<div>
		<?php
			$flag = 0;
			foreach ($images as $image) {
				?>
					<img id="postimg<?php echo $flag; ?>" class="imgposts disselectimg" onclick="imageselect(this);" src="<?php echo $image->path; ?>" alt="<?php echo $image->title; ?>" />
				<?php
				$flag++;
			}	
		?>
	</div>
	<div><input type="button" id="addmagespost" name="addmagespost" value="Add Images" onclick="addrbximages();" class="button-primary" /></div>
</form>

<script type="text/javascript">
	var arrimg = [];
	jQuery(document).ready(function() {
		jQuery("html").css("margin-top","18px");
		jQuery("#sidemenu").css("margin-top","-4.5%");
		jQuery("#sidemenu").css("margin-left","-4%");
		jQuery("#sidemenu").css("padding-right","46%");
	});
	
	function imageselect(img)
	{
		var clas = jQuery(img).attr("class").split(" ");
		if(clas[1] == "disselectimg")
		{
			jQuery(img).removeClass("disselectimg");
			jQuery(img).addClass("selectimg");
			arrimg.push(img.src);
		}
		else
		{
			jQuery(img).removeClass("selectimg");
			jQuery(img).addClass("disselectimg");
			var index = arrimg.indexOf(img.src);
			if(index != -1)
			{
				arrimg.splice(index,1);
			}
		}
	}
	
	function select_all_rbximages()
	{
		if(arrimg.length != 0)
		{
			arrimg = [];
		}
		jQuery(".imgposts").removeClass("disselectimg");
		jQuery(".imgposts").addClass("selectimg");
		var totalimages = jQuery("img.imgposts").length;
		for(flag = 0; flag < totalimages; flag++)
		{
			arrimg.push(jQuery("#postimg"+flag).attr("src"));
		}
	}
	function addrbximages()
	{
			var postid = "<?php echo $post_id; ?>";
			var datapost = "postid="+postid+"&arrimg="+arrimg;
			jQuery.post(ajaxurl, datapost + "&param=updatepostimages&action=rbxgallerylib", function(data)
			{
				window.parent.location.href= "<?php echo site_url(); ?>/wp-admin/post.php?post=<?php echo $post_id; ?>&action=edit";
				
			});
			
	}
</script>