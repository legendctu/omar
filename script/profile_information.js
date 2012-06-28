$(document).ready(function(){
    $(".edit").click(function(){
        if ($(this).parent().next('div').attr("in_edit") == "0") {
            $(this).parent().next('div').attr("in_edit", "1");
            $(this).html('Save');
            $(this).next().html('Cancel');
            $(this).parent().next('div').children('span')
                    .each(function(){
                        $(this).next().addClass('hidden');
                        if (($(this).attr('is_special') != 'select') &&
                            ($(this).attr('is_special') != 'date')) {
                            v = $(this).next().html();
                            $(this).after("<input type='text' value='" + v + "'>");
                        }
                        else {
                            v = $(this).next().html();
                            console.log(v);
                            $(this).after(p_to_special($(this).attr('id')));
                            $(".datepicker").datepicker({ 
                                dateFormat: "yy-mm-dd", 
                                changeMonth: true,
                                changeYear: true});
                            $(this).next().val(v);
                        }
            });
        }
        else {
            $(this).parent().next('div').attr("in_edit", "0");
            $(this).html('Edit');
            $(this).next().html('Download');
            data = new Array();
            $(this).parent().next('div').children('input, select')
                .each(function(){
                    if ($(this).prev().attr('id') == 'form_date') {
                        data.push(Date.parse($(this).val().replace(/-/g, '/'))/1000);
                    }
                    else
                        data.push($(this).val());
                    $(this).next().removeClass('hidden');
                    $(this).remove();
                });
            post_info($(this).attr("id"), data);
        }
    });
   
    $(".cancel").click(function(){
        if ($(this).parent().next('div').attr("in_edit") == "1") {
            $(this).parent().next('div').attr("in_edit", "0");
            $(this).prev('a').html('Edit');
            $(this).html('Download');
            $(this).parent().next('div').children('input, select')
                    .each(function(){
                        $(this).next().removeClass('hidden');
                        $(this).remove();
            });
        }
    });

});

function p_to_special(id, obj)
{
    var txt;
    if (id == "gender_select"){
        txt = "<select><option>male</option><option>female</option><option>unknown</option></select>";
    }
    else if (id == 'emp_select') {
        txt = "<select><option>less than 10</option><option>11-25</option><option>26-40</option><option>41-60</option><option>61-80</option><option>81-100</option><option>101-150</option><option>151-200</option><option>more than 200</option></select>";
    }
    else if (id == 'bgt_select') {
        txt = "<select><option>less than $50,000</option><option>$50,000- $100,000</option><option>$100,000-$200,000</option><option>$200,000-$500,000</option><option>$500,000- $1,000,000</option><option>$1,000,000- $5,000,000</option><option>$5,000,000- $10,000,000</option><option>more than $10,000,000</option></select>";
    }
    else if (id == 'form_date') {
        txt = "<input type='text' class='datepicker' />";
    }
    return txt;
}

function post_info(type, data)
{
    if (type == 'basic-edit') 
    {
        info = {
                "type": "basic",
                "firstname": data[0],
                "lastname": data[1],
                "gender": data[2],
                "languages": data[3],
                "work_fields": data[4],
                "work_location": data[5],
                "target_population": data[6]
            };
    }
    else if (type == 'contact-edit')
    {
        info = {
                "type": "contact",
                "phone_number_country_code": data[0],
                "phone_number": data[1],
                "street": data[2],
                "city": data[3],
                "province": data[4],
                "zip_code": data[5],
                "country": data[6]
            };
    }
    else if(type == 'organization-edit')
    {
        info = {
                "type": "org",
                "name" : data[0],
                "acronym" : data[1],
                "formed_date" : data[2],
                "website" : data[3],
                "org_type" : data[4],
                "employee_number" : data[5],
                "annual_budget" : data[6],
                "phone_number_country_code" : data[7],
                "phone_number" : data[8]
            };
    }
    $.post(
            "../controller/profile.php",
            info,
            function(d){
                i = 0;
                $("#"+type).parent().next('div').children("p").each(function(){
                    if ($(this).prev().attr('id') == 'form_date') {
                        var date = new Date(data[i++]*1000);
                        var y = date.getFullYear(),
                            m = date.getMonth() + 1,
                            d = date.getDate();
                        $(this).html(y + '-' + m + '-' + d);
                    }
                    else {
                        $(this).html(data[i++]);
                    }
                });
            },
            "json"
    );
}