<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/utils/utils.php");
checkLogin();
?>

<html>
<head>
<title>TNA's free hosting website</title>
<script src="javascript/jquery-1.9.1.js" type="text/javascript"></script>
</head>
<body>
<h1>
Choose an option:
</h1>
<p>
<a href="features/home_ip.php">Display home's public IP address</a> <br />
<a href="features/other_stuff.php">Other stuff</a> <br />
<a href="features/note.php">Take note</a> <br />
<a href="features/test.php">Open test page</a> <br />
</p>
</body>
</html>

<?php
commonLinks();
?>