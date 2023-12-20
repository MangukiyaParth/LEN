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
	// $overall_ratting = $gh->read("overall_ratting");
	// $bass_complexity = $gh->read("bass_complexity");
	// $drum_complexity = $gh->read("drum_complexity");
	// $bass_tone = $gh->read("bass_tone");
	// $drum_sound = $gh->read("drum_sound");
	$is_slap = $gh->read("is_slap");
	$bass_solo = $gh->read("bass_solo");
	$drum_solo = $gh->read("drum_solo");
	$type = $gh->read("type");
	$genre = $gh->read("genre");
	$referance = $gh->read("referance");

	
	if ($title && $spotify_link && $apple_link) {

		$qry_get_id = "SELECT IFNULL((SELECT id FROM tbl_album WHERE album = '$album'),0) AS album_id,
			IFNULL((SELECT id FROM tbl_song_type WHERE song_type = '$type'),0) AS type_id,
			IFNULL((SELECT id FROM tbl_genre WHERE genre = '$genre'),0) AS genre_id,
			IFNULL((SELECT id FROM tbl_artist WHERE artist = '$artist'),0) AS artist_id";
		$rows_get_id = $db->execute($qry_get_id);
		$ids = $rows_get_id[0];
		$album_id = $ids['album_id'];
		$type_id = $ids['type_id'];
		$genre_id = $ids['genre_id'];
		$artist_id = $ids['artist_id'];

		if($album_id == 0){
			$album_id = $gh->generateuniqid();
			$album_data = array(
				"id"=>$album_id,
				"album"=>$album,
				"entry_by" => $login_user_id,
				"entry_at" => date('Y-m-d H:i:s')
			);
			$db->insert("tbl_album", $album_data);
		}
		if($type_id == 0){
			$type_id = $gh->generateuniqid();
			$type_data = array(
				"id"=>$type_id,
				"song_type"=>$type,
				"entry_by" => $login_user_id,
				"entry_at" => date('Y-m-d H:i:s')
			);
			$db->insert("tbl_song_type", $type_data);
		}
		if($genre_id == 0){
			$genre_id = $gh->generateuniqid();
			$genre_data = array(
				"id"=>$genre_id,
				"genre"=>$genre,
				"entry_by" => $login_user_id,
				"entry_at" => date('Y-m-d H:i:s')
			);
			$db->insert("tbl_genre", $genre_data);
		}
		if($artist_id == 0){
			$artist_id = $gh->generateuniqid();
			$artist_data = array(
				"id"=>$artist_id,
				"artist"=>$artist,
				"entry_by" => $login_user_id,
				"entry_at" => date('Y-m-d H:i:s')
			);
			$db->insert("tbl_artist", $artist_data);
		}

		$news_id = $gh->generateuniqid();
		$data = array(
			"id"=>$news_id,
			"bass_player"=>$bass_player,
			"title"=>$title,
			"artist"=>$artist,
			"artist_id"=>$artist_id,
			"album"=>$album,
			"album_id"=>$album_id,
			"apple_link"=>$apple_link,
			"spotify_link"=>$spotify_link,
			"year"=>$year,
			"drummer"=>$drummer,
			"instruments"=>$instruments,
			// "overall_ratting"=>$overall_ratting,
			// "bass_complexity"=>$bass_complexity,
			// "drum_complexity"=>$drum_complexity,
			// "bass_tone"=>$bass_tone,
			// "drum_sound"=>$drum_sound,
			"is_slap"=>$is_slap,
			"bass_solo"=>$bass_solo,
			"drum_solo"=>$drum_solo,
			"type"=>$type,
			"type_id"=>$type_id,
			"genre"=>$genre,
			"genre_id"=>$genre_id,
			"referance"=>$referance,
			"entry_by" => $login_user_id,
			"entry_at" => date('Y-m-d H:i:s')
		);
		$db->insert("tbl_songs", $data);
		$outputjson['result'] = $data;
		$outputjson['success'] = 1;
		$outputjson['message'] = "Data added successfully";
	} else {
		$outputjson['message'] = "Please add all fields!";
	}
}
