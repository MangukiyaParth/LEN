<?php

function delete_all_record()
{
	global $outputjson, $gh, $db;
	
	$type = $gh->read("type");
	$outputjson['success'] = 0;
	if($type == 'roles')
	{
		$db->execute_query('TRUNCATE TABLE tbl_roles');
	}
	else if($type == 'brand')
	{
		$dirname = "upload/images/brand";
		array_map('unlink', glob("$dirname/*"));
		array_map("rmdir", glob("$dirname/*")); 
		rmdir($dirname);
		$db->execute_query('TRUNCATE TABLE tbl_brand');
	}
	else if($type == 'news')
	{
		$dirname = "upload/images/news";
		array_map('unlink', glob("$dirname/*"));
		array_map("rmdir", glob("$dirname/*")); 
		rmdir($dirname);
		$db->execute_query('TRUNCATE TABLE tbl_news');
	}

	$outputjson['message'] = 'all data deleted successfully.';
	$outputjson['success'] = 1;
}
