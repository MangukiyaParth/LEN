<?php

function delete_user()
{
	global $outputjson, $gh, $db, $login_user_id;
	$outputjson['success'] = 0;
	
	if ($login_user_id) {
		$db->delete("tbl_users", array("id"=>$login_user_id));
		$outputjson['result'] = array();
		$outputjson['success'] = 1;
		$outputjson['message'] = "User Deleted successfully";
	} else {
		$outputjson['message'] = "Somthing went wrong!";
	}
}
