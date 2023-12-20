<?php

function add_comment()
{
	global $outputjson, $gh, $db, $login_user_id;
	$outputjson['success'] = 0;
	$song_id = $gh->read("song_id");
	$comment = $gh->read("comment");
	
	if ($song_id) {
		$qry_get_id = "SELECT IFNULL((SELECT comment_cnt FROM tbl_songs WHERE id = '$song_id'),'') AS comment_cnt";
		$rows_get_id = $db->execute($qry_get_id);
		$comment_cnt = $rows_get_id[0]['comment_cnt'];
		$new_cnt = (int)$comment_cnt + 1;
		$db->update("tbl_songs", array("comment_cnt"=>$new_cnt), array("id"=>$song_id));
		
		$comment_id = $gh->generateuniqid();
		$insert_arr = array(
			"id"=>$comment_id,
			"song_id"=>$song_id,
			"comment"=>$comment,
			"entry_by" => $login_user_id,
			"entry_at" => date('Y-m-d H:i:s')
		);
		$db->insert("tbl_comment_song", $insert_arr);
		$outputjson['result'] = array();
		$outputjson['success'] = 1;
		$outputjson['message'] = "Data added successfully";
	} else {
		$outputjson['message'] = "Please add all fields!";
	}
}
