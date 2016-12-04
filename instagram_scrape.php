<?php

//returns a big old hunk of JSON from a non-private IG account page.
function scrape_insta($username) {
	$insta_source = file_get_contents('http://instagram.com/'.$username);
	$shards = explode('window._sharedData = ', $insta_source);
	$insta_json = explode(';</script>', $shards[1]); 
	$insta_array = json_decode($insta_json[0], TRUE);
	return $insta_array;
}

//Supply a username
$my_account = 'taylorswift'; 

//Do the deed
$results_array = scrape_insta($my_account);

//An example of where to go from there
$strs = [];
for ($x = 0; $x < 5; $x++ ){
	$arr = [];
	$tmp = $results_array['entry_data']['ProfilePage'][0]['user']['media']['nodes'][$x];
	$caption = $tmp['caption'];
	//date is in unix time
	$date = (string) $tmp['date'];
	// this is the pic you want to display
	$display = $tmp['display_src'];
	// might be useful?
	$thumbnail = $tmp['thumbnail_src'];
	$is_video = $tmp['is_video'];
	if( $is_video != 1 ){
		$is_video=0;
	}
	$is_video = (string) $is_video;
	$likes = (string) $tmp['likes']['count'];
	$arr = [ $caption, $date, $display, $thumbnail, $is_video, $likes ];
	array_push($strs, $arr);
	
}
$str = json_encode( $strs );

$output = fopen("insta.out","w");
fwrite( $output, $str );

// shamelessly stolen from https://gist.github.com/cosmocatalano/4544576
?>
