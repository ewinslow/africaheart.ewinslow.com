<?php
/**
 * Basic uploader form
 *
 * This only handled uploading the images. Editing the titles and descriptions
 * are handled with the edit forms.
 *
 * @uses $vars['entity']
 *
 * @author Cash Costello
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License v2
 */

$album = $vars['entity'];
$access_id = $album->access_id;

$maxfilesize = (float) elgg_get_plugin_setting('maxfilesize', 'tidypics');
$quota = elgg_get_plugin_setting('quota', 'tidypics');
/*
if ($quota) {
	$image_repo_size_md = get_metadata_byname($album->container_guid, "image_repo_size");
	$image_repo_size = (int)$image_repo_size_md->value;
	$image_repo_size = $image_repo_size / 1024 / 1024;
	$quote_percentage = round(100 * ($image_repo_size / $quota));
	// for small quotas, so one decimal place
	if ($quota < 10) {
		$image_repo_size = sprintf('%.1f', $image_repo_size);
	} else {
		$image_repo_size = round($image_repo_size);
	}
	if ($image_repo_size > $quota) {
		$image_repo_size = $quota;
	}
}
		<?php
		if ($quota) {
			?>
		<i><?php echo elgg_echo("tidypics:quota") . ' ' . $image_repo_size . '/' . $quota . " MB ({$quote_percentage}%)"; ?></i><br />
			<?php
		}
		?>

 *
*/

$instructions = elgg_echo("tidypics:uploader:upload");
$max = elgg_echo('tidypics:uploader:basic', array($maxfilesize));

$list = '';
for ($x = 0; $x < 10; $x++) {
	$list .= '<li>' . elgg_view('input/file', array('name' => 'images[]')) . '</li>';
}

$foot = elgg_view('input/hidden', array('name' => 'guid', 'value' => $album->getGUID()));
$foot .= elgg_view('input/submit', array('value' => elgg_echo("save")));

$form_body = <<<HTML
<div>
	$max
</div>
<div>
	<ol>
		$list
	</ol>
</div>
<div class='elgg-foot'>
	$foot
</div>
HTML;

echo elgg_view('input/form', array(
	'body' => $form_body,
	'action' => 'action/photos/image/upload',
	'enctype' => 'multipart/form-data',
));
