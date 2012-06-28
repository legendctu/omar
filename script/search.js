$("#search > img").click(function(){
    var val = $("#search input").val(),
        url = "../view/search_result.php?query=" + val;
    window.location.href=url;
});