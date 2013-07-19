var error=0;
var is_tooltip = false;

$(document).ready(function()
{
    $('.autocomplete').keyup(function()
    {
        suggest($(this).attr('name'), $(this).val(), '/autosuggest/'+$(this).attr('name'));
    });
 });

function checkForm(formname, action)
{
    error=0;
    clearTooltip();
    var el,value,form,fixerror;
    form=document.forms[formname];
    for(var i=0;i<form.length;i++)
    {
        fixerror = error;
        el=form.elements[i];
        value=$.trim(el.value);
        if (typeof window['checkform_'+formname+'_'+el.name+'_required'] === 'function')
        {
            window['checkform_'+formname+'_'+el.name+'_required'](value);
        }
        if(fixerror===error)
        {
            if (typeof window['checkform_'+formname+'_'+el.name+'_length'] === 'function')
            {
                window['checkform_'+formname+'_'+el.name+'_length'](value);
            }
        }
        if(fixerror===error)
        {
            if (typeof window['checkform_'+formname+'_'+el.name+'_validator'] === 'function')
            {
                window['checkform_'+formname+'_'+el.name+'_validator'](value);
            }
        }
        if(fixerror===error)
        {
            if (typeof window['checkform_'+formname+'_'+el.name+'_custom'] === 'function')
            {
                window['checkform_'+formname+'_'+el.name+'_custom'](value);
            }
        }
    }
    if(error===0)
    {
        post(formname, action);
    }
}


function clearTooltip()
{
    is_tooltip = false;
    $('.tooltip').remove();
    $('.problemelement').removeClass('problemelement');
}

function put_error(name, text)
{
    error = error + 1;
    tooltip(name, text);
}

function ReCaptcha(){
    if (document.getElementById("captcha") != null)
        {
            document.getElementById("captcha").src = "/captcha"+"?rand="+Math.random();
        }
}

function post(Name, url)
{
    var fields=$('form[name='+Name+']').serializeArray();
    setpopupnoclose();
    showpopup('','Пожалуйста, подожтите...');
    //$('textarea#jseditor').val(tinyMCE.get('content').getContent());
    if ( fields.length === 0)
    {
        var fields = new Array();
        var param = $('[name='+Name+']').val();
        if (param == "")
            {
                showpopup('Warning', 'Do not select the option you want. Please Enter or select the required options');
                return;
            }
        else
            {
                fields.push({name: Name, value: param});
            }
    }
  
    $.ajax({
    type: 'POST',
    dataType: 'json',
    url: url,
    data: fields,
    success: function(data)
    {
        PopupHidden();
        setpopupshowclose();
        if (data[0]=="error")
        {
            $.each(data[1], function(key, value)
            {
                tooltip(key, value);
            });
            ReCaptcha();
        }
            
        if (data[0]=="redirect")
        {
            location.href = data[1];
        }
            
        if (data[0]=="refresh")
        {
            location.reload();
        }
        
        if (data[0]=="message")
        {
            scroll(0,0);
            $.each(data[1], function(key, value)
            {
                showpopup(key, value);
                if (data[2] == true)
                {
                    document.forms[Name].reset();
                }
            });
            ReCaptcha();
        }
    },
    error: function(jqXHR, textStatus, errorThrown)
    {
        PopupHidden();
        setpopupshowclose();
        showpopup(textStatus, errorThrown);
    }
});
}

function showpopup(title, message)
{
    checkFormCreate();
    $('#popup_title').html(title);
    $('#popup_text').html(message);
    $('.popup__overlay').css('display', 'block');
}

function PopupHidden()
{
   $('.popup__overlay').css('display', 'none');
}

function setpopupnoclose()
{
    $('.popup__close').css('display', 'none');
}

function setpopupshowclose()
{
    $('.popup__close').css('display', 'block');
}

function checkFormCreate()
{
    if ($("#popup_title").length == 0)
    {
        var dlg = document.createElement('div');
        dlg.setAttribute("class", "popup__overlay");
        
        var popup = document.createElement('div');
        popup.setAttribute("class", "popup");
        dlg.appendChild(popup);
        
        var closelink = document.createElement('a');
        closelink.setAttribute("class", "popup__close");
        closelink.setAttribute("onclick", "PopupHidden();return false;");
        closelink.setAttribute("href", "#");
        closelink.innerHTML = 'X';
        popup.appendChild(closelink);
        
        var head = document.createElement('h2');
        head.setAttribute("id", "popup_title");
        popup.appendChild(head);
        
        var row = document.createElement('div');
        row.setAttribute("class", "popup-form__row");
        popup.appendChild(row);
        
        var text = document.createElement('div');
        text.setAttribute("id", "popup_text");
        row.appendChild(text);
        
        document.body.appendChild(dlg);
    }
}

function suggest(element, inputString, url_name)
{
    inputString = $.trim(inputString);
    if(inputString.length < 2)
        {
            $('#suggestionsList').fadeOut();
	}
    else
        {
            $.ajaxSetup({dataType: "json"});
            $.post(url_name, 'query='+inputString, function(data)
            {
                if(Object.keys(data).length > 0)
                     {
                        $('#suggestionsList').remove();
                        var suggest = document.createElement('div');
                        var pos = $('input[name='+element+']').offset();
                        suggest.setAttribute("id", "suggestionsList");
                        suggest.style.top = pos.top+$('input[name='+element+']').height()+3+'px';
                        suggest.style.left = pos.left+'px';
                        
                        var parent = document.getElementsByTagName('BODY')[0];
                        parent.appendChild(suggest);
                        
                        var items = '<ul>';
                        $.each(data, function(key, value) {
                            items = items+ '<li onClick="fill(\''+element+'\',\''+value+'\');">'+value+'</li>';
                        });
                        items = items + '</ul>';
                        $('#suggestionsList').html(items);
                     }
                     else
                     { 
                        $('input[name='+element+']').removeClass('load');
                     }
            });
	}
}

function tooltip(element, message)
{
    var el = $('[name='+element+']');
    el.addClass('problemelement');
    $('<span class="tooltip">'+message+'</span>').insertAfter('[name='+element+']');
    /*
    var pos = el.offset();
    el.addClass('problemelement');
    var tooltip = document.createElement('span');
    tooltip.className = 'tooltip';
    var textNode = document.createTextNode(message);
    tooltip.appendChild(textNode);
    tooltip.style.top = pos.top+'px';
    tooltip.style.left = pos.left+el.width()+12+'px';
    var parent = document.getElementsByTagName('BODY')[0];
    parent.appendChild(tooltip);
    */
    is_tooltip = true;
}

function fill(element, thisValue)
{
    $('input[name='+element+']').val(thisValue);
    $('#suggestionsList').fadeOut(100);
}

function confirmDlg(text, url)
{
   if (confirm(text))
   { 
       $.ajaxSetup({dataType: "json"});
       $.post(url,'',function(data)
       {
            if (data[0]=="refresh")
                {
                    location.reload();
                }
            
            if (data[0]=="redirect")
                {
                    location.href = data[1];
                }
                   
            
            if (data[0]=="message")
                {
                    scroll(0,0);
                    $.each(data[1], function(key, value)
                    {
                       showpopup(key, value);
                    });
                    ReCaptcha();
                }
        }, "json");
   }
}

function inputDlg(text, default_value, url)
{
   var result = prompt(text, default_value);
   if ((result)&&(result !== default_value))
   {
       $.ajaxSetup({dataType: "json"});
       $.post(url,'query='+result,function(data)
       {
            if (data[0]=="refresh")
                {
                    location.reload();
                }
            
            if (data[0]=="redirect")
                {
                    location.href = data[1];
                }
                   
            
            if (data[0]=="message")
                {
                    scroll(0,0);
                    $.each(data[1], function(key, value)
                    {
                       showpopup(key, value);
                    });
                    ReCaptcha();
                }
        }, "json");
   }
}

function loadForm(url)
{
    setpopupnoclose();
    showpopup('', 'Пожалуйста, подожтите...');
    $.ajaxSetup({dataType: "json"});
    $.post(url,'',function(data)
    {
        PopupHidden();
        setpopupshowclose();
        if (data[0]=="message")
        {
            $.each(data[1], function(key, value)
            {
                showpopup(key, value);
            });
            ReCaptcha();
        }
    }, "json");
}