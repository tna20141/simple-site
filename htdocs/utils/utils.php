<?php

require_once($_SERVER["DOCUMENT_ROOT"] . "/config/common_macros.php");

function isLogin() {
	session_start();
	if (isset($_SESSION["user"]) && $_SESSION["user"] != "") {
		if (isset($_SESSION["last_access"]) && (time() - $_SESSION["last_access"]) < SESSION_TIMEOUT) {
			return true;
		}
	}
	return false;
}

function checkLogin() {
	if (isLogin()) {
		$_SESSION["last_access"] = time();
	}
	else {
		$_SESSION["user"] = "";
		session_destroy();
		header("Location: /utils/login.php");
	}
}

function commonLinks() {
?>
	<br />
	<br />
	<div>
		<a href="/index.php">Main page</a>
		<a href="/utils/logout.php">Log out</a>
	</div>
<?php
}
?>	