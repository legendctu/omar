<?php require_once("../common.php"); ?>
<?php require_once("view_helper.php"); ?>
<?php
    $type = $_GET["type"];
    render_header('Create '.ucfirst($type));
	render_nav('people_activity');
?>

<link rel="stylesheet" type="text/css" href="../css/create.css" media="all" />

<div id="stylized" class="wrap">
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
            <span class="small">When does the event starts.</span>
            </label>
            <input type="text" id="from">
            <div class="clear"></div>
        </div>
    ';
    
    echo '
        <div id="end-date">
            <label>End Date
            <span class="small">When does the event ends.</span>
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
        <p><a id="create" class="button-bg white r14 arial font24 b">Save</a></p>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>

<?php include("footer.php");?>