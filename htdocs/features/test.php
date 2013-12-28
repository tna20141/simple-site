<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/utils/utils.php");
checkLogin();
?>

<h2>This page is used for testing!</h2>
<script type="text/javascript" src="/javascript/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="/javascript/md5hash.js"></script>

<?php

//test content starts here
?>

<input type="text" id="text_id" value="" />
<input type="button" id="text_button" value="Click" onclick="test_trim()" />

<script type="text/javascript">
function test_trim() {
	alert("trim: "+"|"+trim($("#text_id").val())+"|");
	alert("no trim: "+"|"+$("#text_id").val()+"|");
}
</script>

<p>This line is the last line of the page's content</p>

<?php
//test content ends here

?>

<?php
commonLinks();
?>