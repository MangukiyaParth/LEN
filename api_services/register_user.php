<?php

function login_user()
{
	global $outputjson, $gh, $db, $const, $tz_name, $tz_offset, $phone_format;
	$outputjson['success'] = 0;
	$username = $gh->read("username");
	$username = addslashes(str_replace('&apos;', "'", $username));
	$password = $gh->read("password");
	$dateNow = date('Y-m-d H:i:s');
	$from = $gh->read('from', PANEL_CONSTANT);
	$where = " ";
	if (empty($username)) {
		$outputjson['message'] = "Username is required.";
		return;
	}
	if (empty($password)) {
		$outputjson['message'] = "Password is required.";
		return;
	}
	
	$user_id = 0;	
	$query_user = "SELECT usr.* FROM tbl_users as usr WHERE usr.username ='" . $username . "'";
	$rows = $db->execute($query_user);

	if ($rows != null && is_array($rows) && count($rows) > 0) {
		$user = $rows[0];
		$userPassword = $user['password'];
		
		// remove password from user object
		unset($user["password"]);
		
		if ($userPassword == $password || $user_id > 0) {
			$user['token'] = $gh->getjwt($user['id'],$from);
			$outputjson['success'] = 1;
			$outputjson['global_search_flag'] = 1;
			$outputjson['message'] = 'User logged in successfully.';
			$outputjson["data"] = $user;
		} else {
			$outputjson['message'] = "Invalid password. Try again or use Forgot Password. If you are an employee and do not have an email associated with your account, contact your Account Administrator.";
		}
	} else {
		$outputjson['message'] = "Your account is Inactive or this Username does not exist. Please try again or contact support@amaz.com.";
	}
}
