<?php

function delete_record()
{
	global $outputjson, $gh, $db;
	$outputjson['success'] = 0;
	$type = $gh->read("type");
	$id = $gh->read("id");
	if($type=='roles')
	{
		if ($id > 0) {
			$db->delete('tbl_roles', array("id" => $id));
			$outputjson['message'] = 'data deleted successfully.';
			$outputjson['success'] = 1;
		} else {
			$outputjson['message'] = "Sorry, somthing went wrong!";
		}
	}
	else if($type=='brand')
	{
		if ($id > 0) {
			$dirname = "upload/images/brand/".$id;
			array_map('unlink', glob("$dirname/*"));
			array_map("rmdir", glob("$dirname/*")); 
			rmdir($dirname);
			$db->delete('tbl_brand', array("id" => $id));
			$outputjson['message'] = 'data deleted successfully.';
			$outputjson['success'] = 1;
		} else {
			$outputjson['message'] = "Sorry, somthing went wrong!";
		}
	}
	else if($type=='news')
	{
		if ($id > 0) {
			$dirname = "upload/images/news/".$id;
			array_map('unlink', glob("$dirname/*"));
			array_map("rmdir", glob("$dirname/*")); 
			rmdir($dirname);
			$db->delete('tbl_news', array("id" => $id));
			$outputjson['message'] = 'data deleted successfully.';
			$outputjson['success'] = 1;
		} else {
			$outputjson['message'] = "Sorry, somthing went wrong!";
		}
	}
	
}
