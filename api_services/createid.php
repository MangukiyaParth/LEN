<?php

	list($microseconds, $seconds) = explode(" ", microtime());
	$timestamp = sprintf('%d%06d', $seconds, $microseconds * 1000000);

	// Generate a random part
	$randomPart = sprintf('%04x%04x%04x%04x%04x%04x%04x%04x',
		mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0x0fff) | 0x4000,
		mt_rand(0, 0x3fff) | 0x8000, mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
	);

	// Concatenate timestamp and random part to create a UUID
	$uuid = sprintf('%s-%s-%s-%s-%s',
		substr($timestamp, 0, 8), substr($timestamp, 8, 4),
		substr($timestamp, 12, 4), substr($randomPart, 0, 4),
		substr($randomPart, 4, 12)
	);

	echo $uuid;
?>