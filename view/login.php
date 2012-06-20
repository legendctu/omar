<?php
	if(isset($_COOKIE["OH_user"])){
		setcookie("OH_user", "", time()-3600, '/');
		setcookie("OH_pwd", "", time()-3600, '/');
	}
?>
<?php require_once("view_helper.php"); ?>
<?php
	render_header('People & Activity', false);
?>

<link style="text/css" href="../css/login.css" rel="stylesheet"/>

<div class="bg-blue">
	<div class="mt wrap">
		<h2 class="font24 white pl20">USER LOGIN</h2>
		<b></b>
	</div>
</div>

<div class="wrap bg-white" id="entry">
	<div class="fl form">
		<table>
			<tr>
			<td class="td1 font18 arial b">Email:</td>
			<td class="td2"><input type="text" id="email" class="text"></td>
			<td></td>
		</tr>
		<tr>
			<td class="td1 font18 arial b">Password:</td>
			<td class="td2"><input type="password" id="pwd" class="text"></td>
			<td class="td3 underline font14 blue"><a>forget password?</a></td>
		</tr>
		</table>
		<input type="submit" id="login" value="login" class="login r14 font24 arial b">
		<span id="msgbox"></span>
	</div>
	
	<div class="fl guide">
		<h3 class="arial font24">First time to use?</h3>
		<p class="verdana font18">If it's your first time login, please activate your account first!</p>
		
		<span class="mail-span mt20 font18 arial b">Email:</span><input type="text" id="a_email" class="text mt20">
		<input type="submit" id="activate" value="first" class="first-button r14 arial font24 b">
		<span id="a_msgbox"></span>
	</div>
	<div class="clear"></div>
</div>
	
<script type="text/javascript">
	$(document).ready(function(){
        $("#email, #pwd").keyup(function(e){
            if(e.keyCode == 13)
                $("#login").click();
        });
        $("#a_email").keyup(function(e){
            if(e.keyCode == 13)
                $("#activate").click();
        });
	
		$("#login").click(function(){
			$("#msgbox").removeClass("red").html("");
			if($.trim($("#email").val()) == ""){
				$("#msgbox").addClass("red").html("* Please enter your email");
				return;
			}
			if($.trim($("#pwd").val()) == ""){
				$("#msgbox").addClass("red").html("* Please enter your password");
				return;
			}
		
			$("#msgbox").removeClass("red").html("Logging in, please wait...");
			
			$.post(
				"../controller/login.php",
				{
					"type": "login",
					"email": $("#email").val(),
					"pwd": $("#pwd").val()
				},
				function(d){
					console.log(d);
					switch(d.code){
						case 0:
							$("#msgbox").addClass("red").html("* The connection is interrupted, please try again");
							break;
						case 401:
							$("#msgbox").addClass("red").html("* Your email and password don't match");
							break;
						case 200:
							$("#msgbox").html("Logged in, please wait...");
							window.location = "people_activity.php";
							break;
					}
				},
				"json"
			);
		});
		
		$("#activate").click(function(){
			$("#a_msgbox").removeClass("red").html("");
			if($.trim($("#a_email").val()) == ""){
				$("#a_msgbox").addClass("red").html("* Please enter your email to activate it");
				return;
			}
			
			$("#a_msgbox").removeClass("red").html("Sending an activation email...");
			
			$.post(
				"../controller/login.php",
				{
					"type": "activate",
					"email": $("#a_email").val()
				},
				function(d){
					switch(d.code){
						case 0:
							$("#a_msgbox").addClass("red").html("* The connection is interrupted, please try again");
							break;
                        case 400:
                            $("#a_msgbox").addClass("red").html("* This account doesn't exist");
                            break;
						case 401:
							$("#a_msgbox").addClass("red").html("* Permission denied");
							break;
						case 403:
							$("#a_msgbox").addClass("red").html("* This account has been activated");
							break;
						case 200:
							$("#a_msgbox").html("The activation email has been sent");
							break;
					}
				},
				"json"
			);
		});
	});
</script>

<?php include("footer.php"); ?>