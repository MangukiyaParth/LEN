<?php

function add_review()
{
	global $outputjson, $gh, $db, $login_user_id;
	$outputjson['success'] = 0;
	$song_id = $gh->read("song_id");
	
	$overall_ratting = $gh->read("overall_ratting");
	$bass_complexity = $gh->read("bass_complexity");
	$drum_complexity = $gh->read("drum_complexity");
	$bass_tone = $gh->read("bass_tone");
	$drum_sound = $gh->read("drum_sound");
	$is_slap = $gh->read("is_slap"); // 1 or 0
	$bass_solo = $gh->read("bass_solo"); // 1 or 0
	$drum_solo = $gh->read("drum_solo"); // 1 or 0
	
	if ($song_id) {	
		
		$qry_get_id = "SELECT IFNULL((SELECT id FROM tbl_review WHERE song_id = '$song_id' AND entry_by = '$login_user_id'),'') AS review_id";
		$rows_get_id = $db->execute($qry_get_id);
		$review_id = $rows_get_id[0]['review_id'];
		if($review_id == ''){
			$review_id = $gh->generateuniqid();
			$insert_arr = array(
				"id" => $review_id,
				"song_id" => $song_id,
				"overall_ratting" => $overall_ratting,
				"bass_complexity" => $bass_complexity,
				"drum_complexity" => $drum_complexity,
				"bass_tone" => $bass_tone,
				"drum_sound" => $drum_sound,
				"is_slap" => $is_slap,
				"bass_solo" => $bass_solo,
				"drum_solo" => $drum_solo,
				"entry_by" => $login_user_id,
				"entry_at" => date('Y-m-d H:i:s')
			);
			$db->insert("tbl_review", $insert_arr);
		}
		else {
			$update_arr = array(
				"overall_ratting" => $overall_ratting,
				"bass_complexity" => $bass_complexity,
				"drum_complexity" => $drum_complexity,
				"bass_tone" => $bass_tone,
				"drum_sound" => $drum_sound,
				"is_slap" => $is_slap,
				"bass_solo" => $bass_solo,
				"drum_solo" => $drum_solo,
				"update_by" => $login_user_id,
				"update_at" => date('Y-m-d H:i:s')
			);
			$db->update("tbl_review", $update_arr, array("id" => $review_id));
		}
		$qry_avg = "SELECT (SUM(overall_ratting)/COUNT(id)) AS overall_ratting,
			(SUM(bass_complexity)/COUNT(id)) AS bass_complexity, 
			(SUM(drum_complexity)/COUNT(id)) AS drum_complexity, 
			(SUM(bass_tone)/COUNT(id)) AS bass_tone, 
			(SUM(drum_sound)/COUNT(id)) AS drum_sound,
			(SUM(is_slap)/COUNT(id)) AS is_slap,
			(SUM(bass_solo)/COUNT(id)) AS bass_solo,
			(SUM(drum_solo)/COUNT(id)) AS drum_solo
			FROM tbl_review r WHERE r.`song_id` = '$song_id'";
		$rows_avg = $db->execute($qry_avg);
		$avg = $rows_avg[0];

		$update_arr = array(
			"overall_ratting" => round((int)$avg['overall_ratting']),
			"bass_complexity" => round((int)$avg['bass_complexity']),
			"drum_complexity" => round((int)$avg['drum_complexity']),
			"bass_tone" => round((int)$avg['bass_tone']),
			"drum_sound" => round((int)$avg['drum_sound']),
			"is_slap" => round((int)$avg['is_slap']),
			"bass_solo" => round((int)$avg['bass_solo']),
			"drum_solo" => round((int)$avg['drum_sol0'])
		);
		$db->update("tbl_songs", $update_arr, array("id" => $song_id));

		$outputjson['result'] = array();
		$outputjson['success'] = 1;
		$outputjson['message'] = "Data added successfully";
	} else {
		$outputjson['message'] = "Please add all fields!";
	}
}
