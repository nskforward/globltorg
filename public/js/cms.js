function CanRemoveOrder(Id)
{
    if(confirm('Уверены что хотите безвозвратно удалить заявку №'+Id+'?'))
    {
        $.post('/processing/removeorder/'+Id, null, function(data)
        {
            if(data.type=="success")      
                {
                    document.location.reload();
                }
            else
                {
                    alert('Невозможно удалить');
                }
        });
    }
}

function UpdateCourse(Id)
{
        var buttonText = $("#submitButton").text();
        $("#submitButton").html('<img src="css/images/smile_ajax.gif" alt="load">');
        var course_value = $("#course_value").val();
        $.post('/processing/update_course/'+Id, {value: course_value}, function(data)
        {
            if(data.type=="success")      
                {
                    $("#errortext").html('<p class="success">Информация успешно сохранена</p>');
                }
            else
                {
                    $("#errortext").html('<p class="error">'+data.value+'</p>');
                }
        });
        $("#submitButton").html('<div class="button" onclick="checkForm();"><span>'+buttonText+'</span></div>');
}

function setActiveFrame(Id, State, tableName)
{
    $.post('/processing/setactive/'+tableName+'/'+Id+'/'+State, null, function(data)
        {
            if(data.type=="success")      
                {
                    if(State == 1)
                        {
                            $('#state_btn_'+Id).html('Включить');
                        }
                    else
                        {
                            $('#state_btn_'+Id).html('Отключить');
                        }
                }
        });
}

function PopupHidden()
{
   $('.popup__overlay').css('display', 'none');
}

function setUploadForm(Id, img, tableName)
{
   var d = new Date();
   $('#upload_img').attr('src', '/img/'+img+'?'+d.getTime());
   $('#upload_form').attr("action", '/upload/img/'+tableName+'/'+Id);
   $('.popup__overlay').css('display', 'block');
}

function LoadForm(Id, formName)
{
    $("#main-panel").html('<img src="css/images/smile_ajax.gif" alt="load">');
    $.ajaxSetup({async:false});
    $.post('/architect/'+formName+'/'+Id, null, function(data)
        {
            if(data.type=="error")
                {
                    $("#main-panel").html('<p class="error">'+data.value+'</p>');
                    scroll(0,0);
                }
            if(data.type=="success")      
                   {
                       $("#main-panel").html(data.value);
                   }
        });
}

var Obj = {};

function loadContent(Url, Id)
{
    $("#main-panel").html('<img src="css/images/smile_ajax.gif" alt="load">');
    $.ajaxSetup({async:false});
    $.post('/json/'+Url+'/'+Id, null, function(data)
        {
            if(data.type=="error")
                {
                    $("#main-panel").html('<p class="error">'+data.value+'</p>');
                    scroll(0,0);
                }
            if(data.type=="success")      
                   {
                       Obj = data.value;
                   }
        });
}

function AddEl(Title, Element)
{
    $('#formEl').append('<tr><td>'+Title+'</td><td>'+Element+'</td></tr>');
}


function disableInfo()
{
    $('#errortext').html('');
}

function LoadPage(Id, formName)
{
    loadContent(formName, Id);
    $("#main-panel").html('<div class="popup__overlay"><div class="popup"><a href="#" onclick="PopupHidden();" class="popup__close">X</a><h2>Выберите новое изображение</h2>'+
        '<img id="upload_img" height="200" src="#"><div class="popup-form__row"><p class="red">Внимание! Загружаемое изображение должно быть формата JPEG и иметь размеры не менее 300 x 200</p>'+
        '<form id="upload_form" name="index" enctype="multipart/form-data" action="" method="POST"><input type="hidden" name="MAX_FILE_SIZE" value="1500000">'+
        '<input name="userfile" type="file"><input type="submit" value="Заменить"></form></div></div></div>'+
        '<form name="'+formName+'" class="cmsform"><div id="errortext"></div><table id="formEl"></table></form>');
    AddEl('Заголовок', '<input type="text" id="test2" onkeypress="disableInfo();" name="title" value="'+Obj.title+'">');
    AddEl('Контент', '<textarea onkeypress="disableInfo();" name="content" rows="30">'+Obj.content+'</textarea>');
    AddEl('URL', '<input type="text" onkeypress="disableInfo();" name="url" value="'+Obj.url+'">');
    AddEl('Левая верхняя<br>картинка', '<strong>'+Obj.lt_sb+'</strong> <button onclick="setUploadForm(\''+Id+'\', \''+Obj.lt_sb+'\', \'pages/0\');return false;">Заменить</button>');
    AddEl('Левая нижняя<br>картинка', '<strong>'+Obj.ld_sb+'</strong> <button onclick="setUploadForm(\''+Id+'\', \''+Obj.ld_sb+'\', \'pages/1\');return false;">Заменить</button>');
    AddEl('Правая картинка', '<strong>'+Obj.r_sb+'</strong> <button onclick="setUploadForm(\''+Id+'\', \''+Obj.r_sb+'\', \'pages/2\');return false;">Заменить</button>');
    AddEl('', '<input type="hidden" name="id" id="test" value="'+Id+'">');
    AddEl('', '<div id="submitButton"><div class="button" onclick="checkForm(\''+formName+'\');"><span>Применить</span></div>');
    AddEl('', '');
    AddEl('', '<a href="#" onclick="RemovePage(\''+Id+'\');return false;">Удалить</h4>');
    
}

function RemovePage(Id)
{
    if (confirm("Вы уверены, что хотите безвозвратно удалить эту страницу?\nВместе со страницей, автоматически удалятся все фреймы и баннеры, ссылающиеся на эту страницу"))
    {
        $.post('/processing/pageremove/'+Id,null,function(data)
        {
            if (data.type=="error")
                {
                    scroll(0,0);
                    alert(data.value);
                }
            
            if (data.type=="success")      
                   {
                       alert('Страница с id='+Id+' удалена');
                       location.reload();
                   }
         });
    }
}


function send_form(formName)
{
    var buttonText;
    buttonText=$("#submitButton").text();
    $("#submitButton").html('<img src="css/images/smile_ajax.gif" alt="load">');
    var fields=$('form[name='+formName+']').serializeArray();
    var d=new Date();fields["d"]=d.getTime();
    $.post('/processing/'+formName,fields,function(data)
        {
            if (data.type=="error")
                {
                    $("#submitButton").html('<div class="button" onclick="checkForm(\'formName\');"><span>'+buttonText+'</span></div>');
                    scroll(0,0);
                    $("#errortext").html('<p class="error">'+data.value+'</p>');
                }
            
            if (data.type=="redirect")
                {
                    location.href = data.value;
                }
                   
            
            if (data.type=="success")      
                   {
                       $("#submitButton").html('<div class="button" onclick="checkForm(\''+formName+'\');"><span>'+buttonText+'</span></div>');
                       scroll(0,0);
                       if((data.value != '')&(data.value != undefined))
                           {
                               $("#errortext").html('<p class="success">'+data.value+'</p>');
                           }
                       else
                           {
                               $("#errortext").html('<p class="success">Информация успешно сохранена</p>');
                           }
                   }
         });
}


function checkForm(formName)
{
   var el, elName, value, type, form;
   error = 0;
   form=document.forms[formName];
   for(var i=0;i<form.length;i++)
   {
       el = form.elements[i];
       elName = el.nodeName.toLowerCase();
       value = $.trim(el.value);
       
       if((value == "")&(elName != 'button'))
       {
           error = error + 1;
           showmessage('Не заполнено поле [ '+el.name+' ]');
       }
   }
   if(error == 0)
   {
       send_form(formName);
   }
}
