<?php
	if(isset($_COOKIE["OH_user"])){
		setcookie("OH_user", "", time()-3600, '/');
		setcookie("OH_pwd", "", time()-3600, '/');
	}

	require_once("view_helper.php");

	render_header('Activate Your Account', false);
?>
<div class="navi-bg">
	<div class="mt wrap">
		<h2 class="font24 white pl20 shadow">ACCOUNT ACTIVATION</h2>
	</div>
</div>
<div id="content_wrap" class="wrap bg-white center">
<?php
	$email = isset($_GET["email"]) ? $_GET["email"] : "";
	$vcode = isset($_GET["verification_code"]) ? $_GET["verification_code"] : "";
	$data = array(
		"email" => $email,
		"verification_code" => $vcode
	);
	require_once("../controller/api_helper.php");
	$res = callapi("account/check_email_verification_code", "GET", $data);
	
	switch($res["code"]){
		case 0:
			echo '<div class="wrap"><h2>The connection is interrupted. Please refresh the page to try again.</h2></div>';
			break;
		case 401:
		case 403:
			?>
			<div class="wrap">
				<h1>Fail to activate your account</h1>
				<p><a href="login.html">Please put in your email again to receive the activation email.</a></p>
			</div>
			<?php
			break;
		case 200:
			echo "<script type='text/javascript'>window.location = 'set_pwd.php?email={$email}&verification_code={$vcode}';</script>";
			break;
	}
?>
</div>
<?php include("footer.php"); ?>