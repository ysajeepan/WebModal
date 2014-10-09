<?php
/* 
 * 3:30 PM 10/7/2014
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class HTMLModal
{
    private $isBodyStart = false;
    function __construct()
    {
        
    }
    function start()
    {
        echo "<!DOCTYPE HTML>\n<html>\n<head>\n<meta charset=\"utf-8\">\n";
    }
    function end()
    {
        if($this->isBodyStart) $this->bodyEnd ();
        echo '</html>';
    }
    function title($text)
    {
        echo "<title>{$text}</title>\n";
    }
    function bodyStart()
    {
        $this->isBodyStart = true;
        echo "</head><body>";
    }
    function bodyEnd()
    {
        echo "</body>";
    }
    function meta($data)
    {
        echo '<meta';
        foreach($data as $attr=>$val)
        {
            echo " {$attr}=\"{$val}\"";
        }
        echo '>';
    }
    function css($src)
    {
        echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"$src\">\n";
    }
    function script($src, $attr = array())
    {
        echo "<script src=\"{$src}\" type=\"text/javascript\"></script>\n";
    }
    function tag($tagName, $content, $attr = array())
    {
        return "<{$tagName}" . $this->attrString($attr) . ">{$content}</{$tagName}>";
    }
    private function attrString(Array $attr)
    {
        $attributes = "";
        foreach($attr as $at=>$atval)
        {
            $attributes .= " {$at}=\"{$atval}\"";
        }
        return $attributes;
    }
}
class HTMLModalTable extends HTMLModal
{
    private $attr, $head, $body, $isStartBody;
    function __construct($attr = array())
    {
        $this->head = "";
        $this->body = "";
        $this->attr = $attr;
        $this->isStartBody = true;
    }
    function row()
    {
        if($this->isStartBody)
        {
            $html = $this->setRowDeifiner("td", func_get_args());
            $this->body .= $html;
        }
        else
        {
            $html = $this->setRowDeifiner("th", func_get_args());
            $this->head .= $html;
        }
        
        return $html;
    }
    function body()
    {
        $this->isStartBody = true;
    }
    function column()
    {
        $this->isStartBody = false;
        $html = $this->setRowDeifiner("th", func_get_args());
        $this->head .= $html;
        return $html;
    }
    function html()
    {
        $html = "";
        if($this->head) $html .= $this->tag("thead", $this->head);
        if($this->body) $html .= $this->tag("tbody", $this->body);
        return $this->tag("table", $html, $this->attr);
    }
    private function setRowDeifiner($tag, $args)
    {
        //(Default $tag, $args)
        $html = "<tr>";
        foreach($args as $item)
        {
            if(is_array($item))
            {
                $len = count($item);
                switch ($len)
                {
                    case 1 :
                        $html .= $this->tag($tag, $item[0]);
                    break;
                    case 2 :
                        $html .= $this->tag($item[0], $item[1]);
                    break;
                    case 3 :
                        $html .= $this->tag($item[0], $item[1], $item[2]);
                    break;
                }
            }
            else
            {
                $html .= $this->tag($tag, $item);
            }
        }
        $html .= "</tr>";
        return $html;
    }
}
