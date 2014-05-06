<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/utils/utils.php");
checkLogin();

$ip = file_get_contents($_SERVER["DOCUMENT_ROOT"] . "/config/home_ip.txt");

if ($ip !== false) echo $ip;

commonLinks();
?>