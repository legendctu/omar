<?php
	require_once("view_helper.php");
	render_header('Create Account');
	render_nav('');
?>
        <script type="text/javascript">
            $(document).ready(function(){
                $("#create").click(function(){
                    $("#msgbox").removeClass("red").html("");
                    if($.trim($("#email").val()) == ""){
                        $("#msgbox").addClass("red").html("* Please enter your E-mail address");
                        return;
                    }
                    if($.trim($("#firstname").val()) == ""){
                        $("#msgbox").addClass("red").html("* Please enter your firstname");
                        return;
                    }
                    if($.trim($("#lastname").val()) == ""){
                        $("#msgbox").addClass("red").html("* Please enter your lastname");
                        return;
                    }
                
                    $("#msgbox").removeClass("red").html("Processing, please wait…");
                    
                    $.post(
                        "../controller/create_account.php",
                        {
                            email: $("#email").val(),
                            firstname: $("#firstname").val(),
                            lastname: $("#lastname").val(),
                            role: $("input:radio[name='role'][checked='checked']").val()
                        },
                        function(d){
                            switch(d.code){
                                case 0:
                                    $("#msgbox").addClass("red").html("* The connection is interrupted. Please try again");
                                    break;
                                case 409:
                                    $("#msgbox").addClass("red").html("* This email has been registered");
                                    break;
                                case 401:
                                    $("#msgbox").addClass("red").html("* Permission denied");
                                    break;
                                case 200:
                                    $("#msgbox").html("Created successfully");
                                    break;
                            }
                        },
                        "json"
                    );
                });
            });
        </script>

        
        
        <div id="create_body" class="wrap mt20">
            <div class="ml300"><h1>Create An Account</h1></div>
            <div class="ml300 mt10">
                <p class="mt6 fl w80 mr15 right">E-mail: </p>
                <p class="mt10"><input type="text" id="email" /></p>
                <p class="mt16 fl w80 mr15 right clear">Firstname: </p>
                <p class="mt10"><input type="text" id="lastname" /></p>
                <p class="mt16 fl w80 mr15 right clear">Lastname: </p>
                <p class="mt10"><input type="text" id="firstname" /></p>
                <p class="mt10 fl w80 mr15 right clear">Role: </p>
                <p class="mt10"><input type="radio" name="role" value="admin" id="admin"><label for="admin">Admin</label> <input type="radio" name="role" value="fellow" id="fellow" checked="checked"><label for="fellow">Fellow</label></p>
                <p class="mt10 ml80"><a id="create" class="button-bg white r14 arial font20 b">Create</a> <span id="msgbox"></span></p>
            </div>
        </div>
        
<?php include("footer.php");?>
<script type="text/javascript">
    var cbody = $("#create_body").offset();
    var min_h = cbody.top + $("#create_body").height() + $("#footer").height();
    if($("body").height() > min_h){
        $("#footer").css({position: "absolute", bottom: "0", width: "100%"});
    }
</script>
