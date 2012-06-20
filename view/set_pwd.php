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
                    $("#msgbox").removeClass("red").html("正在保存，请稍候…");
                    if($("#pwd").val() != $("#pwd2").val()){
                        $("#msgbox").addClass("red").html("* 两次密码输入不一致");
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
                                    $("#msgbox").addClass("red").html("* 网络中断，请重试");
                                    break;
                                case 200:
                                    $("#msgbox").html("设置成功，请登录。3秒后跳转…");
                                    setTimeout('window.location="login.html"', 3000);
                                    break;
                                case 401:
                                    $("#msgbox").addClass("red").html("* 该用户已激活");
                                    break;
                                case 403:
                                    $("#msgbox").addClass("red").html("* 验证码和邮箱不匹配");
                                    break;
                            }
                        },
                        "json"
                    );
                });
            });
        </script>
        <title>激活校验 -- Omar Hub</title>
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
            <h1>设置您的密码</h1>
            <p>请输入密码: <input type="password" id="pwd" /></p>
            <p>请再次输入密码: <input type="password" id="pwd2" /></p>
            <p><a href="#" id="save">确定</a> <span id="msgbox"></span></p>
        </div>
        
    </body>
</html>
