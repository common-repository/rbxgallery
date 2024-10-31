<?php 

global $wpdb;
global $current_user;
$current_user = wp_get_current_user();
if (!current_user_can("edit_posts") && ! current_user_can("edit_pages"))
{
	return;
}
else
{
	
	if( isset($_REQUEST["param"]) )
	{
		if( $_REQUEST["param"] == "save_image_effect_settings")
		{
			
			update_option('rbx_effect', esc_attr($_REQUEST['effect']));
			update_option('rbx_zoom_imgheight', esc_attr($_REQUEST['imgheight']));
			update_option('rbx_zoom_imgwidth', esc_attr($_REQUEST['imgwidth']));
			update_option('rbx_gal_imgborder', esc_attr($_REQUEST['imgborder']));
			update_option('rbx_gal_imgbordercolor', esc_attr($_REQUEST['imgbordercolor']));
			die();
		}
		else if( $_REQUEST["param"] == "save_rbx_images")
		{
			$dids = explode(",", esc_attr($_REQUEST['dids']));
			$paths = explode(",", esc_attr($_REQUEST['paths']));
			
			for( $flag = 0; $flag < count($dids); $flag++ )
			{
				$path= $paths[$flag];
				$name = basename($path);
				$tit = 'title_'.$dids[$flag];
				$title = esc_attr($_REQUEST[$tit]);
				$dec = 'desc_'.$dids[$flag];
				$desc = esc_attr($_REQUEST[$dec]);
				$lnk = 'slink_'.$dids[$flag];
				$img_lnk = esc_attr($_REQUEST[$lnk]);
				
				$wpdb->query
				(
					$wpdb->prepare
					(
						"INSERT INTO " . rbx_gallery() ." (name, path, title, description, slide_link) VALUES (%s, %s, %s, %s, %s)",
						$name,
						$path,
						$title,
						$desc,
						$img_lnk
					)
				);
				
				$id = $wpdb->insert_id;
				
				$wpdb->query
				(
					$wpdb->prepare
					(
						"UPDATE " . rbx_gallery() ." SET slide_order = %d WHERE id = %d",
						$id,
						$id
					)
				);
			}
			
			die();
		}
		else if( $_REQUEST["param"] == "update_rbx_image")
		{
			$id = intval($_REQUEST["id"]);
			$title = esc_attr($_REQUEST["title"]);
			$desc = esc_attr($_REQUEST["description"]);
			$slider_order = intval($_REQUEST["slide_order"]);
			$slide_link = esc_attr($_REQUEST['slide_link']);
			$effect = esc_attr($_REQUEST['effect']);

			$wpdb->query
			(
				$wpdb->prepare
				(
					"UPDATE " . rbx_gallery() ." SET title = %s,description = %s, slide_order = %d, slide_link = %s, effect = %s WHERE id = %d;",
					$title,
					$desc,
					$slider_order,
					$slide_link,
					$effect,
					$id
				)
			);
			die();
		}
		else if( $_REQUEST["param"] == "delete_rbx_image")
		{
			$id = intval($_REQUEST["id"]);
			
			$path = $wpdb->get_var
			(
				$wpdb->prepare
				(
					"SELECT path FROM " . rbx_gallery() ." WHERE id = %d",
					$id
				)
			);
			
			$wpdb->query
			(
				$wpdb->prepare
				(
					"DELETE FROM " . rbx_post_images() ." WHERE path = %s",
					$path
				)
			);
			
			$wpdb->query
			(
				$wpdb->prepare
				(
					"DELETE FROM " . rbx_gallery() ." WHERE id = %d",
					$id
				)
			);
			die();
		}
		else if( $_REQUEST["param"] == "updateRBXSetting")
		{
			$height = intval($_REQUEST["height"]);
			$width = intval($_REQUEST["width"]);
			$margin = intval($_REQUEST["margin"]);
			$theme = esc_attr($_REQUEST["theme"]);
			$show_next_prev = esc_attr($_REQUEST["show_next_prev"]);
			$show_navigation = esc_attr($_REQUEST["rbx_show_navigation"]);
			$duration = intval($_REQUEST["rbx_duration"]);
			$speed = intval($_REQUEST["rbx_speed"]);
			
			update_option('rbx_height', $height);
			update_option('rbx_width', $width);
			update_option('rbx_margin', $margin);
			update_option('rbx_theme', $theme);
			update_option('rbx_show_next_prev', $show_next_prev);
			update_option('rbx_show_navigation', $show_navigation);
			update_option('rbx_duration', $duration);
			update_option('rbx_speed', $speed);
			
			die();
		}
		else if( $_REQUEST["param"] == "updatepostimages")
		{
			$postid = intval($_REQUEST['postid']);
			$arrimg = explode(",", esc_attr(($_REQUEST['arrimg'])));
			
			for($flag = 0; $flag < count($arrimg); $flag++)
			{
				$wpdb->query
				(
					$wpdb->prepare
					(
						"INSERT INTO " . rbx_post_images() ." (postid, path) VALUES (%d, %s)",
						$postid,
						$arrimg[$flag]
					)
				);
			}
			
			die();
		}
		else if( $_REQUEST["param"] == "deletepostimages")
		{
			$id = intval($_REQUEST['id']);
			$wpdb->query
			(
				$wpdb->prepare
				(
					"DELETE FROM " . rbx_post_images() ." WHERE id= %d",
					$id
				)
			);
			die();
		}

	}
}

?>