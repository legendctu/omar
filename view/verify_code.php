<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link type="text/css" rel="stylesheet" href="../css/base.css" />
        <link type="text/css" rel="stylesheet" href="../css/page.css" />
        <script src="../script/jquery-1.7.2.min.js"></script>
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
            require_once("../controller/api_helper.php");
            $res = callapi("account/check_email_verification_code", "GET", $data);
            
            switch($res["code"]){
                case 0:
                    echo '<div class="wrap"><h1>网络连接中断，请重试</h1></div>';
                    break;
                case 401:
                case 403:
                    ?>
                    <div class="wrap">
                        <h1>激活校验失败</h1>
                        <p><a href="login.html">请重新输入邮箱地址以接收激活邮件</a></p>
                    </div>
                    <?php
                    break;
                case 200:
                    echo "<script type='text/javascript'>window.location = 'set_pwd.php?email={$email}&verification_code={$vcode}';</script>";
                    break;
            }
        ?>
        
    </body>
</html>
