var user_id = $("#user_id").val(),
    page_num = 0,
    sort = "time",
    count = 10;

$(function(){
    get_activities();

    $("#show_more_activities").click(function(){
        page_num++;
        get_activities();
    });
});

function get_activities(){
    $("#show_more_activities").hide();
    $("#loading_activities").show();
    $.post(
        "../controller/profile.php",
        {
            "type": "get_activity",
            "sort": sort,
            "count": count,
            "page": page_num,
            "user_id": user_id
        },
        function(d){
            console.log(d);
            $("#loading_activities").hide();
            $("#show_more_activities").show();
        },
        "json"
    );
}