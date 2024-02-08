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

	$whereData = $basic_where = "entry_by='$login_user_id'";
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
		foreach ($rows as $key => $playlist) {
			$playlist_id = $playlist['id'];
			$query_song = "SELECT s.*,
				(SELECT COUNT(l.id) FROM `tbl_like_song` l WHERE l.song_id = s.`id` AND l.entry_by = '$login_user_id') AS is_liked,
				(SELECT GROUP_CONCAT(pl.playlist_id) FROM `tbl_playlist_details` pl WHERE pl.song_id = s.`id` AND pl.entry_by = '$login_user_id') AS playlist_ids  
				FROM `tbl_playlist_details` pd 
				INNER JOIN tbl_songs s ON s.id = pd.song_id 
				WHERE pd.playlist_id = '$playlist_id'";
			$rows_song = $db->execute($query_song);

			foreach ($rows_song as $song_key => $song) {
				$song_id = $song['id'];
				$query_comment = "SELECT comment.comment, comment.entry_by, comment.entry_at, user.name,
					CASE WHEN (comment.entry_by = '$login_user_id') THEN 1 ELSE 0 END AS my_comment
					FROM `tbl_comment_song` comment INNER JOIN tbl_users user ON user.id = comment.entry_by 
					WHERE comment.song_id = '$song_id'";
				$rows_comment = $db->execute($query_comment);
				$rows_song[$song_key]['comments'] = $rows_comment;
				
				$query_tbl_review = "SELECT * FROM `tbl_review` r WHERE r.song_id = '$song_id' AND entry_by = '$login_user_id'";
				$rows_tbl_review = $db->execute($query_tbl_review);
				$rows_song[$song_key]['my_review'] = $rows_tbl_review;
			}
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
