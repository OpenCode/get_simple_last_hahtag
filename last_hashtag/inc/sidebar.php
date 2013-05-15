<?php if (!defined('IN_GS')) {die('you cannot load this page directly.');}

/**
 * Optional sidebar functions for the GetSimple Last Hashtag List.
 */


/*******************************************************
 * @function last_hashtag_list
 * @action print a list with the latest hashtag
 */
function last_hashtag_list() {
	$tweets = get_last_hashtag_tweets();
	$config_datas = get_last_hashtag_config();
	if (!empty($tweets)) {
		echo '<h2>Last Tweet for #' . $config_datas[0] . '</h2>';
		foreach ($tweets as $tw) {
			// User
			echo '<h4>'.$tw->{'from_user'}.' ('.$tw->{'from_user_name'}.')</h4>';
			// Avatar and text
			echo '<p style="text-align:justify"><img src="'.$tw->{'profile_image_url'}.'" style="display:block;float:left;margin:2px;">'.$tw->{'text'}.'</p>';
			echo '<hr />';
			}
		}
}

?>
