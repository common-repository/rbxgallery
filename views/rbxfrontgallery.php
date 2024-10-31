<?php
global $wpdb;
$post_id = get_the_ID();
$images = $wpdb->get_results
(
	$wpdb->prepare
	(
		"SELECT * FROM ". rbx_post_images() ." WHERE postid = %d ORDER BY id ASC",
		$post_id
	)
);
if(count($images) > 0)
{
$img = $wpdb->get_row
(
	$wpdb->prepare
	(
		"SELECT * FROM ". rbx_post_images() ." WHERE postid = %d",
		$post_id
	)
);

$iitle = $wpdb->get_row
(
	$wpdb->prepare
	(
		"SELECT * FROM ". rbx_gallery() ." WHERE path = %s",
		$img->path
	)
);
						

$divheight ="";
if (get_option('rbx_effect') == 'jq_zoom')
{
	$divheight = "height: 220px; padding-left: 20%;";
}
?>
<div>
		<div class="picture-slides-container">
			<div id="divpicture" class="picture-slides-fade-container" style="overflow: initial;">
				<?php

				if (get_option('rbx_effect') == 'light_box')
				{
					?>
						<a class="imganchor example-image-link" data-lightbox="example-2" href="<?php echo $img->path; ?>" title="<?php echo $img->title; ?>">
							<img class="picture-slides-image" src="" alt="" style="height: 100%;" />
						</a>
					<?php
				}
				else if (get_option('rbx_effect') == 'jq_zoom')
				{
					?>
						<a class="imganchor jqzoom" rel='gal1' href="<?php echo $img->path; ?>" title="<?php echo $iitle->title; ?>">
							<img class="picture-slides-image" src="" alt="" style="height: 100%; width: 100%;" />
						</a>
					<?php
				}
				else 
				{
					?>
						<img class="picture-slides-image" src="" alt="" />
					<?php
				}
				?>
				
			</div>
			
			<div class="picture-slides-image-text"><?php echo $img->description; ?></div>
			<?php
				if (get_option('rbx_effect') != 'jq_zoom')
				{
					?>
					<div class="navigation-controls">
						<a  href="#" class="navi picture-slides-previous-image">Previous</a>
						<span class="picture-slides-image-counter" style="margin-left: 35%;"></span>
						<a href="#" class=" navi picture-slides-next-image" style="float: right;">Next</a>
					</div>
					<?php
				}
			?>
			<div class="picture-slides-thumbnails">
				
				<?php
					foreach ($images as $image) {

						$path1 = explode(".", basename($image->path));
						$filefirst = strstr($image->path, basename($image->path), TRUE);
						$newfl = $path1[0] . "-150x150.". $path1[1];
						$newpath = $filefirst . $newfl;	
						
						$imgtitle = $wpdb->get_row
						(
							$wpdb->prepare
							(
								"SELECT * FROM ". rbx_gallery() ." WHERE path = %s",
								$image->path
							)
						);
						
						?>
						<div class="divinner" style="float: left;margin-right: 10px;margin-bottom: 10px;">
							<a href="<?php echo $image->path; ?>" rel="{gallery: 'gal1', smallimage: '<?php echo $newpath; ?>',largeimage: '<?php echo $image->path; ?>'}" title="<?php echo $imgtitle->title; ?>" >
								<img onclick="getimage(this);" src="<?php echo $newpath; ?>" alt="<?php echo $imgtitle->title; ?>" style="width: 80px; height: 80px;" />
							</a>
						</div>
						
					<?php
					}	
				?>
				
			</div>
		</div>
	</div>
	
	<div class="picture-slides-dim-overlay"></div>
	

	<script type="text/javascript">
	
		jQuery.PictureSlides.set({
			// Switches to decide what features to use
			useFadingIn : <?php echo get_option('rbx_effect') == "jq_zoom" ? "false":"true" ?>,
			useFadingOut : <?php echo get_option('rbx_effect') == "jq_zoom" ? "false":"true" ?>,
			useFadeWhenNotSlideshow : true,
			useFadeForSlideshow : true,
			useDimBackgroundForSlideshow : true,
			loopSlideshow : false,
			usePreloading : true,
			useAltAsTooltip : true,
			useTextAsTooltip : false,
			
			// Fading settings
			fadeTime : 500, // Milliseconds	
			timeForSlideInSlideshow : 2000, // Milliseconds

			// At page load
			startIndex : 1,	
			startSlideShowFromBeginning : true,
			startSlideshowAtLoad : false,
			dimBackgroundAtLoad : false,

			images : [
			<?php
				foreach ($images as $image) {
					
					
					$path1 = explode(".", basename($image->path));
					$filefirst = strstr($image->path, basename($image->path), TRUE);
					$newfl = $path1[0] . "-150x150.". $path1[1];
					$newpath = $filefirst . $newfl;	
					
					$imgtit = $wpdb->get_row
					(
						$wpdb->prepare
						(
							"SELECT * FROM ". rbx_gallery() ." WHERE path = %s",
							$image->path
						)
					);
					
					?>
						{
							image : "<?php echo get_option('rbx_effect') == 'jq_zoom'?$newpath:$image->path; ?>", 
							alt : "<?php echo $imgtit->title; ?> - <?php echo $imgtit->description; ?>",
							text : "<?php echo $imgtit->title; ?> - <?php echo $imgtit->description; ?>"
							
						},
					<?php
					}	
				?>

			],
			thumbnailActivationEvent : "click",

			// Classes of HTML elements to use
			mainImageClass : "picture-slides-image", // Mandatory
			mainImageFailedToLoadClass : "picture-slides-image-load-fail",
			imageLinkClass : "picture-slides-image-link",
			fadeContainerClass : "picture-slides-fade-container",
			imageTextContainerClass : "picture-slides-image-text",
			previousLinkClass : "picture-slides-previous-image",
			nextLinkClass : "picture-slides-next-image",
			imageCounterClass : "picture-slides-image-counter",
			startSlideShowClass : "picture-slides-start-slideshow",
			stopSlideShowClass : "picture-slides-stop-slideshow",
			thumbnailContainerClass: "picture-slides-thumbnails",
			dimBackgroundOverlayClass : "picture-slides-dim-overlay"
		});
		function getimage(img)
		{
			var mainimg = img.src;
			var path1 = baseName(mainimg).split(".");
			var filefirst = mainimg.replace(baseName(mainimg),"");
			var filename = path1[0].replace("-150x150","");
			var newfl = filefirst + filename + "." + path1[1];
			jQuery(".imganchor").attr("href",newfl);
			jQuery(".zoomWrapperTitle").text(img.alt);
			
		}
		
		function baseName(str)
		{
			var base = new String(str).substring(str.lastIndexOf('/') + 1); 
			return base;
		}
		
		jQuery(".picture-slides-image").click(function(){
			jQuery(".imganchor").attr("title",jQuery(".picture-slides-image").attr("title"));
			
		});
		
		jQuery(document).ready(function() {
			jQuery('.jqzoom').jqzoom({
					zoomType: 'standard',
					lens:true,
					preloadImages: false,
					alwaysOn:false,
					zoomWidth: <?php echo get_option('rbx_zoom_imgwidth'); ?>,
					zoomHeight: <?php echo get_option('rbx_zoom_imgheight'); ?>,
			});
			
			jQuery(".picture-slides-image").css("border","<?php echo get_option('rbx_gal_imgborder'); ?>px solid <?php echo get_option('rbx_gal_imgbordercolor'); ?>");
			
		});
	</script>
<?php
	
}
?>