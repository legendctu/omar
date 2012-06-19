$(document).ready(function(){
    $("#create").click(function(){
        $("#msgbox").removeClass("red").html("正在创建，请稍等…");
        
        $.post(
            "../controller/create_account.php",
            {
                email: $("#email").val(),
                firstname: $("#firstname").val(),
                lastname: $("#lastname").val(),
                role: $("input:radio[name='role'][checked='checked']").val()
            },
            function(d){
                console.log(d);
                $("#msgbox").html("");
            },
            "json"
        );

    });
    
});