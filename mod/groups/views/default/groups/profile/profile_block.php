<?php
/**
 * Group profile
 *
 * Icon and profile fields
 *
 * @uses $vars['group']
 */

if (!isset($vars['entity']) || !$vars['entity']) {
	echo elgg_echo('groups:notfound');
	return true;
}

$group = $vars['entity'];
$owner = $group->getOwnerEntity();

$profile_fields = elgg_get_config('group');

?>
<dl class="elgg-profile">
	<dt><?php echo elgg_echo("groups:owner"); ?></dt>
	<dd>
		<?php
			echo elgg_view('output/url', array(
				'text' => $owner->name,
				'value' => $owner->getURL(),
			));
		?>
	</dd>
	<dt><?php echo elgg_echo('groups:members'); ?></dt>
	<dd><?php echo $group->getMembers(0, 0, TRUE); ?></dd>
<?php
if (is_array($profile_fields) && count($profile_fields) > 0) {

	foreach ($profile_fields as $key => $valtype) {
		// do not show the name, show the description last
		if ($key == 'name') {
			continue;
		}

		$value = $group->$key;
		if (empty($value)) {
			continue;
		}

		$options = array('value' => $group->$key);
		if ($valtype == 'tags') {
			$options['tag_names'] = $key;
		}

		echo "<dt>";
		echo elgg_echo("groups:$key");
		echo "</dt><dd>";
		echo elgg_view("output/$valtype", $options);
		echo "</dd>";
	}
}
?>
</dl>