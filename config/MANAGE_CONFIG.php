<?php

// dynamic parameters
define("db_host", "localhost");
define("db_user", "root");
define("db_pass", "");
define("db_name", "db_len");

define("IS_DEVELOPMENT", false);
define("IS_PRODUCTION", (!IS_DEVELOPMENT));
if (IS_PRODUCTION) {
    define("API_URL", "http://" . $_SERVER['HTTP_HOST'] . "/api_services/");
    define("ADMIN_URL", "http://" . $_SERVER['HTTP_HOST'] . "/admin_panel/");
    define("MAIN_URL", "http://" . $_SERVER['HTTP_HOST'] . "/");
    define("ALLOW_EXTERNAL_SCRIPT", "1");
    define("ALLOW_MIXPANEL_SCRIPT", "1");
} else {
    define("API_URL", "http://" . $_SERVER['HTTP_HOST'] . "/product/HTML/LEN/api_services/");
    define("ADMIN_URL", "http://" . $_SERVER['HTTP_HOST'] . "/product/HTML/LEN/admin_panel/");
    define("MAIN_URL", "http://" . $_SERVER['HTTP_HOST'] . "/product/HTML/LEN/");
    define("ALLOW_EXTERNAL_SCRIPT", "0");
    define("ALLOW_MIXPANEL_SCRIPT", "0");
}
define("FIREBASE_KEY", "AIzaSyDi7s3q_Cfcx74uWGl4Or9msfxjG0ra178");
// dynamic end
