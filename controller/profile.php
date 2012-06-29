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
        $sort = isset($_POST["sort"]) ? $_POST["sort"] : "time";
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
        
        $profiles = array();
        $items = array();
        foreach($r["content"]["activities"] as $act){
            $uid = $act["user_id"];
            if(!isset($profiles[$uid])){
                $get_profile = callapi("profile/".$uid, "GET");
                $profiles[$uid] = json_decode($get_profile["content"], true);
                $profiles[$uid]["avatar"] = "http://www.gravatar.com/avatar/" . md5(strtolower(trim($profiles[$uid]["email"])));
                $get_follow_status = callapi("friendships/{$uid}", "GET");
                $profiles[$uid]["is_following"] = $get_follow_status["code"] == 200 ? true : false;
            }
            
            if(isset($act["target_user_id"]) && !isset($act["target_user_id"])){
                $uid = $act["target_user_id"];
                $get_profile = callapi("profile/".$uid, "GET");
                $profiles[$uid] = json_decode($get_profile["content"], true);
                $profiles[$uid]["avatar"] = "http://www.gravatar.com/avatar/" . md5(strtolower(trim($profiles[$uid]["email"])));
                $profiles[$uid]["is_following"] = $get_follow_status["code"] == 200 ? true : false;
            }
            
            if(isset($act["item_id"]) && !isset($items[$act["item_id"]])){
                $iid = $act["item_id"];
                $get_item = callapi("items/{$iid}", "GET");
                $items[$iid] = json_decode($get_item["content"], true);
                $get_watch_status = callapi("watch/{$iid}", "GET");
                $items[$iid]["is_watching"] = $get_watch_status["code"] == 200 ? true : false;
            }
        }

        $d = array();
        foreach($r["content"]["activities"] as $act){
            $uid = $act["activities_type"] == "follow" || $act["activities_type"] == "unfollow" ? $act["target_user_id"] : $act["user_id"];
            $iid = isset($act["item_id"]) ? $act["item_id"] : "";
            
            switch($act["activities_type"]){
                case "user_activate":
                    $str = 
                    '<div class="mt10 p10 border-t">' .
                        "<a href='profile.php?id={$uid}'><img class='avatar fl' src='{$profiles[$uid]["avatar"]}' uid='{$uid}'></a>";
                    if($_COOKIE["OH_id"] != $uid){
                        if($profiles[$uid]["is_following"])
                            $str .= '<a name="follow_btn" action="unfollow" uid="' . $uid . '" class="fr white font24 arial r14 button-bg pl20 pr20 b shadow follow">unfollow</a>';
                        else
                            $str .= '<a name="follow_btn" action="follow" uid="' . $uid . '" class="fr white font24 arial r14 button-bg pl20 pr20 b shadow follow">follow</a>';
                    }
                    $str .=
                        '<div class="intro w500 ml90">' .
                            '<span class="pl10 pr10 arial font24">User Activated</span>' .
                            "<a href='profile.php?id={$uid}' class='arial blue font24 b'>{$profiles[$uid]["firstname"]} {$profiles[$uid]["lastname"]}</a>" .
                            "<p class='pl10 verdana font18'>{$profiles[$uid]["firstname"]} {$profiles[$uid]["lastname"]} has activated the account.</p>" .
                        '</div>' .
                        '<div class="clear"></div>' .
                    '</div>';
                    $d[] = $str;
                    break;//user_activate end
                case "follow":
                    $str = 
                    '<div class="mt10 p10 border-t">' .
                        "<a href='profile.php?id={$uid}'><img class='avatar fl' src='{$profiles[$uid]["avatar"]}' uid='{$uid}'></a>";
                    if($_COOKIE["OH_id"] != $uid){
                        if($profiles[$uid]["is_following"])
                            $str .= '<a name="follow_btn" action="unfollow" uid="' . $uid . '" class="fr white font24 arial r14 button-bg pl20 pr20 b shadow follow">unfollow</a>';
                        else
                            $str .= '<a name="follow_btn" action="follow" uid="' . $uid . '" class="fr white font24 arial r14 button-bg pl20 pr20 b shadow follow">follow</a>';
                    }
                    $str .= 
                        '<div class="intro w500 ml90">' .
                            '<span class="pl10 pr10 arial font24">Follow</span>' .
                            "<a href='profile.php?id={$uid}' class='arial blue font24 b'>{$profiles[$uid]["firstname"]} {$profiles[$uid]["lastname"]}</a>" .
                            "<p class='pl10 verdana font18'>{$profiles[$act["user_id"]]["firstname"]} {$profiles[$act["user_id"]]["lastname"]} has followed {$profiles[$uid]["firstname"]} {$profiles[$uid]["lastname"]}.</p>" .
                        '</div>' .
                        '<div class="clear"></div>' .
                    '</div>';
                    $d[] = $str;
                    break;//follow end
                case "unfollow":
                    $str = 
                    '<div class="mt10 p10 border-t">' .
                        "<a href='profile.php?id={$uid}'><img class='avatar fl' src='{$profiles[$uid]["avatar"]}' uid='{$uid}'></a>";
                    if($_COOKIE["OH_id"] != $uid){
                        if($profiles[$uid]["is_following"])
                            $str .= '<a name="follow_btn" action="unfollow" uid="' . $uid . '" class="fr white font24 arial r14 button-bg pl20 pr20 b shadow follow">unfollow</a>';
                        else
                            $str .= '<a name="follow_btn" action="follow" uid="' . $uid . '" class="fr white font24 arial r14 button-bg pl20 pr20 b shadow follow">follow</a>';
                    }
                    $str .=
                        '<div class="intro w500 ml90">' .
                            '<span class="pl10 pr10 arial font24">Unfollow</span>' .
                            "<a href='profile.php?id={$uid}' class='arial blue font24 b'>{$profiles[$uid]["firstname"]} {$profiles[$uid]["lastname"]}</a>" .
                            "<p class='pl10 verdana font18'>{$profiles[$act["user_id"]]["firstname"]} {$profiles[$act["user_id"]]["lastname"]} has unfollowed {$profiles[$uid]["firstname"]} {$profiles[$uid]["lastname"]}.</p>" .
                        '</div>' .
                        '<div class="clear"></div>' .
                    '</div>';
                    $d[] = $str;
                    break;//unfollow end
                case "watch":
                    $str = 
                    '<div class="mt10 p10 border-t">' .
                        "<a href='profile.php?id={$uid}'><img class='avatar fl' src='{$profiles[$uid]["avatar"]}' uid='{$uid}'></a>";
                    if($_COOKIE["OH_id"] != $uid){
                        if($items[$iid]["is_watching"])
                            $str .= '<a name="watch_btn" action="unwatch" iid="' . $iid . '" class="fr white font24 arial r14 button-bg pl20 pr20 b shadow follow">unfollow</a>';
                        else
                            $str .= '<a name="watch_btn" action="watch" iid="' . $iid . '" class="fr white font24 arial r14 button-bg pl20 pr20 b shadow follow">follow</a>';
                    }
                    $str .=
                        '<div class="intro w500 ml90">' .
                            '<span class="pl10 pr10 arial font24">Follow ' . $items[$iid]["category"] . '</span>' .
                            "<a href='show_item.php?id={$iid}' class='arial blue font24 b'>{$items[$iid]["title"]}</a>" .
                            "<p class='pl10 verdana font18'>{$profiles[$uid]["firstname"]} {$profiles[$uid]["lastname"]} has followed the {$items[$iid]["category"]} {$items[$iid]["title"]}.</p>" .
                        '</div>' .
                        '<div class="clear"></div>' .
                    '</div>';
                    $d[] = $str;
                    break;//watch end
                case "unwatch":
                    $str = 
                    '<div class="mt10 p10 border-t">' .
                        "<a href='profile.php?id={$uid}'><img class='avatar fl' src='{$profiles[$uid]["avatar"]}' uid='{$uid}'></a>";
                    if($_COOKIE["OH_id"] != $uid){
                        if($items[$iid]["is_watching"])
                            $str .= '<a name="watch_btn" action="unwatch" iid="' . $iid . '" class="fr white font24 arial r14 button-bg pl20 pr20 b shadow follow">unfollow</a>';
                        else
                            $str .= '<a name="watch_btn" action="watch" iid="' . $iid . '" class="fr white font24 arial r14 button-bg pl20 pr20 b shadow follow">follow</a>';
                    }
                    $str .=
                        '<div class="intro w500 ml90">' .
                            '<span class="pl10 pr10 arial font24">Unfollow ' . $items[$iid]["category"] . '</span>' .
                            "<a href='show_item.php?id={$iid}' class='arial blue font24 b'>{$items[$iid]["title"]}</a>" .
                            "<p class='pl10 verdana font18'>{$profiles[$uid]["firstname"]} {$profiles[$uid]["lastname"]} has unfollowed the {$items[$iid]["category"]} {$items[$iid]["title"]}.</p>" .
                        '</div>' .
                        '<div class="clear"></div>' .
                    '</div>';
                    $d[] = $str;
                    break;//unwatch end
                case "post_item":
                    $str = 
                    '<div class="mt10 p10 border-t">' .
                        "<a href='profile.php?id={$uid}'><img class='avatar fl' src='{$profiles[$uid]["avatar"]}' uid='{$uid}'></a>";
                    if($_COOKIE["OH_id"] != $uid){
                        if($items[$iid]["is_watching"])
                            $str .= '<a name="watch_btn" action="unwatch" iid="' . $iid . '" class="fr white font24 arial r14 button-bg pl20 pr20 b shadow follow">unfollow</a>';
                        else
                            $str .= '<a name="watch_btn" action="watch" iid="' . $iid . '" class="fr white font24 arial r14 button-bg pl20 pr20 b shadow follow">follow</a>';
                    }
                    $str .=
                        '<div class="intro w500 ml90">' .
                            '<span class="pl10 pr10 arial font24">Publish ' . $items[$iid]["category"] . '</span>' .
                            "<a href='show_item.php?id={$iid}' class='arial blue font24 b'>{$items[$iid]["title"]}</a>" .
                            "<p class='pl10 verdana font18'>{$profiles[$uid]["firstname"]} {$profiles[$uid]["lastname"]} has published the {$items[$iid]["category"]} {$items[$iid]["title"]}.</p>" .
                        '</div>' .
                        '<div class="clear"></div>' .
                    '</div>';
                    $d[] = $str;
                    break;//post_item end
                case "post_comment":
                    $str = 
                    '<div class="mt10 p10 border-t">' .
                        "<a href='profile.php?id={$uid}'><img class='avatar fl' src='{$profiles[$uid]["avatar"]}' uid='{$uid}'></a>";
                    if($_COOKIE["OH_id"] != $uid){
                        if($items[$iid]["is_watching"])
                            $str .= '<a name="watch_btn" action="unwatch" iid="' . $iid . '" class="fr white font24 arial r14 button-bg pl20 pr20 b shadow follow">unfollow</a>';
                        else
                            $str .= '<a name="watch_btn" action="watch" iid="' . $iid . '" class="fr white font24 arial r14 button-bg pl20 pr20 b shadow follow">follow</a>';
                    }
                    $str .=
                        '<div class="intro w500 ml90">' .
                            '<span class="pl10 pr10 arial font24">Post a comment</span>' .
                            "<a href='show_item.php?id={$iid}' class='arial blue font24 b'>{$items[$iid]["title"]}</a>" .
                            "<p class='pl10 verdana font18'>{$profiles[$uid]["firstname"]} {$profiles[$uid]["lastname"]} has post a comment in the {$items[$iid]["category"]} {$items[$iid]["title"]}.</p>" .
                        '</div>' .
                        '<div class="clear"></div>' .
                    '</div>';
                    $d[] = $str;
                    break;//post_comment end
                case "profile_modify":
                    $str = 
                    '<div class="mt10 p10 border-t">' .
                        "<a href='profile.php?id={$uid}'><img class='avatar fl' src='{$profiles[$uid]["avatar"]}' uid='{$uid}'></a>";
                    if($_COOKIE["OH_id"] != $uid){
                        if($profiles[$uid]["is_following"])
                            $str .= '<a name="follow_btn" action="unfollow" uid="' . $uid . '" class="fr white font24 arial r14 button-bg pl20 pr20 b shadow follow">unfollow</a>';
                        else
                            $str .= '<a name="follow_btn" action="follow" uid="' . $uid . '" class="fr white font24 arial r14 button-bg pl20 pr20 b shadow follow">follow</a>';
                    }
                    $str .=
                        '<div class="intro w500 ml90">' .
                            '<span class="pl10 pr10 arial font24">Profile</span>' .
                            "<a href='profile.php?id={$uid}' class='arial blue font24 b'>Basic information edited</a>" .
                            "<p class='pl10 verdana font18'>{$profiles[$uid]["firstname"]} {$profiles[$uid]["lastname"]} has edited the basic information.</p>" .
                        '</div>' .
                        '<div class="clear"></div>' .
                    '</div>';
                    $d[] = $str;
                    break;//profile_modify end
                case "contact_information_modify":
                    $str = 
                    '<div class="mt10 p10 border-t">' .
                        "<a href='profile.php?id={$uid}'><img class='avatar fl' src='{$profiles[$uid]["avatar"]}' uid='{$uid}'></a>";
                    if($_COOKIE["OH_id"] != $uid){
                        if($profiles[$uid]["is_following"])
                            $str .= '<a name="follow_btn" action="unfollow" uid="' . $uid . '" class="fr white font24 arial r14 button-bg pl20 pr20 b shadow follow">unfollow</a>';
                        else
                            $str .= '<a name="follow_btn" action="follow" uid="' . $uid . '" class="fr white font24 arial r14 button-bg pl20 pr20 b shadow follow">follow</a>';
                    }
                    $str .=
                        '<div class="intro w500 ml90">' .
                            '<span class="pl10 pr10 arial font24">Profile</span>' .
                            "<a href='profile.php?id={$uid}' class='arial blue font24 b'>Contact information edited</a>" .
                            "<p class='pl10 verdana font18'>{$profiles[$uid]["firstname"]} {$profiles[$uid]["lastname"]} has edited the contact information.</p>" .
                        '</div>' .
                        '<div class="clear"></div>' .
                    '</div>';
                    $d[] = $str;
                    break;//contact_information_modify end
                case "organization_information_modify":
                    $str = 
                    '<div class="mt10 p10 border-t">' .
                        "<a href='profile.php?id={$uid}'><img class='avatar fl' src='{$profiles[$uid]["avatar"]}' uid='{$uid}'></a>";
                    if($_COOKIE["OH_id"] != $uid){
                        if($profiles[$uid]["is_following"])
                            $str .= '<a name="follow_btn" action="unfollow" uid="' . $uid . '" class="fr white font24 arial r14 button-bg pl20 pr20 b shadow follow">unfollow</a>';
                        else
                            $str .= '<a name="follow_btn" action="follow" uid="' . $uid . '" class="fr white font24 arial r14 button-bg pl20 pr20 b shadow follow">follow</a>';
                    }
                    $str .=
                        '<div class="intro w500 ml90">' .
                            '<span class="pl10 pr10 arial font24">Profile</span>' .
                            "<a href='profile.php?id={$uid}' class='arial blue font24 b'>Organization information edited</a>" .
                            "<p class='pl10 verdana font18'>{$profiles[$uid]["firstname"]} {$profiles[$uid]["lastname"]} has edited the organization information.</p>" .
                        '</div>' .
                        '<div class="clear"></div>' .
                    '</div>';
                    $d[] = $str;
                    break;//organization_information_modify end
            }
        }
        
        echo json_encode($d);
        break;
}
?>