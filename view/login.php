<?php
	if(isset($_COOKIE["OH_user"]) || isset($_COOKIE["OH_pwd"]) || isset($_COOKIE["OH_id"])){
		setcookie("OH_user", "", time()-3600, '/');
		setcookie("OH_pwd", "", time()-3600, '/');
		setcookie("OH_id", "", time()-3600, '/');
	}
?>
<?php require_once("view_helper.php"); ?>
<?php
	render_header('People & Activity', false);
?>

<link style="text/css" href="../css/login.css" rel="stylesheet"/>

<div class="bg-blue">
	<div class="mt wrap">
		<h2 class="font24 white pl20 shadow">USER LOGIN</h2>
	</div>
</div>

<div class="wrap bg-white box-shadow" id="entry">
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
		<p class="mt15"><a id="login" class="login r14 font24 arial b shadow">Login</a><span id="msgbox"></span></p>
		<!-- <input type="submit" id="login" value="Login" class="login r14 font24 arial b"> -->
	</div>
	
	<div class="fl guide">
		<h3 class="arial font24">First time to use?</h3>
		<p class="verdana font18">If it's your first time login, please activate your account first!</p>
		
		<span class="mail-span mt20 font18 arial b">Email:</span><input type="text" id="a_email" class="text mt20">
		<p class="mt15"><a id="activate" class="first-button r14 arial font24 b">Activate</a></p>
		<!-- <input type="submit" id="activate" value="First" class="first-button r14 arial font24 b"> -->
		<p id="a_msgbox"></p>
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
							$("#a_msgbox").addClass("red").html("* This account has been activated");
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