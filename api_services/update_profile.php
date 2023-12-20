<?php

function update_profile()
{
	global $outputjson, $gh, $db, $login_user_id;
	$outputjson['success'] = 0;
	$name = $gh->read("name");
	
	if ($name) {
		$data = array( "name" => $name );
		$db->update("tbl_users", $data, array("id"=>$login_user_id));
		$outputjson['success'] = 1;
		$outputjson['message'] = "Data update successfully";
	} else {
		$outputjson['message'] = "Please add all fields!";
	}
}
