<?php

require_once($_SERVER["DOCUMENT_ROOT"] . "/utils/utils.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/config/common_macros.php");

checkLogin();

?>

<div id="md5_panel" style="border: 1px solid;">
	<label for="md5_input">MD5 hash</label>
	<input type="text" id="md5_input" value="" />
	<div style="clear: both;">
		<input type="button" id="md5_submit" value="Submit" onclick='my_md5("md5_input", "md5_output")' />
	</div>
	<div style="clear: both;" id="md5_output"></div>
</div>
<br />


<script type="text/javascript" src="/javascript/md5hash.js"></script>
<script type="text/javascript" src="/javascript/jquery-1.9.1.min.js"></script>

<script type="text/javascript">

function my_md5(input_id, output_id) {
	var output_label = document.createElement("label");
	output_label.setAttribute("for", "md5_result");
	output_label.innerHTML = "Result: ";

	var output_result = document.createElement("span");
	output_result.innerHTML = hex_md5(str_to_ent($("#"+input_id).val()));

	$("#"+output_id).empty();
	$("#"+output_id).append(output_label, output_result);
}

</script>
<br />

<?php
commonLinks();

?>