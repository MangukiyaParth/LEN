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

	$whereData = $basic_where = "1=1";
	if($get_liked == 1)
	{
		$whereData = $basic_where = "id IN (SELECT song_id FROM tbl_like_song WHERE entry_by = '$login_user_id')";
	}
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

	$orderby = "";
	if ($ordercolumn != "") {
		$orderby .= " ORDER BY " . $ordercolumn . " " . $orderdir;
	}
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
