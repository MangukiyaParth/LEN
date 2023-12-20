<?php

function add_like()
{
	global $outputjson, $gh, $db, $login_user_id;
	$outputjson['success'] = 0;
	$song_id = $gh->read("song_id");

	
	if ($song_id) {
		$qry_get_id = "SELECT IFNULL((SELECT id FROM tbl_like_song WHERE song_id = '$song_id' AND entry_by = '$login_user_id'),'') AS like_id, IFNULL((SELECT like_cnt FROM tbl_songs WHERE id = '$song_id'),'') AS like_cnt";
		$rows_get_id = $db->execute($qry_get_id);
		$like_id = $rows_get_id[0]['like_id'];
		$like_cnt = $rows_get_id[0]['like_cnt'];
		$new_cnt = 0;
		if ($like_id != '') {
			$db->delete("tbl_like_song", array("id"=>$like_id));
			$new_cnt = ((int)$like_cnt > 0) ? ((int)$like_cnt - 1) : 0;
		}
		else{
			$keyword_id = $gh->generateuniqid();
			$insert_arr = array(
				"id"=>$keyword_id,
				"song_id"=>$song_id,
				"entry_by" => $login_user_id,
				"entry_at" => date('Y-m-d H:i:s')
			);
			$db->insert("tbl_like_song", $insert_arr);
			$new_cnt = (int)$like_cnt + 1;
		}
		$db->update("tbl_songs", array("like_cnt"=>$new_cnt), array("id"=>$song_id));
		$outputjson['new_cnt'] = $new_cnt;
		$outputjson['result'] = array();
		$outputjson['success'] = 1;
		$outputjson['message'] = "Data added successfully";
	} else {
		$outputjson['message'] = "Please add all fields!";
	}
}
