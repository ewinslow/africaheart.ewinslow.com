<?php
	/**
	 * View for blog objects
	 *
	 * @package Blog
	 */
	
	$full = elgg_extract('full_view', $vars, FALSE);
	$blog = elgg_extract('entity', $vars, FALSE);
	
	if (!$blog) {
		return TRUE;
	}
	
	$owner = $blog->getOwnerEntity();
	$container = $blog->getContainerEntity();
	$categories = elgg_view('output/categories', $vars);
	$excerpt = $blog->excerpt;
	
	$owner_icon = elgg_view_entity_icon($owner, 'tiny');
	$owner_link = elgg_view('output/url', array(
		'href' => "blog/owner/$owner->username",
		'text' => $owner->name,
	));
	$author_text = elgg_echo('byline', array($owner_link));
	$tags = elgg_view('output/tags', array('tags' => $blog->tags));
	$date = elgg_view_friendly_time($blog->time_created);
	
	// The "on" status changes for comments, so best to check for !Off
	if ($blog->comments_on != 'Off') {
		$comments_count = $blog->countComments();
		//only display if there are commments
		if ($comments_count != 0) {
			$text = elgg_echo("comments") . " ($comments_count)";
			$comments_link = elgg_view('output/url', array(
				'href' => $blog->getURL() . '#blog-comments',
				'text' => $text,
			));
		} else {
			$comments_link = '';
		}
	} else {
		$comments_link = '';
	}
	
	// get icon settings
	if($full) {
		$icon_align = elgg_get_plugin_setting("full_align", "blog_tools");
		$icon_size = elgg_get_plugin_setting("full_size", "blog_tools");
	
		if(empty($icon_align)) {
			$icon_align = "right";
		}
	
		if(empty($icon_size)) {
			$icon_size = "large";
		}
	} else {
		$icon_align = elgg_get_plugin_setting("listing_align", "blog_tools");
		$icon_size = elgg_get_plugin_setting("listing_size", "blog_tools");
	
		if(empty($icon_align)) {
			$icon_align = "left";
		}
	
		if(empty($icon_size)) {
			$icon_size = "small";
		}
	}
		
	$icon_class = "";
	$info_class = "";
		
	// show icon
	if(!empty($blog->icontime) && ($icon_align != "none")) {
		if($icon_align == "right"){
			$icon_class = "blog_tools_blog_image_right";
		}
		
		$blog_icon ="<div class='blog_tools_blog_image " . $icon_class . "'>";
		$blog_icon .= "<img src='" . $vars["entity"]->getIconURL($icon_size) . "' />";
		$blog_icon .= "</div>";
	}
	
	$metadata = elgg_view_menu('entity', array(
		'entity' => $vars['entity'],
		'handler' => 'blog',
		'sort_by' => 'priority',
		'class' => 'elgg-menu-hz',
	));
	
	$subtitle = "<p>$author_text $date $comments_link</p>";
	$subtitle .= $categories;
	
	// do not show the metadata and controls in widget view
	if (elgg_in_context('widgets')) {
		$metadata = '';
	}
	
	// Show blog
	if ($full) {
		// full view
		$body = elgg_view('output/longtext', array(
			'value' => $blog->description,
			'class' => 'blog-post',
		));
	
		$header = elgg_view_title($blog->title);
	
		$params = array(
			'entity' => $blog,
			'title' => false,
			'metadata' => $metadata,
			'subtitle' => $subtitle,
			'tags' => $tags,
		);
		$params = $params + $vars;
		$list_body = elgg_view('object/elements/summary', $params);
	
		$blog_info = elgg_view_image_block($owner_icon, $list_body);
	
		echo "<div class='blog_tools_blog_wrapper'>";
		echo $header;
		echo $blog_info;
		echo $blog_icon;
		echo $body;
		echo "</div>";
	
	} else {
		// how to show strapline
		if(elgg_get_plugin_setting("listing_strapline", "blog_tools") == "time"){
			$subtitle = "";
			$tags = false;
			
			$excerpt = date("F j, Y", $blog->time_created) . " - " . $excerpt;
		}
		
		// prepend icon
		$excerpt = $blog_icon . $excerpt;
		
		// brief view
		$params = array(
			'entity' => $blog,
			'metadata' => $metadata,
			'subtitle' => $subtitle,
			'tags' => $tags,
			'content' => $excerpt,
		);
		
		$params = $params + $vars;
		
		$list_body = elgg_view('object/elements/summary', $params);
	
		echo "<div class='blog_tools_blog_wrapper'>";
		echo elgg_view_image_block($owner_icon, $list_body);
		echo "</div>";
	}
