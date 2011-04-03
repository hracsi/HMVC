<?php

/**
 * HTML
 * 
 * Helper for html operations.
 * 
 * @copyright     Copyright 2010, Hracsi's MVC Project http://hracsi.net
 * @package       hmvc
 * @subpackage    hmvc.core.view.helpers.html
 * @since         hmvc (tm) v. 0.1.0.0
 * @version       hmvc (tm) v. 0.8.4.1
 * 
 */

class HTML
{
	public $docTypes = array(
		'html4-strict'    => '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd"><html>',
		'html4-trans'     => '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"><html>',
		'html4-frame'     => '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd"><html>',
        'html5'           => '<!DOCTYPE html><html>',
		'xhtml1-strict'   => '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"><html xmlns="http://www.w3.org/1999/xhtml">',
		'xhtml1-trans'    => '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml">',
		'xhtml1-frame'    => '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd"><html xmlns="http://www.w3.org/1999/xhtml">',
		'xhtml1.1'        => '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd"><html xmlns="http://www.w3.org/1999/xhtml">'
	);
	
    public function docType($type = 'xhtml1-trans')
    {
        if ( $type == 'xhtml1-strict' or $type == 'xhtml1-trans' or $type == 'xhtml1-frame' or $type == 'xhtml1.1' ) {
            define(END_TAG,'/');
        } else {
            define(END_TAG,'');
        }
        return $this->docTypes[$type] . "\r\n";
}
	
	public function title($title = '')
	{
		return '<title>' . START_TITLE . $title . ' ' . END_TITLE . '</title>' . "\r\n";
	}
    
    public function charset($charset = 'utf-8')
    {
        return self::meta('Content-Type', 'text/html; charset=' . $charset);
    } 
	
	public function meta($type, $content)
	{
		return '<meta http-equiv="' . $type . '" content="' . $content . '" />' . "\r\n";
	}
	
	public function css($name = 'all')
	{
        if ( $name == 'all' ) {
            $name = self::getFiles(CSS_LIB, 'css');
        }
        if ( is_array($name) ) {
            foreach($name as $css) {
                $files = $files . '<link href="/public/css/' . $css . '" rel="stylesheet" type="text/css" />' . "\r\n";
            }
            return $files;
        } else {
            return '<link href="' . '/public/css/' . $name . '" rel="stylesheet" type="text/css" />' . "\r\n";
        }
	}
    
    public function js($name = 'all') {
        if ( $name == 'all' ) {
            $name = self::getFiles(JS_LIB, 'js');
        }
        if ( is_array($name) ) {
            foreach($name as $js) {
                $files = $files . '<script type="text/javascript" src="/public/js/' . $js . '.js"></script>' . "\r\n";
            }
            return $files;
        } else {
            return '<script type="text/javascript" src="/public/js/' . $name . '"></script>' . "\r\n";
        }        
    }    
    
    protected function getHost($url) { 
        $parseUrl = parse_url(trim($url)); 
        return trim($parseUrl[host] ? $parseUrl[host] : array_shift(explode('/', $parseUrl[path], 2))); 
    }
    
    public function url($components = null, $full = false) {
        //getting the "pre" part
        if ( $components == null ) {
            $url = htmlspecialchars($_SERVER['REQUEST_URI']);
        } else {
            //putting together the url ex.: /post/view/1/test-link
            if ( is_array($components) ) {
        		foreach($components as $name => $value){
       				$url = $url . self::generatePrettyUrl($value) . '/';
        		}
        		$url = substr($url, 0, strlen($url)-1);
            } else {
                $url = $components;
            }
        }
        
        if ( $full ) {
            $url = 'http://' . $_SERVER['HTTP_HOST'] . '/' . $url;
        }
        return $url;
    }
	
	public function makeLink($title = '#', $components = null, $style = null, $confimation_text = null)
	{
        //making the url
        $url = self::url($components, true);
        
		//style
        foreach($style as $name => $value) {
            $styles = $name . '="' . $value .'" ';
        }
        
        //Confirmation Text
        if ( $confimation_text != null) {
            $confim = 'onclick="return confirm(' . $confimation_text . '); ';
        } else {
            $confim = '';
        }
        $link = '<a ' . $styles . ' href="' . $url . '" ' . $confim . ' >' . $title . '</a>';
		return $link; 
	}
	
	public function div($class, $text)
	{
		return '<div class="' . $class . '">' . $text . '</div>';
	}
    
    public function img($name, $properties) {
        $img = '<img src="/public/img/' . $name . '" ';
        //setting the size of the picture if it was not set
        if ( !in_array('height', $properties) or !in_array('width', $properties) ) {
            if ( file_exists('/public/img/' . $name) ) {
                $image_info = getimagesize('/public/img/' . $name);
                $img = $img . $image_info[3] . ' ';
            }
        }
        
        //giving the properties to the image
        foreach($properties as $attribute => $value) {
            if($attribute != 'url') {
                $img = $img . $attribute . '="' . $value . '" ';
            }
        }   
        
        $img = $img . END_TAG . '>';     
        
        //making the url if it's necessary
        if ( in_array('url', $properties) ) {
            $img = self::makeLink($img, $properties['url']);
        }
        return $img . "\r\n";
    }
    
    public function fetchTinyUrl($url)
    { 
    	$ch = curl_init(); 
    	$timeout = 5; 
    	curl_setopt($ch,CURLOPT_URL,'http://tinyurl.com/api-create.php?url='.$url[0]); 
    	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1); 
    	curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout); 
    	$data = curl_exec($ch); 
    	curl_close($ch); 
    	return '<a href="'.$data.'" target = "_blank" >'.$data.'</a>'; 
    }

/**
 * Transforming a text that you can put to an url.
 * 
 * @example $text ex.: 'helló világ oldal' -> $text = 'hello_vilag_oldal'
 * @param string $text That should be transformed.
 * @return string That is transformed.
 */
    private function generatePrettyUrl($text){ 
         $text = mb_strtolower($text, 'UTF-8'); 
         $text = str_replace('ő', 'o', $text); 
         $text = str_replace('ű', 'u', $text); 
         $text = mb_convert_encoding($text, 'ISO-8859-1', 'UTF-8'); 
         $text = strtr($text, utf8_decode('éáúíöüóõû'), 'eauiouoou'); 
         $text = preg_replace('/#/', 'sharp', $text); 
         $text = preg_replace('/%/', ' szazalek', $text); 
         $text = preg_replace('/\=/', 'egyenlo', $text); 
         $text = preg_replace('/\si\.?\s*$/', ' 1', $text); 
         $text = preg_replace('/\sii\.?\s*$/', ' 2', $text); 
         $text = preg_replace('/\siii\.?\s*$/', ' 3', $text); 
         $text = preg_replace('/(?![a-z0-9\s])./', '', $text); 
         $text = preg_replace('/\s\s+/', ' ', $text); 
         $text = preg_replace('/^\s|\s$/', '', $text); 
         $text = preg_replace('/\s/', '-', $text); 
          
         return $text; 
    }
    
    public function listdir($dir = CSS_LIB, $type)
    { 
        if (!is_dir($dir)) { 
            return false; 
        } 
        
        $files = array(); 
        self::listdiraux($dir, $files, $type); 
    
        return $files; 
    } 
    
    public function listdiraux($dir, &$files, $type) { 
        $handle = opendir($dir); 
        while (($file = readdir($handle)) !== false) { 
            if ($file == '.' || $file == '..') { 
                continue; 
            } 
            
            $filepath = $dir == '.' ? $file : $dir . '/' . $file; 
            if ( is_link($filepath) ) 
                continue; 
            if ( is_file($filepath) and strtolower(substr($file,-strlen($type))) == $type )
                $files[] = $file; 
            else if ( is_dir($filepath) ) 
                self::listdiraux($filepath, $files, $type); 
        }
        closedir($handle); 
    } 
    
    public function getFiles($dir, $type){
        $files = self::listdir($dir, $type);

        sort($files, SORT_LOCALE_STRING);
       return $files;
    }

}
