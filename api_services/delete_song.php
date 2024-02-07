<?php

function delete_song()
{
	global $outputjson, $gh, $db, $login_user_id;
	$outputjson['success'] = 0;
	$song_id = $gh->read("song_id","");
	
	if ($song_id && $login_user_id == 1) {
		$db->delete("tbl_songs", array("id"=>$song_id));
		$outputjson['result'] = array();
		$outputjson['success'] = 1;
		$outputjson['message'] = "Song Deleted successfully";
	} else {
		$outputjson['message'] = "Somthing went wrong!";
	}
}
