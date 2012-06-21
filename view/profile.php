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
		<div id="status" class="p20">
			<div class="avatar">
			</div>
			<div class="fl">
				<input type="text" id="status" class="text">
				<a id="update" class="r14 font24 arial b">Submit</a>
			</div>
		</div>
	</div>
	<div id="r_side" class="fr w250">
	b
	</div>
</div>
</div>

<?php include("footer.php"); ?>