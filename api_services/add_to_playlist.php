<?php

function add_to_playlist()
{
	global $outputjson, $gh, $db, $login_user_id;
	$outputjson['success'] = 0;
	$song_id = $gh->read("song_id");
	// $playlist = $gh->read("playlist");
	$playlist_id = $gh->read("playlist_id", "");
	
	if ($song_id && $playlist_id) {
		$playlist_detail_id = $gh->generateuniqid();
		$insert_detail_arr = array(
			"id"=>$playlist_detail_id,
			"playlist_id"=>$playlist_id,
			"song_id"=>$song_id,
			"entry_by" => $login_user_id,
			"entry_at" => date('Y-m-d H:i:s')
		);
		$db->insert("tbl_playlist_details", $insert_detail_arr);
		$outputjson['result'] = array();
		$outputjson['success'] = 1;
		$outputjson['message'] = "Data added successfully";
	} else {
		$outputjson['message'] = "Please add all fields!";
	}
}
