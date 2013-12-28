<?php

//md5 hash of empty string
define("EMPTY_HASH", "d41d8cd98f00b204e9800998ecf8427e");

//database parameters
define("DB_DSN", "mysql:host=sql310.byethost11.com;dbname=b11_12179913_basic_page");
define("DB_USERNAME", "b11_12179913");
define("DB_PASSWORD", "password");
define("TBL_USERS", "users");
define("TBL_NOTES", "notes");

//session timeout
define("SESSION_TIMEOUT", 1800);

//directories
define("UPLOAD_DIR", $_SERVER["DOCUMENT_ROOT"] . "/upload/");

?>
