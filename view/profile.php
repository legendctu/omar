<?php
	require_once("view_helper.php");
	require_once("../controller/api_helper.php");

	$type = isset($_GET["type"]) ? $_GET["type"] : "activity";

	render_header('Profile');
	render_nav('profile');

	$ret = callapi("profile", "GET", array());
	//print_r($ret);
?>

<div id="content_wrap" class="wrap bg-white">
<div class="p20 overflow">
	<div id="l_side" class="fl w750">
		<div id="status" class="overflow m10 p10 border-b">
			<img class="avatar fl" src="../image/blank-avatar.gif" />
			<div class="fl ml20">
				<textarea type="text" id="status" rows="3" class="w600"></textarea><br />
				<a id="update" class="fr mt10 button-bg white r14 arial font18 b shadow">Submit</a>
			</div>
		</div>
		<p id="l_side_navi" class="pl20 font24 freshcolor">
            <span class="center mr15 b"><a href="<?= $type == "activity" ? "#" : "profile.php" ?>" class="<?= $type == "activity" ? "carmine" : "light-red" ?>">Activity</a></span>
            <span class="center">/</span>
            <span class="center ml15 mr15 b"><a href="<?= $type == "information" ? "#" : "profile.php?type=information" ?>" class="<?= $type == "information" ? "carmine" : "light-red" ?>">Information</a></span>
            <span class="center">/</span>
            <span class="center ml15 mr15 b"><a href="<?= $type == "innovation" ? "#" : "profile.php?type=innovation" ?>" class="<?= $type == "innovation" ? "carmine" : "light-red" ?>">Innovation</a></span>
        </p>
	</div>
	<div id="r_side" class="fr w250">
	b
	</div>
</div>
</div>

<?php include("footer.php"); ?>