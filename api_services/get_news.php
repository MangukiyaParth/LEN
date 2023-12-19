<?php

function get_news()
{
	global $outputjson, $gh, $db;
	$outputjson['success'] = 0;
	$outputjson['status'] = 0;

	$start = $gh->read("start");
	$length = $gh->read("length");
	$searcharr = $gh->read("search");
	$search = $searcharr['value'];
	$orderarr = $gh->read("order");
	$orderindex = $orderarr[0]['column'];
	$orderdir = $orderarr[0]['dir'];
	$columnsarr = $gh->read("columns");
	$ordercolumn = $columnsarr[$orderindex]['name'];

	$dateNow = date('Y-m-d H:i:s');
	$from = $gh->read('from', PANEL_CONSTANT);


	$whereData = "(b.title LIKE '%" . $search . "%')";

	$total_count = $db->get_row_count('tbl_news', "1=1");
	$count_query = "SELECT count(DISTINCT b.id) as cnt FROM tbl_news as b WHERE " . $whereData;
	$filtered_count = $db->execute_scalar($count_query);

	$orderby = "";
	if ($ordercolumn != "") {
		$orderby .= " ORDER BY " . $ordercolumn . " " . $orderdir;
	}
	$query_port_rates = "SELECT DISTINCT b.*,MD5(b.id) AS md5_id
		FROM tbl_news as b 
		WHERE " . $whereData . " " . $orderby . " LIMIT " . $start . "," . $length . "";
	$rows = $db->execute($query_port_rates);

	if ($rows != null && is_array($rows) && count($rows) > 0) {
		$outputjson['recordsTotal'] = $total_count;
		$outputjson['recordsFiltered'] = $filtered_count;
		$outputjson['success'] = 1;
		$outputjson['status'] = 1;
		$outputjson['message'] = 'success.';
		$outputjson["data"] = $rows;
	} else {
		$outputjson["data"] = [];
		$outputjson['recordsTotal'] = $total_count;
		$outputjson['recordsFiltered'] = 0;
		$outputjson['message'] = "No data found!";
	}
}
