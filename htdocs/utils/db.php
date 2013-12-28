<?php

require_once($_SERVER["DOCUMENT_ROOT"] . "/config/common_macros.php");

function db_connect() {
	try {
		$conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	catch (PDOException $e) {
		echo "Connection failed: " . $e->getMessage();
	}
	return $conn;
}

?>