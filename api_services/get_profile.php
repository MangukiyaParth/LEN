<?php

function get_profile()
{
	global $outputjson, $gh, $db, $login_user_id;
	$outputjson['success'] = 0;
	$outputjson['status'] = 0;
	
	$query = "SELECT DISTINCT * FROM tbl_users WHERE id = '$login_user_id'";
	$rows = $db->execute($query);

	if ($rows != null && is_array($rows) && count($rows) > 0) {
		$outputjson['success'] = 1;
		$outputjson['status'] = 1;
		$outputjson['message'] = 'success.';
		$outputjson["data"] = $rows;
	} else {
		$outputjson["data"] = [];
		$outputjson['message'] = "No data found!";
	}
}
