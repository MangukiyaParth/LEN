<?php

function get_songs()
{
	global $outputjson, $gh, $db, $login_user_id;
	$outputjson['success'] = 0;
	$outputjson['status'] = 0;

	$page = $gh->read("page");
	$length = 20;
	$start = ($page - 1) * $length;
	$search_type = $gh->read("search_type","");
	$search = $gh->read("search","");
	$orderdir = $gh->read("orderdir");
	$ordercolumn = $gh->read('ordercolumn');
	$get_liked = $gh->read('get_liked',0);
	$list_type = $gh->read('list_type',0); 
	// 1 - most liked
	// 2 - top rated
	// 3 - Easy basslines
	// 4 - Intermediate basslines
	// 5 - Advanced baselines
	// 6 - best Basstone
	// 7 - No so Good Basstone
	// 8 - Slap Bass
	// 9 - Bass solo
	// 10 - Easy Drum
	// 11 - Intermediate Drum
	// 12 - Advanced Drum
	// 13 - best Drum
	// 14 - No so Good Drum
	// 15 - Drum Solo

	$whereData = "1=1";
	if($get_liked == 1)
	{
		$whereData = "id IN (SELECT song_id FROM tbl_like_song WHERE entry_by = '$login_user_id')";
	}

	$orderby = "";
	if ($ordercolumn != "") {
		$orderby .= " ORDER BY " . $ordercolumn . " " . $orderdir;
	}
	switch ($list_type) {
		case 1:
			// most liked
			$orderby = " ORDER BY IFNULL(s.like_cnt,0) DESC";
			break;
		case 2:
			// Top Rated
			$orderby = " ORDER BY IFNULL(s.avg_ratting,0) DESC";
			break;
		case 3:
			// Easy basslines
			$whereData = " s.bass_complexity IN (1,2) ";
			$orderby = " ORDER BY IFNULL(s.bass_complexity,0) ASC";
			break;
		case 4:
			// Intermediate basslines
			$whereData = " s.bass_complexity IN (3,4) ";
			$orderby = " ORDER BY IFNULL(s.bass_complexity,0) ASC";
			break;
		case 5:
			// Advanced basslines
			$whereData = " s.bass_complexity = 5 ";
			$orderby = " ORDER BY IFNULL(s.bass_complexity,0) ASC";
			break;
		case 6:
			//best Basstone
			$whereData = " s.bass_tone IN (3,4,5) ";
			$orderby = " ORDER BY IFNULL(s.bass_tone,0) DESC";
			break;
		case 7:
			//No so Good Basstone
			$whereData = " s.bass_tone IN (1,2,3) ";
			$orderby = " ORDER BY IFNULL(s.bass_tone,0) ASC";
			break;
		case 8:
			//Slap Bass
			$whereData = " IFNULL(s.is_slap,0) = 1 ";
			break;
		case 9:
			//Bass solo
			$whereData = " IFNULL(s.bass_solo,0) = 1 ";
			break;
		case 10:
			//Easy Drum
			$whereData = " s.drum_complexity IN (1,2) ";
			$orderby = " ORDER BY IFNULL(s.drum_complexity,0) ASC";
			break;
		case 11:
			//Intermediate Drum
			$whereData = " s.drum_complexity IN (3,4) ";
			$orderby = " ORDER BY IFNULL(s.drum_complexity,0) ASC";
			break;
		case 12:
			//Advanced Drum
			$whereData = " s.drum_complexity = 5 ";
			$orderby = " ORDER BY IFNULL(s.drum_complexity,0) ASC";
			break;
		case 13:
			//best Drum
			$whereData = " s.drum_sound IN (3,4,5) ";
			$orderby = " ORDER BY IFNULL(s.drum_sound,0) DESC";
			break;
		case 14:
			//No so Good Drum
			$whereData = " s.drum_sound IN (1,2,3) ";
			$orderby = " ORDER BY IFNULL(s.drum_sound,0) ASC";
			break;
		case 15:
			//Drum solo
			$whereData = " IFNULL(s.drum_solo,0) = 1 ";
			break;
		default:
			# code...
			break;
	}

	$basic_where = $whereData;

	if($search != "")
	{
		$whereData.= " AND (s.bass_player LIKE '%" . $search . "%' OR 
			s.title LIKE '%" . $search . "%' OR 
			s.artist LIKE '%" . $search . "%' OR 
			s.album LIKE '%" . $search . "%' OR 
			s.year LIKE '%" . $search . "%' OR 
			s.drummer LIKE '%" . $search . "%' OR 
			s.instruments LIKE '%" . $search . "%' OR 
			s.type LIKE '%" . $search . "%' OR 
			s.genre LIKE '%" . $search . "%' OR 
			s.referance LIKE '%" . $search . "%')";
		if($search_type != "")
		{
			$whereData.= " AND (s.$search_type LIKE '%" . $search . "%')";
		}

		$history_id = $gh->generateuniqid();
		$insert_arr = array(
			"id"=>$history_id,
			"search_type"=>$search_type,
			"search"=>$search,
			"entry_by" => $login_user_id,
			"entry_at" => date('Y-m-d H:i:s')
		);
		$db->insert("tbl_search_history", $insert_arr);
		
		$qry_get_id = "SELECT * FROM tbl_search_keyword WHERE search_type = '$search_type' AND search = '$search'";
		$rows_get_id = $db->execute($qry_get_id);
		if ($rows_get_id != null && is_array($rows_get_id) && count($rows_get_id) > 0) {
			$keyword_id = $rows_get_id[0]['id'];
			$cnt = $rows_get_id[0]['cnt'];
			$update_arr = array(
				"cnt"=>$cnt+1,
			);
			$db->update("tbl_search_keyword", $update_arr, array("id"=>$keyword_id));
		}
		else{
			$keyword_id = $gh->generateuniqid();
			$insert_arr = array(
				"id"=>$keyword_id,
				"search_type"=>$search_type,
				"search"=>$search,
				"cnt"=>1,
				"entry_by" => $login_user_id,
				"entry_at" => date('Y-m-d H:i:s')
			);
			$db->insert("tbl_search_keyword", $insert_arr);
		}
	}

	$total_count = $db->get_row_count('tbl_songs', $basic_where);
	$count_query = "SELECT count(DISTINCT s.id) as cnt FROM tbl_songs as s WHERE " . $whereData;
	$filtered_count = $db->execute_scalar($count_query);

	$query = "SELECT DISTINCT s.*,
	(SELECT COUNT(id) FROM `tbl_like_song` l WHERE l.song_id = s.`id` AND l.entry_by = '$login_user_id') AS is_liked 
		FROM tbl_songs as s
		WHERE " . $whereData . " " . $orderby . " LIMIT " . $start . "," . $length . "";
	$rows = $db->execute($query);

	if ($rows != null && is_array($rows) && count($rows) > 0) {
		foreach ($rows as $key => $song) {
			$song_id = $song['id'];
			$query_comment = "SELECT comment.comment, comment.entry_by, comment.entry_at, user.name,
				CASE WHEN (comment.entry_by = '$login_user_id') THEN 1 ELSE 0 END AS my_comment
				FROM `tbl_comment_song` comment INNER JOIN tbl_users user ON user.id = comment.entry_by 
				WHERE comment.song_id = '$song_id'";
			$rows_comment = $db->execute($query_comment);
			$rows[$key]['comments'] = $rows_comment;
			
			$query_tbl_review = "SELECT * FROM `tbl_review` r WHERE r.song_id = '$song_id' AND entry_by = '$login_user_id'";
			$rows_tbl_review = $db->execute($query_tbl_review);
			$rows[$key]['my_review'] = $rows_tbl_review;
		}
		$outputjson['recordsTotal'] = $total_count;
		$outputjson['recordsFiltered'] = $filtered_count;
		$outputjson['success'] = 1;
		$outputjson['status'] = 1;
		$outputjson['message'] = 'success.';
		$outputjson["data"] = $rows;
	} else {
		$outputjson["data"] = [];
		$outputjson['recordsTotal'] = $total_count;
		$outputjson['recordsFiltered'] = 0;
		$outputjson['message'] = "No data found!";
	}
}
