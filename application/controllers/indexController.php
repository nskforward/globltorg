<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of loginController
 *
 * @author ishibkikh
 */
class indexController
{
    public function _init()
    {
        $content = ComCacheFile::get('index'.'index');
        if ($content != null)
        {
            ComHTML::dispatch($content);
            exit;
        }
    }
    
    public function _end()
    {
        ComHTML::dispatch();
        ComCacheFile::set('index'.'index', ComHTML::getContent(), 30000);
    }
    
    public function indexAction()
    {
        ComHTML::load('index');
        ComHTML::meta('author', 'Ivan Shibkikh');
        ComHTML::title('Туристические услуги');
        
        $records = ComDBConnection::query('select f.id, f.title, f.src, p.url from index_frame f, pages p where f.active = 1 and f.link_id = p.id order by f.id desc');
        $frames = '';
        $i=0;
        
        foreach ($records as $rec)
        {
            $frames .= '<a href="/offers/'.$rec->url.'"><img class="indeximage" id="image_'.$i.'" src="/img/'.$rec->src.'" alt="'.$rec->title.'" onload="resizing_pictures(this,937,588,\'cnow\');"></a>';
            $i++;
        }
        ComHTML::setVar('FRAMES', $frames);
        
        $records = ComDBConnection::query('select f.id, f.title, f.src, p.url from index_baner f, pages p where f.active = 1 and f.link_id = p.id order by f.id desc');
        $frames = '';
        $i=0;
        foreach ($records as $rec)
        {
            $frames .= '<a id="gallery_'.$i.'" class="gallery_item item_301" rel="gallery" title="'.$rec->title.'" href="/offers/'.$rec->url.'"><img onload="resizing_pictures(this,325,200,\'cnow\');" src="/img/'.$rec->src.'" alt="'.$rec->title.'"></a>';
            $i++;
        }
        ComHTML::setVar('BANERS', $frames);
    }
}

?>
