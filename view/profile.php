<?php
	require_once("view_helper.php");
	require_once("../controller/api_helper.php");
	
	render_header('Profile');
	render_nav('profile');

	$ret = callapi("profile", "GET", array());
	print_r($ret);
?>

<?php include("footer.php"); ?>