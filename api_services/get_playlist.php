<?php

function get_playlist()
{
	global $outputjson, $gh, $db, $login_user_id;
	$outputjson['success'] = 0;
	$outputjson['status'] = 0;

	$page = $gh->read("page");
	$length = 20;
	$start = ($page - 1) * $length;
	$search = $gh->read("search","");

	$whereData = $basic_where = "1=1";
	if($search != "")
	{
		$whereData.= " AND (p.bass_player LIKE '%" . $search . "%')";
	}

	$total_count = $db->get_row_count('tbl_playlist', $basic_where);
	$count_query = "SELECT count(DISTINCT p.id) as cnt FROM tbl_playlist as p WHERE " . $whereData;
	$filtered_count = $db->execute_scalar($count_query);
	$query = "SELECT DISTINCT p.* FROM tbl_playlist as p WHERE " . $whereData . " LIMIT " . $start . "," . $length . "";
	$rows = $db->execute($query);

	if ($rows != null && is_array($rows) && count($rows) > 0) {
		foreach ($rows as $key => $song) {
			$playlist_id = $song['id'];
			$query_song = "SELECT s.*
				FROM `tbl_playlist_details` pd INNER JOIN tbl_songs s ON s.id = pd.song_id 
				WHERE pd.playlist_id = '$playlist_id'";
			$rows_song = $db->execute($query_song);
			$rows[$key]['songs'] = $rows_song;
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
