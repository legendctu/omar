<?php
	if(isset($_COOKIE["OH_user"])){
		setcookie("OH_user", "", time()-3600, '/');
		setcookie("OH_pwd", "", time()-3600, '/');
	}

	require_once("view_helper.php");

	render_header('Set Your Account Password', false);
?>
<div class="navi-bg">
	<div class="mt wrap">
		<h2 class="font24 white pl20 shadow">ACCOUNT PASSWORD</h2>
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
	?>
	<div class="wrap">
		<input type="hidden" id="email" value="<?php echo $email;?>" />
		<input type="hidden" id="vcode" value="<?php echo $vcode;?>" />
		<h1 class="p20">Please set your password</h1>
		<div class="ml300">
    		<p class="mt6 fl w140 mr15 right">Enter your password:</p>
    		<p class="mt10 left"><input type="password" id="pwd" /></p>
    		<p class="mt16 fl w140 mr15 right clear">Enter it again:</p>
    		<p class="mt10 left"><input type="password" id="pwd2" /></p>
    		<div class="p20 left ml90">
    			<a id="save" class="white font24 arial r14 button-bg b shadow">Save</a>
    			<span id="msgbox"></span>
    		</div>
        </div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$("#save").click(function(){
			$("#msgbox").removeClass("red").html("Processing, please wait…");
			if($("#pwd").val() == "" || $("#pwd2").val() == ""){
				$("#msgbox").addClass("red").html("* Please enter your password");
				return;
			}
			
			if($("#pwd").val() != $("#pwd2").val()){
				$("#msgbox").addClass("red").html("* These passwords don't match each other");
				return;
			}
			
			$.post(
				"../controller/set_pwd.php",
				{
					"email": $("#email").val(),
					"verification_code": $("#vcode").val(),
					"password": $("#pwd").val()
				},
				function(d){
					switch(d.code){
						case 0:
							$("#msgbox").addClass("red").html("* The connection is interrupted, please try again");
							break;
						case 200:
							$("#msgbox").html("Your password is set. Please login. Redirect in 3 seconds…");
							setTimeout('window.location="login.php"', 3000);
							break;
						case 401:
							$("#msgbox").addClass("red").html("* The account has been activated");
							break;
						case 403:
							$("#msgbox").addClass("red").html("* Your verification code and email don't match");
							break;
					}
				},
				"json"
			);
		});
		
		$("#pwd, #pwd2").keyup(function(e){
            if(e.keyCode == 13)
                $("#save").click();
		});
	});
</script>
<?php include("footer.php"); ?>