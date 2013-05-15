<?php if (!defined('IN_GS')) {die('you cannot load this page directly.');}

/*******************************************************
 * @function get_last_hashtag_link
 * @return string with tweet search link
 */
function get_last_hashtag_config() {
	# get XML data
	if (file_exists(LHTXMLFILE)) {
		$x = getXML(LHTXMLFILE);
		$hashtag = $x->hashtag;
		$tweet_limit = $x->tweet_limit;
		}
	else {
		$hashtag = 'test';
		$tweet_limit = '3';
		}
	return array($hashtag, $tweet_limit);
	}

/*******************************************************
 * @function get_last_hashtag_link
 * @return string with tweet search link
 */
function get_last_hashtag_link() {
	# get XML data
	$res = get_last_hashtag_config();
	$hashtag = $res[0];
	$tweet_limit = $res[1];
	return "http://search.twitter.com/search.json?q=%23$hashtag&rpp=$tweet_limit&include_entities=0";
	}

/*******************************************************
 * @function get_last_hashtag_tweet
 * @return array with tweet for hashtag
 */
function get_last_hashtag_tweets() {
	$tweets_link = get_last_hashtag_link();
	$json_tweet = file_get_contents($tweets_link);
	$json_obj = json_decode($json_tweet);
	return $json_obj->{'results'};
	}

?>
