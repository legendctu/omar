<?php
    $category = isset($_POST["category"]) ? $_POST["category"] : "";
    $title = isset($_POST["title"]) ? $_POST["title"] : "";
    $description = isset($_POST["description"]) ? $_POST["description"] : "";
    $work_fields = isset($_POST["work_fields"]) ? $_POST["work_fields"] : "";
    $work_location = isset($_POST["work_location"]) ? $_POST["work_location"] : "";
    $target_population = isset($_POST["target_population"]) ? $_POST["target_population"] : "";
    
    if($category == "event"){
        $start_date = isset($_POST["start_date"]) ? $_POST["start_date"] : "";
        $end_date = isset($_POST["end_date"]) ? $_POST["end_date"] : "";
        $data = array(
            "category" => $category,
            "title" => $title,
            "description" => $description,
            "work_fields" => $work_fields,
            "work_location" => $work_location,
            "target_population" => $target_population
        );
        $data["start_date"] = $start_date;
        if(!empty($end_date)){
            $data["end_date"] = $end_date;
        }
    }else{
        $data = array(
            "category" => $category,
            "title" => $title,
            "description" => $description,
            "work_fields" => $work_fields,
            "work_location" => $work_location,
            "target_population" => $target_population
        );
    }
    
    require_once("api_helper.php");
    echo json_encode(callapi("items", "POST", $data));
?>