<?php

require_once($_SERVER["DOCUMENT_ROOT"] . "/config/common_macros.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/utils/utils.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/utils/db.php");

if (isLogin()) {
	header("Location: /index.php");
}
else {
	session_destroy();
}

if (isset($_POST["action"]) and $_POST["action"] == "login") {
	processForm();
}
else {
	displayForm(false, "");
}

function displayForm($error, $message) {
	if ($error) {
		echo "<p>Error: $message. Please try again.</p>";
	}
?>
	<form action="login.php" method="post" onsubmit='my_md5("password")'>
		<div>
			<input type="hidden" name="action" id="action" value="login" />
			<label for="username">Username</label>
			<input type="text" name="username" id="username" />
			<label for="password">Password</label>
			<input type="password" name="password" id="password" />
			<div>
				<input type="submit" name="submitButton" id="submitButton" value="Login" />
			</div>
		</div>
	</form>
	<div>
		<a href="../guest.php">Go to guest section</a>
	</div>
	<script type="text/javascript" src="/javascript/md5hash.js"></script>
	<script type="text/javascript">
		function my_md5(id) {
			var Elem = document.getElementById(id);
			Elem.value = hex_md5(str_to_ent(trim(Elem.value)));
		}
	</script>
<?php
}

function processForm() {
	$username = (isset($_POST["username"]) ? $_POST["username"] : "");
	$password = (isset($_POST["password"]) ? $_POST["password"] : "");

	if (!validate($username, $password)) {
		displayForm(true, "Invalid username or password");
	}
	else {
		if (!authenticate($username, $password)) {
			displayForm(true, "Incorrect username or password");
		}
		else {
			session_start();
			$_SESSION["user"] = $username;
			$_SESSION["last_access"] = time();
			session_write_close();
			header("Location: /index.php");
		}
	}
}

function validate(&$username, &$password) {
	$username = preg_replace("/[^\-\_a-zA-Z0-9]/", "", $username);
	if ($username == "")
		return false;
	if ($password == EMPTY_HASH)
		return false;
	return true;
}

function authenticate($username, $password) {
	$conn = db_connect();
	$sql = "select count(*) from " . TBL_USERS . " where username = :username and password = :password";
	$st = $conn->prepare($sql);
	$st->execute(array(':username' => $username, ':password' => $password));
	$data = $st->fetch(PDO::FETCH_NUM);
	$count = $data[0];

	if ($count == 1)
		return true;
	else
		return false;
}
?>
	