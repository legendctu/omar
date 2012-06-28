<?php
require_once("api_helper.php");

$type = isset($_POST["type"]) ? $_POST["type"] : "";

switch($type){
    case "get_profile":
        $uid = isset($_POST["uid"]) ? $_POST["uid"] : "";
        $res = callapi("profile/{$uid}", "GET");
        $d = array(
            "code" => $res["code"],
            "content" => json_decode($res["content"])
        );
        echo json_encode($d);
        break;
    case "get_follow_stat":
        $uid = isset($_POST["uid"]) ? $_POST["uid"] : "";
        echo json_encode(callapi("friendships/{$uid}", "GET"));
        break;
    case "basic":
        $firstname = isset($_POST["firstname"]) ? $_POST["firstname"] : "";
        $lastname = isset($_POST["lastname"]) ? $_POST["lastname"] : "";
        $gender = isset($_POST["gender"]) ? $_POST["gender"] : "";
        $languages = isset($_POST["languages"]) ? $_POST["languages"] : "";
        $work_fields = isset($_POST["work_fields"]) ? $_POST["work_fields"] : "";
        $work_location = isset($_POST["work_location"]) ? $_POST["work_location"] : "";
        $target_population = isset($_POST["target_population"]) ? $_POST["target_population"] : "";
        
        $data = array(
            "firstname" => $firstname,
            "lastname" => $lastname,
            "gender" => $gender,
            "languages" => $languages,
            "work_fields" => $work_fields,
            "work_location" => $work_location,
            "target_population" => $target_population
        );
        echo json_encode(callapi("profile", "POST", $data));
        break;
    case "contact":
        $phone_number_country_code = isset($_POST["phone_number_country_code"]) ? $_POST["phone_number_country_code"] : "";
        $phone_number = isset($_POST["phone_number"]) ? $_POST["phone_number"] : "";
        $street = isset($_POST["street"]) ? $_POST["street"] : "";
        $city = isset($_POST["city"]) ? $_POST["city"] : "";
        $province = isset($_POST["province"]) ? $_POST["province"] : "";
        $zip_code = isset($_POST["zip_code"]) ? $_POST["zip_code"] : "";
        $country = isset($_POST["country"]) ? $_POST["country"] : "";
        
        $data = array(
            "phone_number_country_code" => $phone_number_country_code,
            "phone_number" => $phone_number,
            "street" => $street,
            "city" => $city,
            "province" => $province,
            "zip_code" => $zip_code,
            "country" => $country
        );
        echo json_encode(callapi("profile/contact_information", "POST", $data));
        break;
    case "org":
        $name = isset($_POST["name"]) ? $_POST["name"] : "";
        $acronym = isset($_POST["acronym"]) ? $_POST["acronym"] : "";
        $formed_date = isset($_POST["formed_date"]) ? $_POST["formed_date"] : "";
        $website = isset($_POST["website"]) ? $_POST["website"] : "";
        $org_type = isset($_POST["org_type"]) ? $_POST["org_type"] : "";
        $employee_number = isset($_POST["employee_number"]) ? $_POST["employee_number"] : "";
        $annual_budget = isset($_POST["annual_budget"]) ? $_POST["annual_budget"] : "";
        $phone_number_country_code = isset($_POST["phone_number_country_code"]) ? $_POST["phone_number_country_code"] : "";
        $phone_number = isset($_POST["phone_number"]) ? $_POST["phone_number"] : "";
        
        $data = array(
            "name" => $name,
            "acronym" => $acronym,
            "formed_date" => $formed_date,
            "website" => $website,
            "type" => $org_type,
            "employee_number" => $employee_number,
            "annual_budget" => $annual_budget,
            "phone_number_country_code" => $phone_number_country_code,
            "phone_number" => $phone_number
        );
        echo json_encode(callapi("profile/organization_information", "POST", $data));
        break;
        
    case "get_activity":
        $sort = isset($_POST["sort"]) ? $_POST["sort"] : "";
        $count = isset($_POST["count"]) ? $_POST["count"] : "";
        $page = isset($_POST["page"]) ? $_POST["page"] : "";
        $user_id = isset($_POST["user_id"]) ? $_POST["user_id"] : "";
        
        $data = array(
            "sort" => $sort,
            "count" => $count,
            "page" => $page,
            "user_id" => $user_id
        );
        
        $res = callapi("activities", "GET", $data);
        $r = array(
            "code" => $res["code"],
            "content" => json_decode($res["content"], true)
        );
        
        if($r["code"] != 200){
            echo json_encode($r);
            return;
        }
        
        $d = array();
        $avatars = array();
        
        foreach($r["content"]["activities"] as $act){
            $uid = $act["activities_type"] == "follow" || $act["activities_type"] == "unfollow" ? $act["target_user_id"] : $act["user_id"];
            if(!isset($avatars[$uid])){
                $get_avatar = callapi("profile/".$uid, "GET");
                $get_avatar = json_decode($get_avatar["content"], true);
                $get_avatar = md5(strtolower(trim($get_avatar["email"])));
                $avatars[$uid] = "http://www.gravatar.com/avatar/" . $get_avatar;
            }
            
            switch($act["activities_type"]){
                case "user_activate":
                    $str = 
                    '<div class="mt10 p10 border-t">' .
                        "<a href='profile.php?id={$uid}'><img class='avatar fl' src='{$avatars[$uid]}' uid='{$uid}'></a>" .
                        '<a name="follow_btn" action="follow" uid="' . $uid . '" class="fr white font24 arial r14 button-bg pl20 pr20 b shadow follow">follow</a>' .
                        '<div class="intro w500 ml90">' .
                            '<span class="pl10 pr10 arial font24">User Activated</span>' .
                            "<a href='profile.php?id={$uid}' class='arial blue font24 b'>YachLiu====</a>" .
                            "<p class='pl10 verdana font18'>YachLiu==== activated the account.</p>" .
                        '</div>' .
                        '<div class="clear"></div>' .
                    '</div>';
                    break;//====
                case "follow":
                    
                    break;
                case "unfollow":
                    
                    break;
                case "watch":
                    
                    break;
                case "unwatch":
                    
                    break;
                case "post_item":
                    
                    break;
                case "post_comment":
                    
                    break;
                case "profile_modify":
                    
                    break;
                case "contact_information_modify":
                    
                    break;
                case "organization_information_modify":
                    
                    break;
            }
        }
        
        echo json_encode($d);
        break;
}
?>