<?php require_once("../common.php"); ?>
<?php require_once("view_helper.php"); ?>
<?php
    $type = $_GET["type"];
    render_header('Create '.ucfirst($type));
	render_nav('create');
?>
<input type="hidden" id="create_type" value="<?php echo $type;?>" />
<link rel="stylesheet" type="text/css" href="../css/create.css" media="all" />

<div id="stylized" class="wrap box-shadow">
    <div class="stylized-border pl60">
        <h1 class="pink">Create 
        <?php
            switch($type) {
                case "offer":
                    echo "an Offer";
                    break;
                case "need":
                    echo "a Need";
                    break;
                case "event":
                    echo "an Event";
                    break;
            }
        ?></h1>
        <p>Create a new <?php echo $type;?> to publish</p>
        <div class="clear"></div>
    </div>
    
    <div>    
        <label>Title of <?php echo $type ?>
        <span class="small">Add the title</span>
        </label>
        <input type="text" name="title" id="title" />
        <div class="clear"></div>
    </div> 
    
    <div>
        <label>Description
        <span class="small">Describe your <?php echo $type ?></span>
        </label>
        <textarea type="text" name="description" id="description" rows="3"></textarea>
        <div class="clear"></div>
    </div>
    
<?php
if ($type == "event"){
    echo '
        <link rel="stylesheet" type="text/css" href="../css/base/jquery.ui.all.css" media="all" />
        <script type="text/javascript" src="../script/jquery.ui.core.js"></script>
        <script type="text/javascript" src="../script/jquery.ui.datepicker.js"></script>
        <script>
        $(function() {
            $( "#from" ).datepicker({
                defaultDate: "+1w",
                changeMonth: true,
                numberOfMonths: 1,
                onSelect: function( selectedDate ) {
                    $( "#to" ).datepicker( "option", "minDate", selectedDate );
                }
            });
            $( "#to" ).datepicker({
                defaultDate: "+1w",
                changeMonth: true,
                numberOfMonths: 1,
                onSelect: function( selectedDate ) {
                    $( "#from" ).datepicker( "option", "maxDate", selectedDate );
                }
            });
			$("#oneday").click(function(){
				if($(this).attr("checked")){
					$("#end-date").addClass("hidden");
				}else{
					$("#end-date").removeClass("hidden");
				}
			});
        });
        </script>
        ';
    
	echo '
        <div>
            <label>One day event?
            <span class="small">Is is an one-day event?</span>
            </label>
            <input id="oneday" type="checkbox"/>
            <div class="clear"></div>
        </div>
    ';

	
    echo '
        <div>
            <label>Start Date
            <span class="small">When the event starts.</span>
            </label>
            <input type="text" id="from">
            <div class="clear"></div>
        </div>
    ';
    
    echo '
        <div id="end-date">
            <label>End Date
            <span class="small">When the event ends.</span>
            </label>
            <input type="text" id="to">
            <div class="clear"></div>
        </div>
    ';
}
?>
    
    <div>
        <label>Fields of work
        <span class="small">Select the fields</span>
        </label>
        <select name="fieldsOfWork" id="fieldsOfWork" class="pl10">
            <option value="SF">SF</option>
            <option value="NEC">NEC</option>
        </select>
        <div class="clear"></div>
    </div>

    <div>
        <label>Locations of work
        <span class="small">Select the locations</span>
        </label>
        <select name="locationsOfWork" id="locationsOfWork" class="pl10">
            <option value="China">China</option>
            <option value="Japan">Japan</option>
        </select>
        <div class="clear"></div>
    </div>
    
    <div>
        <label>Target population
        <span class="small">Let it known to all</span>
        </label>
        <input type="text" name="targetPop" id="targetPop" />
        <div class="clear"></div>
    </div>
    
    <div class="ml300">
        <p><a id="create" class="button-bg white r14 arial font24 b">Save</a><span id="msgbox"></span></p>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>

<script type="text/javascript">
$(function(){
    $("#create").click(function(){
        var type = $("#create_type").val();
        var one_day = $("#oneday").attr("checked") ? true : false;

        $("#msgbox").removeClass("red").html("Processing, please wait…");

        if($.trim($("#title").val()) == ""){
            $("#msgbox").addClass("red").html("* Please enter your title");
            return;
        }
        if($.trim($("#description").val()) == ""){
            $("#msgbox").addClass("red").html("* Please enter your description");
            return;
        }
        if(type == "event" && $.trim($("#from").val()) == ""){
            $("#msgbox").addClass("red").html("* Please select a start date");
            return;
        }
        if(type == "event" && !one_day && $.trim($("#to").val()) == ""){
            $("#msgbox").addClass("red").html("* Please select a end date");
            return;
        }
        if($.trim($("#targetPop").val()) == ""){
            $("#msgbox").addClass("red").html("* Please enter your target population");
            return;
        }
        
        switch(type){
            case "offer":
                type = "offer";
                break;
            case "need":
                type = "needs";
                break;
            case "event":
                type = "event";
                break;
        }
        var data = {
            "category": type,
            "title": $.trim($("#title").val()),
            "description": $("#description").val(),
            "work_fields": $("#fieldsOfWork").val(),
            "work_location": $("#locationsOfWork").val(),
            "target_population": $.trim($("#targetPop").val())
        };
        if(type == "event"){
            data["start_date"] = Date.parse($("#from").val()) / 1000;
            if(!one_day){
                data["end_date"] = Date.parse($("#to").val()) / 1000;
            }
        }
        $.post(
            "../controller/create.php",
            data,
            function(d){
                switch(d.code){
                    case 0:
                        $("#msgbox").addClass("red").html("* The connection is interrupted. Please try again");
                        break;
                    case 401:
                        $("#msgbox").addClass("red").html("* Permission denied");
                        break;
                    case 200:
                        $("#msgbox").html("Created successfully. Redirecting, please wait…");
                        window.location = "people_activity.php";
                        break;
                }
            },
            "json"
        );
    });
});
</script>

<?php include("footer.php");?>