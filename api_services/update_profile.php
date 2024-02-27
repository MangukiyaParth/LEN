<?php

function update_profile()
{
	global $outputjson, $gh, $db, $login_user_id;
	$outputjson['success'] = 0;
	$name = $gh->read("name");
	$username = $gh->read("username");
	
	if ($name) {
		if($username != ""){
			$query_user = "SELECT usr.* FROM tbl_users as usr WHERE usr.username ='$username' AND id <> '$login_user_id'";
			$rows = $db->execute($query_user);
			$user = [];
			if ($rows != null && is_array($rows) && count($rows) > 0) {
				$outputjson['message'] = "Username already taken.";
			} else {
				$data = array( 
					"name" => $name, 
					"username" => $username,
				);
				$db->update("tbl_users", $data, array("id"=>$login_user_id));

				$outputjson['success'] = 1;
				$outputjson['message'] = "Data update successfully";
			}
		}
		else {
			$data = array( "name" => $name );
			$db->update("tbl_users", $data, array("id"=>$login_user_id));

			$outputjson['success'] = 1;
			$outputjson['message'] = "Data update successfully";
		}
	} else {
		$outputjson['message'] = "Please add all fields!";
	}
}
