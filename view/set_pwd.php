<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link type="text/css" rel="stylesheet" href="../css/base.css" />
        <link type="text/css" rel="stylesheet" href="../css/page.css" />
        <script src="../script/jquery-1.7.2.min.js"></script>
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
                                    setTimeout('window.location="login.html"', 3000);
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
            });
        </script>
        <title>Activate Your Account -- Omar Hub</title>
    </head>
    <body>
        <div class="wrap">
            <p>Welcome</p>
            <p>logo</p>
        </div>
        <div>
            <div>navi</div>
        </div>
        
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
            <h1>Please set your password</h1>
            <p>Enter your password: <input type="password" id="pwd" /></p>
            <p>Enter it again: <input type="password" id="pwd2" /></p>
            <p><a href="#" id="save">Save</a> <span id="msgbox"></span></p>
        </div>
        
    </body>
</html>
