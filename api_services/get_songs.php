<?php

function get_songs()
{
	global $outputjson, $gh, $db, $login_user_id;
	$outputjson['success'] = 0;
	$outputjson['status'] = 0;

	$page = $gh->read("page");
	$length = 20;
	$start = ($page - 1) * $length;
	// $search_type_arr = $gh->read("search_type","");
	$search_type_arr = $_REQUEST["search_type"];
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
			$whereData = " bass_complexity IN (1,2) ";
			$orderby = " ORDER BY IFNULL(s.bass_complexity,0) ASC";
			break;
		case 4:
			// Intermediate basslines
			$whereData = " bass_complexity IN (3,4) ";
			$orderby = " ORDER BY IFNULL(s.bass_complexity,0) ASC";
			break;
		case 5:
			// Advanced basslines
			$whereData = " bass_complexity = 5 ";
			$orderby = " ORDER BY IFNULL(s.bass_complexity,0) ASC";
			break;
		case 6:
			//best Basstone
			$whereData = " bass_tone IN (3,4,5) ";
			$orderby = " ORDER BY IFNULL(s.bass_tone,0) DESC";
			break;
		case 7:
			//No so Good Basstone
			$whereData = " bass_tone IN (1,2,3) ";
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
			$whereData = " drum_complexity IN (1,2) ";
			$orderby = " ORDER BY IFNULL(s.drum_complexity,0) ASC";
			break;
		case 11:
			//Intermediate Drum
			$whereData = " drum_complexity IN (3,4) ";
			$orderby = " ORDER BY IFNULL(s.drum_complexity,0) ASC";
			break;
		case 12:
			//Advanced Drum
			$whereData = " drum_complexity = 5 ";
			$orderby = " ORDER BY IFNULL(s.drum_complexity,0) ASC";
			break;
		case 13:
			//best Drum
			$whereData = " drum_sound IN (3,4,5) ";
			$orderby = " ORDER BY IFNULL(s.drum_sound,0) DESC";
			break;
		case 14:
			//No so Good Drum
			$whereData = " drum_sound IN (1,2,3) ";
			$orderby = " ORDER BY IFNULL(s.drum_sound,0) ASC";
			break;
		case 15:
			//Drum solo
			$whereData = " IFNULL(drum_solo,0) = 1 ";
			break;
		default:
			# code...
			break;
	}

	$basic_where = $whereData;
	if($search_type_arr != "")
	{
		$search_type_arr = json_decode($search_type_arr, true);
		$whereData.= " AND ( 1=1 ";
		foreach($search_type_arr as $search_key => $search){
			$whereData.= " AND LOWER(s.".$search_key.") LIKE '%" . strtolower($search) . "%'";
			addToSearchHistory($search_key, $search);
		}
		$whereData.= ")";
	}
	else if($search != ""){
		addToSearchHistory("", $search);
		$whereData.= " AND (
			LOWER(s.bass_player) LIKE '%" . strtolower($search) . "%' OR 
			LOWER(s.title) LIKE '%" . strtolower($search) . "%' OR 
			LOWER(s.artist) LIKE '%" . strtolower($search) . "%' OR 
			LOWER(s.album) LIKE '%" . strtolower($search) . "%' OR 
			LOWER(s.year) LIKE '%" . strtolower($search) . "%' OR 
			LOWER(s.drummer) LIKE '%" . strtolower($search) . "%' OR 
			LOWER(s.instruments) LIKE '%" . strtolower($search) . "%' OR 
			LOWER(s.type) LIKE '%" . strtolower($search) . "%' OR 
			LOWER(s.genre) LIKE '%" . strtolower($search) . "%' OR 
			LOWER(s.referance) LIKE '%" . strtolower($search) . "%')";
	}

	$total_count = $db->get_row_count('tbl_songs', $basic_where);
	$count_query = "SELECT count(DISTINCT s.id) as cnt FROM tbl_songs as s WHERE " . $whereData;
	$filtered_count = $db->execute_scalar($count_query);

	$query = "SELECT DISTINCT s.*,
		(SELECT COUNT(id) FROM `tbl_like_song` l WHERE l.song_id = s.`id` AND l.entry_by = '$login_user_id') AS is_liked,
		(SELECT GROUP_CONCAT(pl.playlist_id) FROM `tbl_playlist_details` pl WHERE pl.song_id = s.`id` AND pl.entry_by = '$login_user_id') AS playlist_ids  
		FROM tbl_songs as s
		WHERE " . $whereData . " " . $orderby . " LIMIT " . $start . "," . $length . "";
	$rows = $db->execute($query);

	if ($rows != null && is_array($rows) && count($rows) > 0) {
		foreach ($rows as $key => $song) {
			$song_id = $song['id'];
			$query_comment = "SELECT comment.comment, comment.entry_by, comment.entry_at, user.name,
				CASE WHEN (user.username != '') THEN user.username ELSE user.name END AS comment_by,
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
