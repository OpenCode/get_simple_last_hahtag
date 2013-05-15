<?php
/*
Plugin Name: Hello World
Description: Echos "Hello World" in footer of theme
Version: 1.0
Author: Francesco OpenCode Apruzzese
Author URI: http://www.e-ware.org
*/

/* Based on tweet REST API (https://dev.twitter.com/docs/api/1/get/search)
 * http://search.twitter.com/search.json?q=%23HASHTAG&rpp=TWEET_LIMIT&include_entities=0
 * */

// REQUIRED FILE
require_once('last_hashtag/inc/common.php');

# get correct id for plugin
$thisfile_lht=basename(__FILE__, ".php");
$thisfile_xml=LHTXMLFILE;

# add in this plugin's language file
i18n_merge($thisfile_lht) || i18n_merge($thisfile_lht, 'en_US');

# register plugin
register_plugin(
	$thisfile_lht, //Plugin id
	'Last HashTag', 	//Plugin name
	'1.0', 		//Plugin version
	'Francesco OpenCode Apruzzese',  //Plugin author
	'http://www.e-ware.org/', //author website
	'Show the last tweet by hashtag', //Plugin description
	'theme', //page type - on which admin tab to display
	'last_hashtag_show'  //main function (administration)
);

# add a link in the admin tab 'theme'
add_action('theme-sidebar','createSideMenu',array($thisfile_lht, i18n_r($thisfile_lht.'/LAST_HASHTAG_TITLE')));

# get XML data
if (file_exists($thisfile_xml)) {
	$x = getXML($thisfile_xml);
	$hashtag = $x->hashtag;
	$tweet_limit = $x->tweet_limit;
} else {
	$hashtag = '';
	$tweet_limit = '';
}

function last_hashtag_show() {
	global $thisfile_xml, $hashtag, $tweet_limit, $thisfile_lht;
	$success=null;
	$error=null;
	
	// submitted form
	if (isset($_POST['submit'])) {
		$hashtag='';
		
		# check to see if the hashtag is passed
		if ($_POST['hashtag'] != '') {
			$hashtag = $_POST['hashtag'];
		}

		# check to see if the tweet limit is passed
		if ($_POST['tweet_limit'] != '') {
			$tweet_limit = $_POST['tweet_limit'];
		}
		
		# if there are no errors, dave data
		if (!$error) {
			$xml = @new SimpleXMLElement('<item></item>');
			$xml->addChild('hashtag', $hashtag);
			$xml->addChild('tweet_limit', $tweet_limit);
			
			if (! $xml->asXML($thisfile_xml)) {
				$error = i18n_r('CHMOD_ERROR');
			} else {
				$x = getXML($thisfile_xml);
				$hashtag = $x->hashtag;
				$tweet_limit = $x->tweet_limit;
				$success = i18n_r('SETTINGS_UPDATED');
			}
		}
	}
	
	?>
	<h3><?php echo i18n_r($thisfile_lht.'/LAST_HASHTAG_TITLE'); ?></h3>
	
	<?php 
	if($success) { echo '<p style="color:#669933;"><b>'. $success .'</b></p>'; }
	if($error) { echo '<p style="color:#cc0000;"><b>'. $error .'</b></p>'; }
	?>
	
	<form method="post" action="<?php	echo $_SERVER ['REQUEST_URI']?>">
		
		<p><label for="inn_hashtag" ><?php i18n($thisfile_lht.'/HASHTAG'); ?></label><b>#  </b><input id="inn_hashtag" name="hashtag" class="text" value="<?php echo $hashtag; ?>" /></p>
		<p><label for="inn_tweet_limit" ><?php i18n($thisfile_lht.'/TWEET_LIMIT'); ?></label><input id="inn_tweet_limit" name="tweet_limit" class="text" value="<?php echo $tweet_limit; ?>" /></p>
		
		<p><input type="submit" id="submit" class="submit" value="<?php i18n('BTN_SAVESETTINGS'); ?>" name="submit" /></p>
	</form>
	
	<?php
}
