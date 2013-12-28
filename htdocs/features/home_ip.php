<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/config/common_macros.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/utils/utils.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/utils/db.php");
 
checkLogin();

$ip = "118.71.3.12";

echo "$ip";

commonLinks();

?>