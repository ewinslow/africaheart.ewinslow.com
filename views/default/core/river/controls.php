<?php
/**
 * Controls on an river item
 *
 *
 * @uses $vars['item']
 */

$object = $vars['item']->getObjectEntity();

if (elgg_is_logged_in()) {
	// comments and non-objects cannot be commented on or liked
	if ($vars['item']->annotation_id == 0) {
		// comments
		if ($object->canComment()) {
			$params = array(
				'href' => '#',
				'text' => elgg_echo('generic_comments:text'),
				'class' => "elgg-toggler elgg-toggles-comments-add-{$object->getGUID()}",
			);
			echo elgg_view('output/url', $params);
		}

		// like this
		if ($object->canAnnotate(0, 'likes')) {
			if (!elgg_annotation_exists($object->getGUID(), 'likes')) {
				$url = "action/likes/add?guid={$object->getGUID()}";
				$params = array(
					'href' => $url,
					'text' => elgg_echo('likes:likethis'),
					'is_action' => true,
				);
				echo elgg_view('output/url', $params);
			} else {
				$options = array(
					'guid' => $guid,
					'annotation_name' => 'likes',
					'owner_guid' => elgg_get_logged_in_user_guid()
				);
				$likes = elgg_get_annotations($options);
				$url = elgg_get_site_url() . "action/likes/delete?annotation_id={$likes[0]->id}";
				$params = array(
					'href' => $url,
					'text' => elgg_echo('likes:remove'),
					'is_action' => true,
				);
				echo elgg_view('output/url', $params);
			}
		}
	}

}