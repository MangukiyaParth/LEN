<?php

if (session_status() == PHP_SESSION_NONE || !isset($_SESSION)) {
    @session_start();
}

error_reporting(0);
error_reporting(E_ALL);

date_default_timezone_set('Asia/Kolkata');
define('LAST_UPDATE_DATE_FOR_FILE', '2023-01-25');
define('ThrottleExceededErrorCode', '3001');

// server credentials file
require_once(__DIR__ . "/../config/MANAGE_CONFIG.php");

define("EXTEND_BUCKET", (IS_DEVELOPMENT) ? '0000_local/' : '');

// for omr connection
include_once(__DIR__ ."/_idiorm.php");

ORM::configure(array(
    'connection_string' => 'mysql:host=' . db_host . ';dbname=' . db_name . ';charset=utf8;',
    'username' => db_user,
    'password' => db_pass
));

ORM::configure('logging', true);
ORM::configure('caching', false);
ORM::configure('return_result_sets', true); // returns result sets

// // override the primary column if its not "id"
ORM::configure('id_column_overrides', array(
    'tbl_translation_hash' => 'hash_id',
    'tbl_translation_locale' => 'id',
));

define("UPLOAD", "upload/");

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Content-Range, Content-Disposition");
header('Access-Control-Allow-Methods: GET, HEAD, OPTIONS, POST, PUT, DELETE');

/*
DEBUG_MODE = 0  // Do not debug
DEBUG_MODE = 1  // Append query only
DEBUG_MODE = 2  // Append query and output into JSON
 */
define("DEBUG_MODE", "0");

/*
LOG_MODE = 0  // Do not log
LOG_MODE = 1  // Log only request
LOG_MODE = 2  // Log request and response
LOG_MODE = 3  // Log only query
LOG_MODE = 4  // Log query & result to log file
 */
define("LOG_MODE", "1");

define("PANEL_CONSTANT", "panel");
// Default: false,  Set to true when releasing website changes so no one uses it.
define("WEBSITE_UNDER_MAINTENANCE", false);
define("PHPFASTCACHE_EXPIRE_SEC", 30 * 24 * 60 * 60); // 30 days
define("COMPANY_LOGO_URL", ADMIN_URL . 'assets/images/logo.png');
