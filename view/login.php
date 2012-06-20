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
                        $("#msgbox").addClass("red").html("* 请输入用户登录邮箱");
                        return;
                    }
                    if($.trim($("#pwd").val()) == ""){
                        $("#msgbox").addClass("red").html("* 请输入登录密码");
                        return;
                    }
                
                    $("#msgbox").removeClass("red").html("正在验证，请稍候…");
                    
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
                                case 401:
                                    $("#msgbox").addClass("red").html("* 用户邮箱或密码错误");
                                    break;
                                case 200:
                                    $("#msgbox").html("登录成功，正在跳转…");
                                    break;
                            }
                        },
                        "json"
                    );
                });
                
                $("#activate").click(function(){
                    $("#a_msgbox").removeClass("red").html("");
                    if($.trim($("#a_email").val()) == ""){
                        $("#a_msgbox").addClass("red").html("* 请输入用户激活邮箱");
                        return;
                    }
                    
                    $("#a_msgbox").removeClass("red").html("正在发送激活邮件，请稍候…");
                    
                    $.post(
                        "../controller/login.php",
                        {
                            "type": "activate",
                            "email": $("#a_email").val()
                        },
                        function(d){
                            switch(d.code){
                                case 401:
                                    $("#a_msgbox").addClass("red").html("* 用户身份验证失败");
                                    break;
                                case 403:
                                    $("#a_msgbox").addClass("red").html("* 该用户不处于等待激活状态");
                                    break;
                                case 200:
                                    $("#a_msgbox").html("激活邮件已发送，请注意查收");
                                    break;
                            }
                        },
                        "json"
                    );
                });
            });
        </script>
        <title>登录 -- Omar Hub</title>
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
            <div><h1>用户登录</h1></div>
            <div class="wrap">
                <p>邮箱: <input type="text" id="email" /></p>
                <p>密码: <input type="password" id="pwd" /></p>
                <p><a href="#" id="login">登录</a> <span id="msgbox"></span></p>
            </div>
            <div>
                <h2>第一次登录？</h2>
                <p>首次登录请先激活您的账户</p>
                <p>邮箱: <input type="text" id="a_email" /></p>
                <p><a href="#" id="activate">激活</a> <span id="a_msgbox"></span></p>
            </div>
        </div>
    </body>
</html>
