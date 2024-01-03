<?php

function login_user()
{
	global $outputjson, $gh, $db;
	$outputjson['success'] = 0;
	$token = $gh->read("token");
	$fcm_token = $gh->read("fcm_token");
	if (empty($token)) {
		$outputjson['message'] = "token is required.";
		return;
	}
	
	$firebase_data = ["erroe"=>"somthing went wrong!"];
	$firebase_status = 0;
	try{
		$curl_handle = curl_init();
		curl_setopt($curl_handle, CURLOPT_URL, "https://identitytoolkit.googleapis.com/v1/accounts:lookup?key=".FIREBASE_KEY);
		curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl_handle, CURLOPT_POST, 1);
		curl_setopt($curl_handle, CURLOPT_POSTFIELDS, json_encode(array("idToken"=>$token)));
		curl_setopt($curl_handle, CURLOPT_HTTPHEADER, array('Content-Type: text/plain')); 
		$buffer = curl_exec($curl_handle);
		curl_close($curl_handle);
		$result = json_decode($buffer, true);
		
		// print_r($result['error']);
		if (empty($buffer) || $result['error']){
			// print "Nothing returned from url.<p>";
		}
		else{
			$firebase_status = 1;
			$firebase_data = $result;
		}
	} catch (Exception $e) {
		$gh->Log($e);
	}

	// print_r($firebase_data);
	if($firebase_status == 1 && !empty($firebase_data['users']))
	{
		$email = $firebase_data['users'][0]['email'];
		$query_user = "SELECT usr.* FROM tbl_users as usr WHERE usr.username ='$email'";
		$rows = $db->execute($query_user);
		$user = [];
		if ($rows != null && is_array($rows) && count($rows) > 0) {
			$user = $rows[0];
			$user_id = $user['id'];
			if($fcm_token != "")
			{
				$user["fcm_token"]=$fcm_token;
				$db->update("tbl_users", array("fcm_token" => $fcm_token), array("id" => $user['id']));
			}
			unset($user["password"]);
		} else {
			$emailVerified = $firebase_data['users'][0]['emailVerified'];
			$localId = $firebase_data['users'][0]['localId'];
			$name = $firebase_data['users'][0]['displayName'];
			$provider_info = $firebase_data['users'][0]['providerUserInfo'][0];
			$provider = $firebase_data['users'][0]['providerUserInfo'][0]['providerId'];
			$exp_name = explode(' ',$name);
			$fname = $exp_name[0];
			$lname = $exp_name[1];
			
			$user_id = $gh->generateuniqid();
			$insert_arr = array(
				"id" => $user_id,
				"name" => $name,
				"fname" => $fname,
				"lname" => $lname,
				"email" => $email,
				"username" => $email,
				"email_verified" => $emailVerified,
				"local_id" => $localId,
				"provider" => $provider,
				"provider_info" => json_encode($provider_info),
				"fcm_token" => $fcm_token,
				"role_id" => "17032249-8048-6243-9ae7-5df91521499a",
				"insert_at" => date('Y-m-d H:i:s'),
			);
			$db->insert("tbl_users", $insert_arr);
			$query_user = "SELECT usr.* FROM tbl_users as usr WHERE usr.id ='$user_id'";
			$rows = $db->execute($query_user);
			$user = $rows[0];
			unset($user["password"]);
		}
		$token_data = $gh->getjwt($user_id,$user['provider'],0);
		$outputjson['success'] = 1;
		$outputjson['message'] = 'User logged in successfully.';
		$outputjson["data"] = $user;
		$outputjson["token"] = $token_data['token'];
	}
	else {
		$outputjson['message'] = "somthing went wrong!";
	}
}
