<?php

function delete_playlist()
{
	global $outputjson, $gh, $db, $login_user_id;
	$outputjson['success'] = 0;
	$song_id = $gh->read("song_id", "");
	$playlist_id = $gh->read("playlist_id", "");
	
	if ($playlist_id) {
		if($song_id == ""){
			$db->delete("tbl_playlist_details", array("playlist_id"=>$playlist_id,"entry_by" => $login_user_id));
			$db->delete("tbl_playlist", array("id"=>$playlist_id,"entry_by"=>$login_user_id));
		}
		else {
			$db->delete("tbl_playlist_details", array("playlist_id"=>$playlist_id,"song_id"=>$song_id,"entry_by" => $login_user_id));
		}
		$outputjson['result'] = array();
		$outputjson['success'] = 1;
		$outputjson['message'] = "User Deleted successfully";
	} else {
		$outputjson['message'] = "Somthing went wrong!";
	}
}
