<?php

function upload_csv()
{
	global $outputjson, $gh, $db, $login_user_id;
	$outputjson['success'] = 0;

	$target_dir = "upload/csv/";
	$target_file = $target_dir . date("Y_m_d_h_i_s_") . basename($_FILES["file"]["name"]);
	$uploadOk = 1;

	if (isset($_FILES['file'])) {

		$message = "";
		$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

		// Allow certain file formats
		if ($imageFileType != "csv") {
			$message = "Sorry, only CSV file is allowed.";
			$uploadOk = 0;
		}

		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
			$outputjson['message'] = $message;
		} else {
			move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);
			if (isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {
				// Open the CSV file and read its contents
				$handle = fopen($target_file, "r");
				if ($handle !== FALSE) {
					// Loop through each row of the CSV file
					$is_header = 1;
					$i = 1;
					while (($data = fgetcsv($handle, 40000, ",")) !== FALSE) {
						if ($is_header == 0) {
							$bass_player = replace_string($data[1]);
							$title = replace_string($data[2]);
							$artist = replace_string($data[3]);
							$album = replace_string($data[4]);
							$apple_link = replace_string($data[5]);
							$spotify_link = replace_string($data[6]);
							$year = replace_string($data[7]);
							$drummer = replace_string($data[8]);
							$instruments = replace_string($data[9]);
							$type = replace_string($data[18]);
							$genre = replace_string($data[19]);
							$referance = replace_string($data[20]);

							if ($title) {

								$qry_get_id = "SELECT IFNULL((SELECT id FROM tbl_album WHERE REPLACE(album, \"'\", '')= '".string_fromat($album)."'),0) AS album_id,
									IFNULL((SELECT id FROM tbl_song_type WHERE REPLACE(song_type, \"'\", '') = '".string_fromat($type)."'),0) AS type_id,
									IFNULL((SELECT id FROM tbl_genre WHERE REPLACE(genre, \"'\", '') = '".string_fromat($genre)."'),0) AS genre_id,
									IFNULL((SELECT id FROM tbl_artist WHERE REPLACE(artist, \"'\", '') = '".string_fromat($artist)."'),0) AS artist_id";
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
									"type"=>$type,
									"type_id"=>$type_id,
									"genre"=>$genre,
									"genre_id"=>$genre_id,
									"referance"=>$referance,
									"entry_by" => $login_user_id,
									"entry_at" => date('Y-m-d H:i:s')
								);
								$db->insert("tbl_songs", $data);
							}
							$i++;
						}
						$is_header = 0;
					}
					fclose($handle);
					$outputjson['success'] = 1;
					$outputjson['message'] = 'Data inserted Successfully.';
				} else {
					$outputjson['message'] = "File not open!";
				}
			} else {
				$outputjson['message'] = "File not Found!";
			}
		}
	} else {
		$outputjson['message'] = "Please select file to upload!";
	}
}

function replace_string($string){
	// $string = str_replace("'","\'",$string);
	// $string = str_replace('"','\"',$string);
	// $string = str_replace('“','\“',$string);
	return $string;
}

function string_fromat($string){
	$string = str_replace("'","",$string);
	// $string = str_replace('"','\"',$string);
	// $string = str_replace('“','\“',$string);
	return $string;
}