<?php
function translate($string)
{
$src = '../application/xml/localizations.xml';
if(!is_file($src))
 {
    throw new CustomException('Error: file "localizations.xml" not found');
 }
 
If (!defined('LANG'))
{
    throw new CustomException('undefined LANG');
}

$xml   = simplexml_load_file($src);
$result = $xml->xpath('//cod[@name="'.$string.'"]/title[@lang="'.LANG.'"]');
list( , $node) = each($result);

If ($node == '')
{
    return '*_not translate_*';
}
else
{
    return $node;
}


}

function fdate($date)
{
    return date('d.m.Y H:i', strtotime($date));
}

function rjson($type, $value)
{
    return json_encode(array('type' => $type, 'value' => $value));
}

function GetItemsTourByContinent($parent_id, $continent)
{
    $db = new dbClass('places_tour');
    $items = $db->getByValue('parent_id', $parent_id, 100);
    $count = $db->count();
    $body = '';
    If ($count > 1)
        For ($i=0; $i<$count; $i++)
        {
            $body .= '<li><div class="wrap-img"><img src="/img/'.$items[$i]->des_img.'" alt="'.$items[$i]->title.'" onload="resizing_pictures(this,425,254,\'cnow\');"><div></div></div><div class="wrap-text">'.
            '<h6>'.$items[$i]->title.'</h6><p>'.$items[$i]->des.'</p><a href="/world/'.$continent.'/'.$items[$i]->url.'">Читать далее</a></div></li>
';
         }
    elseIf ($count == 1)
        $body = '<li><div class="wrap-img"><img src="/img/'.$items->des_img.'" alt="Австралия" onload="resizing_pictures(this,425,254,\'cnow\');"><div></div></div><div class="wrap-text">'.
                '<h6>'.$items->title.'</h6><p>'.$items->des.'</p><a href="/world/'.$continent.'/'.$items->url.'">Читать далее</a></div></li>';
    return $body;
}

?>