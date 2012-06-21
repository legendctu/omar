<?php
	require_once("view_helper.php");
	require_once("../controller/api_helper.php");
	
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
	</div>
	<div id="r_side" class="fr w250">
	b
	</div>
</div>
</div>

<?php include("footer.php"); ?>