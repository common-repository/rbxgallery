<?php
global $wpdb;
?><style>
	.nivo-main-image{
		height: 100% !important;
	}
	
</style>
<script type="text/javascript">	
	jQuery(window).load(function() {
		
		
		jQuery("#slider").nivoSlider(
		{
			effect: "random", // Specify sets like: "fold,fade,sliceDown"
			slices: 15, // For slice animations
			boxCols: 8, // For box animations
			boxRows: 4, // For box animations
			animSpeed: <?php echo get_option('rbx_speed') ?>, // Slide transition speed
			pauseTime: <?php echo get_option('rbx_duration') ?>, // How long each slide will show
			startSlide: 0, // Set starting Slide (0 index)
			directionNav: <?php echo get_option('rbx_show_next_prev') ?>, // Next & Prev navigation
			directionNavHide: true, // Only show on hover
			controlNav: <?php echo get_option('rbx_show_navigation'); ?>, // 1,2,3... navigation
			controlNavThumbs: false, // Use thumbnails for Control Nav
			controlNavThumbsFromRel: false, // Use image rel for thumbs
			controlNavThumbsSearch: ".jpg", // Replace this with...
			controlNavThumbsReplace: "_thumb.jpg", // ...this in thumb Image src
			keyboardNav: true, // Use left & right arrows
			pauseOnHover: true, // Stop animation while hovering
			manualAdvance: false, // Force manual transitions
			captionOpacity: 0.8, // Universal caption opacity
			prevText: "Prev", // Prev directionNav text
			nextText: "Next", // Next directionNav text
			randomStart: false, // Start on a random slide
			beforeChange: function(){
				
				var height_slider = "<?php echo get_option("rbx_height") ?>";
				jQuery("#slider").height(height_slider+"px");
				jQuery(".nivo-main-image").css("height","100%");
				jQuery(".nivo-main-image").css("width","100%");
				jQuery("#loading").hide();
				jQuery(".nivo-controlNav").css({'padding-top': '0px', 'margin-top':'0px'})
				var ct = jQuery('.nivo-controlNav').children().size();
				if( ct <= 6 ){
					jQuery('.nivo-controlNav').css({'background-size':'225px 40px'});
				}
				else if( ct <= 9 && ct > 6 ){
					jQuery('.nivo-controlNav').css({'background-size':'300px 40px'});
				}
				
			}, // Triggers before a slide transition
			afterChange: function(){}, // Triggers after a slide transition
			slideshowEnd: function(){}, // Triggers after all slides have been shown
			lastSlide: function(){}, // Triggers when last slide is shown
			afterLoad: function(){} // Triggers when slider has loaded
		});

		var height_slider = "<?php echo get_option("rbx_height") ?>";
		jQuery("#slider").height(height_slider+"px");
		jQuery(".nivo-main-image").css("height","100%");
		jQuery(".nivo-main-image").css("width","100%");
		jQuery("#loading").hide();
		jQuery(".nivo-controlNav").css({'padding-top': '0px', 'margin-top':'0px'})
		var ct = jQuery('.nivo-controlNav').children().size();
		if( ct <= 6 ){
			jQuery('.nivo-controlNav').css({'background-size':'225px 40px'});
		}
		else if( ct <= 9 && ct > 6 ){
			jQuery('.nivo-controlNav').css({'background-size':'300px 40px'});
		}
	});
</script>

<?php
$post_id = get_the_ID();
$slides = $wpdb->get_results
(
	$wpdb->prepare
	(
		"SELECT * FROM ". rbx_post_images() ." WHERE postid = %d ORDER BY id ASC",
		$post_id
	)
);

if(count($slides) > 0)
{


?>
<div style="margin:<?php echo get_option('rbx_margin') ?>px ;">
	<div class="slider-wrapper theme-<?php echo get_option('rbx_theme'); ?>" style="height:<?php echo get_option('rbx_height') ?>px;width:<?php echo get_option('rbx_width');?>px">
		<div id="slider" class="nivoSlider" style="height:<?php echo get_option('rbx_height') ?>px;width:<?php echo get_option('rbx_width');?>px" >
			<?php	
				foreach ($slides as $slide) {
					
					$imagetitle = $wpdb->get_row
					(
						$wpdb->prepare
						(
							"SELECT * FROM ". rbx_gallery() ." WHERE path = %s",
							$slide->path
						)
					);
					
					?>
					<a href="<?php if($imagetitle->slide_link!=''){ echo $imagetitle->slide_link;}else{ echo 'javascript:void(o);';} ?>"><img src="<?php echo $slide->path; ?>" title = "<?php echo $imagetitle->title . " - " . $imagetitle->description ?>" style="height:100%; width:100%" /></a>
					<?php	
				}
			?>
		</div>
	</div>
</div>
<?php
}
?>

