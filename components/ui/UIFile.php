<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of fileUIClass
 *
 * @author ishibkikh
 */
class UIFile extends UIBaseElement
{
    protected $max_size, $url;
    protected $value;

    public function __construct($name, $values) {
        parent::__construct($name, $values['required']);
        $this->max_size = (intval($values['maxSize']) > 0)? intval($values['maxSize']): 5000000;
        $this->url = $values['url'];
        $this->value = $values['value'];
    }
    
    public function getHtml()
    {
        return '<input id="fileupload" type="file" name="files[]" data-url="/'.$this->url.'" multiple>
<script src="/js/jquery.ui.widget.js"></script>
<script src="/js/jquery.iframe-transport.js"></script>
<script src="/js/jquery.fileupload.js"></script>
<script>
$(function()
{
    $("#fileupload").fileupload
    ({
        progressall: function (e, data)
        {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            setpopupnoclose();
            showpopup(\'\',progress+\'%\');
        },
        dataType: "json",
        done: function(e, data)
        {
            PopupHidden();
            setpopupshowclose();
            if(data.result[0]=="success")
            {
                $("<input type=\"hidden\" name=\"uploads[]\" value=\""+data.result[1]+"\"><p><img src=\"/img/icons/success_small.png\"> Success <small>"+data.result[1]+"</small></p>").insertAfter("#fileupload");
            }
            else
            {
                showpopup("Error", data.result[1]);
            }
        }
    });
});
</script>';
    }
}

?>
