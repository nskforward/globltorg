var error=0;

function ReCaptcha(){
    document.getElementById("captcha").src = "/captcha"+"?rand="+Math.random();
}

function send_anketa(formName, url){
    var buttonText;
    buttonText=$("#submitButton").text();
    $("#submitButton").html('<img src="css/images/smile_ajax.gif" alt="load">');
    var fields=$('form[name='+formName+']').serializeArray();
    var d=new Date();
    fields["d"]=d.getTime();
    $.post(url,fields,function(data)
        {
            if (data.type=="error")
                {
                    $("#submitButton").html('<div class="button" onclick="checkForm();"><span>'+buttonText+'</span></div>');
                    scroll(0,0);
                    $("#errortext").html('<p class="error">'+data.value+'</p>');
                    ReCaptcha();
                }
            
            if (data.type=="redirect")
                {
                    location.href = data.value;
                }
                   
            
            if (data.type=="success")      
                   {
                       $("#submitButton").html('<div class="button" onclick="checkForm();"><span>'+buttonText+'</span></div>');
                       scroll(0,0);
                       if (data.value.length == 0)
                           {
                               $("#errortext").html('<p class="success">Информация успешно сохранена</p>');
                           }
                       else
                           {
                               $("#errortext").html('<p class="success">'+data.value+'</p>');
                           }
                       document.forms[formName].reset();
                       ReCaptcha();
                   }
 
        });
}

function showmessage(text){
    $("#errortext").html('<p class="error">'+text+'</p>');
    error = error + 1;
}

function suggest(element, inputString, url_name)
{
    inputString = $.trim(inputString);
    if(inputString.length < 2)
        {
            $('#suggestions').fadeOut();
	}
    else
        {
            $('input[name='+element+']').addClass('load');
            $.ajax({ 
                type: "POST", 
                url: '/json/'+url_name, 
                dataType: "json", 
                data: "q="+inputString,
                success: function(json) {
                    if(json.length > 0)
                     {
                        $('#suggestions').fadeIn();
                        var items = '<ul>';
                        $.each(json, function(key, value) {
                            items = items+ '<li onClick="fill(\''+element+'\',\''+value+'\');">'+value+'</li>';
                        });
                        items = items + '</ul>';
                        $('#suggestionsList').html(items);
                        $('input[name='+element+']').removeClass('load');
                     }
                     else
                         $('input[name='+element+']').removeClass('load');
                    }
		});
	}
}

function fill(element, thisValue)
{
    $('input[name='+element+']').val(thisValue);
    setTimeout("$('#suggestions').fadeOut();", 200);
}