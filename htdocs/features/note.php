<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/config/common_macros.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/utils/utils.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/utils/db.php");

checkLogin();

if (isset($_REQUEST["ajax_request"]) && $_REQUEST["ajax_request"] !== "") {
	if ($_REQUEST["ajax_request"] == "add") {
		$last_id = add_note_to_db($_POST["note"]);
		$ajax_data = array(
			"stt" => "ok",
			"note" => $_POST["note"],
			"note_id" => $last_id
		);
		echo json_encode($ajax_data);
	}
	else if ($_REQUEST["ajax_request"] == "delete") {
		delete_note($_GET["note_id"]);
		$ajax_data = array(
			"stt" => "ok",
			"note_id" => $_GET["note_id"]
		);
		echo json_encode($ajax_data);
	}
	else if ($_REQUEST["ajax_request"] == "edit") {
		edit_note($_POST["note_id"], $_POST["note"]);
		$ajax_data = array(
			"stt" => "ok",
			"note_id" => $_POST["note_id"],
			"note" => $_POST["note"]
		);
		echo json_encode($ajax_data);
	}
	else {
		$ajax_data = array(
			"stt" => "invalid"
		);
		echo json_encode($ajax_data);
	}
}
else {
	$notes = get_notes_from_db();
	display($notes);
	commonLinks();
}

function get_notes_from_db() {
	$conn = db_connect();
	$sql = "SELECT * FROM " . TBL_NOTES . " ORDER BY created_time ASC";
	return $conn->query($sql);
}

function display($notes) {
?>
<div id="view_note_panel">
<?php
	foreach ($notes as $note) {
?>
	<div>
		<div style="border: 1px solid;">
			<p style="word-wrap: break-word; white-space: pre-line;"><?php echo $note["content"] ?></p>
		</div>
		<input type="hidden" value="<?php echo $note["id"] ?>" />
		<input type="button" value="Delete" onclick="ajax_delete(this)" />
		<input type="button" value="Edit" onclick="ajax_edit(this)" />
		</br>
	</div>
<?php
	}
?>
</div>
<div id="add_note_panel">
	<div style="border: 1px solid;">
		<textarea id="note" name="note" rows="8" cols="160"></textarea>
	</div>
	<input type="button" value="Add" onclick="ajax_add(this)" />
</div>
<?php
	script();
}

function add_note_to_db($content) {
	$conn = db_connect();
	$date = date("Y-m-d H:i:s");
	$sql = "INSERT INTO " . TBL_NOTES . " (content, created_time) VALUES (:content, :date)";
	$st = $conn->prepare($sql);
	$st->execute(array(':content' => $content, ':date' => $date));
	$last_id = $conn->lastInsertId();
	return $last_id;
}

function delete_note($note_id) {
	$conn = db_connect();
	$sql = "DELETE FROM " . TBL_NOTES . " WHERE id = :id";
	$st = $conn->prepare($sql);
	$st->execute(array(':id' => $note_id));
}

function edit_note($note_id, $content) {
	$conn = db_connect();
	$sql = "UPDATE " . TBL_NOTES . " SET content = :content WHERE id = :id";
	$st = $conn->prepare($sql);
	$st->execute(array(':content' => $content, ':id' => $note_id));
}

function script() {
?>
<script type="text/javascript" src="/javascript/jquery-1.9.1.min.js"></script>
<script type="text/javascript">

	function ajax_delete(obj) {
		var id = $(obj).prev().val();

		if (navigator.userAgent.indexOf('Chrome') == -1) {
			if (!confirm("Are you sure?")) {
				return;
			}
		}
		$.ajax({
			type: "GET",
			url: "note.php",
			data: {
				ajax_request: "delete",
				note_id: id
			},
			success: function(data) {
				var new_data = $.parseJSON(data);
				var status = new_data.stt;
				if (status == "ok") {
					$(obj).parent().remove();
				}
				else {
					alert("Request failed!");
				}
			}
		});
	}

	function ajax_add(obj) {
		var content = $(obj).parent().find('textarea').val();
		$.ajax({
			type: "POST",
			url: "note.php",
			data: {
				ajax_request: "add",
				note: content
			},
			success: function(data) {
				var new_data = $.parseJSON(data);
				var status = new_data.stt;
				var note = new_data.note;
				var id = new_data.note_id;
				if (status == "ok") {
					var note_panel_string = '<div>' +
							'<div style="border: 1px solid;">' +
								'<p style="word-wrap: break-word; white-space: pre-line;">' + note + '</p>' +
							'</div>' +
							'<input type="hidden" value="' + id + '" />' +
							'<input type="button" value="Delete" onclick="ajax_delete(this)" />' +
							'<input type="button" value="Edit" onclick="ajax_edit(this)" />' +
							'</br>' +
						'</div>';
					$(note_panel_string).appendTo("#view_note_panel");
				}
				else {
					alert("Request failed!");
				}
			}
		});
	}

	function cancel(obj) {
		var a = $(obj).parent().prev().show();
		$(obj).parent().remove();
	}

	function ajax_save(obj) {
		var content = $(obj).parent().find('textarea').val();
		var id = $(obj).parent().prev().children('input').first().val();
		$.ajax({
			type: "POST",
			url: "note.php",
			data: {
				ajax_request: "edit",
				note_id: id,
				note: content
			},
			success: function(data) {
				var new_data = $.parseJSON(data);
				var status = new_data.stt;
				var note = new_data.note;
				var id = new_data.note_id;
				if (status == "ok") {
					var note_panel_string = '<div>' +
							'<div style="border: 1px solid;">' +
								'<p style="word-wrap: break-word; white-space: pre-line;">' + note + '</p>' +
							'</div>' +
							'<input type="hidden" value="' + id + '" />' +
							'<input type="button" value="Delete" onclick="ajax_delete(this)" />' +
							'<input type="button" value="Edit" onclick="ajax_edit(this)" />' +
							'</br>' +
						'</div>';
					$(obj).parent().prev().replaceWith(note_panel_string);
				}
				else {
					alert("Request failed!");
				}
				$(obj).parent().prev().show();
				$(obj).parent().remove();
			}
		});
	}

	function ajax_edit(obj) {
		var edit_element = $(obj).parent();
		var content = edit_element.find('p').html();
		var editDiv = '<div>' +
				'<div style="border: 1px solid;">' +
					'<textarea id="note" name="note" rows="8" cols="160">' +
						content +
					'</textarea>' +
				'</div>' +
				'<input type="button" value="Save" onclick="ajax_save(this)" />' +
				'<input type="button" value="Cancel" onclick="cancel(this)" />' +
			'</div>'
		edit_element.hide();
		edit_element.after(editDiv);
	}

</script>
<?php
}

?>