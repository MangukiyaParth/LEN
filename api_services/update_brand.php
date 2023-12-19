<?php

function update_brand()
{
	global $outputjson, $gh, $db;
	$outputjson['success'] = 0;

	$name = $gh->read("name");
	$id = $gh->read("id");
	$file = json_decode($_POST["file"], true);
	if ($name) {
		$brand_id = $id;
		$data = array( "brand" => $name );
		if (str_contains($_POST["file"], 'tmp/'))
		{
			$file_url = $file[0]['url'];
			$file_name = $file[0]['name'];
			$file_new_url = str_replace('tmp/','images/', $file_url);
			$logo_data = str_replace('tmp/','images/', $_POST["file"]);
			$gh->check_directory_path(str_replace($file_name,$brand_id.'/', $file_new_url));// Create directory if not exist
			$file_new_url = str_replace($file_name,$brand_id.'/'.$file_name, $file_new_url);
			$logo_data = str_replace($logo_data,$brand_id.'/'.$file_name, $logo_data);
			rename($file_url, $file_new_url);
			$data['logo'] = $file_new_url;
			$data['logo_data'] = $logo_data;

			$query = "SELECT count(DISTINCT b.id) as cnt FROM tbl_brand as b WHERE id = '" . $brand_id ."'";
			$rows = $db->execute($query);
			if ($rows != null && is_array($rows) && count($rows) > 0) {
				unlink($rows[0]['logo']);
			}
		}
		$db->update("tbl_brand", $data, array("id"=>$brand_id));
		$outputjson['result'] = $file_url;
		$outputjson['success'] = 1;
		$outputjson['message'] = "Data update successfully";
	} else {
		$outputjson['message'] = "Please add all fields!";
	}
}
