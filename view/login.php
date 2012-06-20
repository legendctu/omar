<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link type="text/css" rel="stylesheet" href="../css/base.css" />
        <link type="text/css" rel="stylesheet" href="../css/page.css" />
        <script src="../script/jquery-1.7.2.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function(){
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
                
                    $("#msgbox").removeClass("red").html("Logging in, please wait…");
                    
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
                                    $("#msgbox").html("Logged in, please wait…");
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
                    
                    $("#a_msgbox").removeClass("red").html("Sending an activation email…");
                    
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
        <title>Log In -- Omar Hub</title>
    </head>
    <body>
        <div class="wrap">
            <p>Welcome</p>
            <p>logo</p>
        </div>
        <div>
            <div>navi</div>
        </div>
        
        <div class="wrap">
            <div><h1>Login</h1></div>
            <div class="wrap">
                <p>Email: <input type="text" id="email" /></p>
                <p>Password: <input type="password" id="pwd" /></p>
                <p><a href="#" id="login">Login</a> <span id="msgbox"></span></p>
            </div>
            <div>
                <h2>First time to use?</h2>
                <p>If it's your first time login, please activate your account first!</p>
                <p>Email: <input type="text" id="a_email" /></p>
                <p><a href="#" id="activate">Activate</a> <span id="a_msgbox"></span></p>
            </div>
        </div>
    </body>
</html>
