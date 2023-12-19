<?php

function add_songs()
{
	global $outputjson, $gh, $db, $login_user_id;
	$outputjson['success'] = 0;

	$bass_player = $gh->read("bass_player");
	$title = $gh->read("title");
	$artist = $gh->read("artist");
	$album = $gh->read("album");
	$apple_link = $gh->read("apple_link");
	$spotify_link = $gh->read("spotify_link");
	$year = $gh->read("year");
	$drummer = $gh->read("drummer");
	$instruments = $gh->read("instruments");
	$overall_ratting = $gh->read("overall_ratting");
	$bass_complexity = $gh->read("bass_complexity");
	$drum_complexity = $gh->read("drum_complexity");
	$bass_tone = $gh->read("bass_tone");
	$drum_sound = $gh->read("drum_sound");
	$is_slap = $gh->read("is_slap");
	$bass_solo = $gh->read("bass_solo");
	$drum_solo = $gh->read("drum_solo");
	$type = $gh->read("type");
	$genre = $gh->read("genre");
	$referance = $gh->read("referance");
	$description = $_REQUEST["description"];

	
	if ($title && $spotify_link && $apple_link && $description) {
		$news_id = $gh->generateuniqid();
		$data = array(
			"id"=>$news_id,
			"bass_player"=>$bass_player,
			"title"=>$title,
			"artist"=>$artist,
			"album"=>$album,
			"apple_link"=>$apple_link,
			"spotify_link"=>$spotify_link,
			"year"=>$year,
			"drummer"=>$drummer,
			"instruments"=>$instruments,
			"overall_ratting"=>$overall_ratting,
			"bass_complexity"=>$bass_complexity,
			"drum_complexity"=>$drum_complexity,
			"bass_tone"=>$bass_tone,
			"drum_sound"=>$drum_sound,
			"is_slap"=>$is_slap,
			"bass_solo"=>$bass_solo,
			"drum_solo"=>$drum_solo,
			"type"=>$type,
			"genre"=>$genre,
			"referance"=>$referance,
			"entry_uid" => $login_user_id,
			"entry_date" => date('d/m/Y H:i:s')
		);
		$db->insert("tbl_songs", $data);
		$outputjson['result'] = $data;
		$outputjson['success'] = 1;
		$outputjson['message'] = "Data added successfully";
	} else {
		$outputjson['message'] = "Please add all fields!";
	}
}
