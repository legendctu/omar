<?php
	require_once("api_helper.php");

	if (isset($_POST["delete"])) {
		$id = isset($_POST["id"]) ? $_POST["id"] : "";
		$post_id = isset($_POST["post_id"]) ? $_POST["post_id"] : "";
		if (empty($id) || empty($post_id))
			echo 'delete_failed';
		else {
			$ret = callapi("items/".$post_id."/comments/".$id, "DELETE");
			if ($ret["code"] == 200)
				echo 'deleted';
			else
				echo 'delete_failed';
		}
	} else {
		$post_id = isset($_POST["post_id"]) ? $_POST["post_id"] : "";
		$text = isset($_POST["text"]) ? $_POST["text"] : "";
	
		if (empty($post_id))
			echo 'comment_failed';
		else if (empty($text))
			echo 'text_empty_error';
		else {
			$ret = callapi("items/".$post_id."/comments", "POST", array(
				"text" => $text
			));
			if ($ret["code"] == 200)
				echo 'comment_posted';
			else
				echo 'comment_failed';
		}
	}
?>