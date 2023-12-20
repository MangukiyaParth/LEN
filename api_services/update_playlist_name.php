<?php

function update_playlist_name()
{
	global $outputjson, $gh, $db, $login_user_id;
	$outputjson['success'] = 0;
	$playlist = $gh->read("playlist");
	$playlist_id = $gh->read("playlist_id", 0);
	
	if ($playlist && $playlist_id) {
		$qry_get_id = "SELECT IFNULL((SELECT id FROM tbl_playlist WHERE id = '$playlist_id' AND entry_by = '$login_user_id'),'') AS playlist_id";
		$rows_get_id = $db->execute($qry_get_id);
		$playlist_id = $rows_get_id[0]['playlist_id'];
		if($playlist_id != ''){
			$update_arr = array(
				"playlist"=>$playlist,
				"update_by" => $login_user_id,
				"update_at" => date('Y-m-d H:i:s')
			);
			$db->update("tbl_playlist", $update_arr, array("id"=>$playlist_id));
			$outputjson['result'] = array();
			$outputjson['success'] = 1;
			$outputjson['message'] = "Data added successfully";
		}
		else {
			$outputjson['result'] = array();
			$outputjson['success'] = 0;
			$outputjson['message'] = "Invalid Request";
		}
	} else {
		$outputjson['message'] = "Please add all fields!";
	}
}
