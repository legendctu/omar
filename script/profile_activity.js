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
            for(var i in d){
                $("#activities_block").append(d[i]);
            }
            $("a[name='watch_btn'], a[name='follow_btn']").each(function(){
                $(this).unbind("click");
                var pp = $(this);
                $(this).bind("click", { t: pp }, watch_btn_click);
            });

            $("#loading_activities").hide();
            $("#show_more_activities").show();
            
        },
        "json"
    );
}

function watch_btn_click(e){
    var that = e.data.t;
    var type = that.attr("action"),
        id = type == "follow" || type == "unfollow" ? that.attr("uid") : that.attr("iid");
    that.unbind("click");
    $.get("../controller/follow.php", 
        {
            "id": id,
            "type": type
        },
        function(d) {
            that.bind("click", { t: that}, watch_btn_click);
            switch(type){
                case "watch":
                    that.attr("action", "unwatch");
                    that.html('unfollow');
                    break;
                case "unwatch":
                    that.attr("action", "watch");
                    that.html('follow');
                    break;
                case "follow":
                    that.attr("action", "unfollow");
                    that.html('unfollow');
                    break;
                case "unfollow":
                    that.attr("action", "follow");
                    that.html('follow');
                    break;
            }
        },
        "json"
    );
}