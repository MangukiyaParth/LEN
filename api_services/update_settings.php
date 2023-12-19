<?php

function update_settings()
{
	global $outputjson, $gh, $db;
	$outputjson['success'] = 0;

	$cmp_name = $gh->read("cmp_name");
	$cmp_email = $gh->read("cmp_email");
	$admin_email = $gh->read("admin_email");
	$admin_email_password = $gh->read("admin_email_password");
	$contact1 = $gh->read("contact1");
	$contact2 = $gh->read("contact2");
	$address = $gh->read("address");
	$upi = $gh->read("upi");
	$pixel = $_POST["pixel"];
	$show_gpay = $gh->read("show_gpay");
	$pay_type = $gh->read("pay_type");
	$payment_script = $_POST["payment_script"];
	$password = $gh->read("password", "");
	$allowed_ip = $gh->read("allowed_ip", "");
	$otp = $gh->read("otp", "");


	if ($cmp_name != "" && $cmp_email != "" && $admin_email != "" && $admin_email_password != "" && $contact1 != "" && $contact2 != "" && $address != "") {
		// $query_setting = "SELECT * FROM tbl_settings WHERE id = 1";
		// $rows = $db->execute($query_setting);
		// $chkotp = $rows[0]['otp'];
		// $attempt = $rows[0]['attempt'];

		// if($attempt <= 3)
		if(true)
		{
			// if($otp!="" && $chkotp == $otp)
			if(true)
			{
				$gpay_flag = 0;
				if($show_gpay){
					$gpay_flag = 1;
				}
				$data = array(
					"show_gpay" => $gpay_flag,
					"pay_type" => $pay_type,
					"payment_script" => $payment_script,
					"upi" => $upi,
					"pixel" => $pixel,
					"allowed_ip" => $allowed_ip,
					"otp" => "",
					"attempt" => "0",
				);
				$rows = $db->update('tbl_settings', $data, array("id" => 1));

				if ($password != "") {
					$db->update('tbl_users', array("password" => $password), array("id" => 1));
				}

				$myfile = fopen("../setting.php", "w") or die("Unable to open file!");
				$txt_payment_script = "";
				$upi_script = '<script>var UPI_ID = "' . $upi . '"</script>';
				fwrite($myfile, '<script>var SHOW_GPAY = ' . $show_gpay . '</script>');
				fwrite($myfile, $upi_script);
				fwrite($myfile, $txt_payment_script);
				$txt = str_replace("&apos;", "'", $pixel);
				fwrite($myfile, $txt);
				fclose($myfile);

				$outputjson['pixel'] = $pixel;
				$outputjson['success'] = 1;
				$outputjson['message'] = 'Settings updated successfully.';
				$outputjson["data"] = $rows;
			}
			else {
				// $update = array();
				// $update['attempt'] = $attempt + 1;
				// $db->update('tbl_settings', $update, array("id" => 1));
				$outputjson["data"] = [];
				$outputjson['message'] = "Please enter valid otp";
			}
		}
		else {
			// $update = array();
			// $update['attempt'] = 0;
			// $db->update('tbl_settings', $update, array("id" => 1));
			$outputjson["data"] = [];
			$outputjson["manage"] = 2;
			$outputjson['message'] = "Reached maximum number of attempt! Please try again";
		}
	} else {
		$outputjson["data"] = [];
		$outputjson['message'] = "Error!";
	}
}
