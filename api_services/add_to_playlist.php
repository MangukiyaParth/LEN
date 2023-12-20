<?php

function add_to_playlist()
{
	global $outputjson, $gh, $db, $login_user_id;
	$outputjson['success'] = 0;
	$song_id = $gh->read("song_id");
	$playlist = $gh->read("playlist");
	// $playlist_id = $gh->read("playlist_id", 0);
	
	if ($song_id && $playlist) {
		$qry_get_id = "SELECT IFNULL((SELECT id FROM tbl_playlist WHERE playlist = '$playlist' AND entry_by = '$login_user_id'),'') AS playlist_id";
		$rows_get_id = $db->execute($qry_get_id);
		$playlist_id = $rows_get_id[0]['playlist_id'];
		if($playlist_id == ''){
			$playlist_id = $gh->generateuniqid();
			$insert_arr = array(
				"id"=>$playlist_id,
				"playlist"=>$playlist,
				"entry_by" => $login_user_id,
				"entry_at" => date('Y-m-d H:i:s')
			);
			$db->insert("tbl_playlist", $insert_arr);
		}

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
