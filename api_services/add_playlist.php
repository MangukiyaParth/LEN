<?php

function add_playlist()
{
	global $outputjson, $gh, $db, $login_user_id;
	$outputjson['success'] = 0;
	$playlist = $gh->read("playlist");
	
	if ($playlist) {
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
			$outputjson['success'] = 1;
			$outputjson['message'] = "Playlist created successfully";
		}
		else {
			$outputjson['message'] = "Playlist already exist with same name";
		}
		$outputjson['result'] = array();
	} else {
		$outputjson['message'] = "Please add all fields!";
	}
}
