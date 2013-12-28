<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/config/common_macros.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/utils/utils.php");

checkLogin();

if (isset($_POST["upload"]) && $_POST["upload"] == "Upload") {
	processUpload();
}
else if (isset($_GET["delete"]) && $_GET["delete"] != "") {
	processDelete();
}

displayPage();
commonLinks();

function displayPage() {
	$handle = opendir(UPLOAD_DIR);
?>
<div id="dir_panel">
	<p>Upload folder:</p>
<?php
	while ($file = readdir($handle)) {
		if ($file != "." && $file != "..") {
?>
	<a href="<?php echo "/upload/" . $file ?>"><?php echo $file ?></a>
	<a href="<?php echo "upload.php?delete=" . $file ?>">Delete</a>
	<br />
<?php
		}
	}
?>
<br />
<div id="upload_panel">
	<form action="upload.php" method="post" enctype="multipart/form-data">
		<label for="upload_file">Choose a file</label>
		<input type="file" name="upload_file" id="upload_file" value="" />
		<div style="clear: both;">
			<input type="submit" name="upload" value="Upload" />
		</div>
	</form>
</div>
<?php
	closedir($handle);
}

function processUpload() {
	if (isset($_FILES["upload_file"]) && $_FILES["upload_file"]["error"] == UPLOAD_ERR_OK) {
		if (!move_uploaded_file(
			$_FILES["upload_file"]["tmp_name"],
			UPLOAD_DIR . basename($_FILES["upload_file"]["name"])
		)) {
			echo "<p>Error: problem uploading file</p>";
			exit;
		}
	}
	else {
		switch ($_FILES["upload_file"]["error"]) {
			case UPLOAD_ERR_INI_SIZE:
			case UPLOAD_ERR_FORM_SIZE:
				$message = "file is too big";
				break;
			case UPLOAD_ERR_NO_FILE:
				$message = "no file was uploaded";
				break;
			default:
				$message = "unknown error";
		}
		echo "<p>Error: " . $message . "</p>";
		exit;
	}
}

function processDelete() {
	$filename = $_GET["delete"];
	unlink(UPLOAD_DIR . $filename);
}

?>