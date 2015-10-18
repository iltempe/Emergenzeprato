<?php

/**
 * SIMPLE-Scraper-HTML-PHP
 *
 * PHP version 5.3
 *
 *  @category HTML_Tools
 *  @package  HTML
 *  @author   https://github.com/botero
 *  @license  https://github.com/botero/SIMPLE-Scraper-HTML-PHP/blob/master/licence.txt GPL V3 License
 *  @link     https://github.com/botero/SIMPLE-Scraper-HTML-PHP
 *
 */

/**
 * this class is a simple and fast, with no dependency, scraping tool for XML
 * and HTML files, require PHP 5.3 or later and it's PSR1 standard compliant
 *
 *  @category HTML_Tools
 *  @package  HTML
 *  @author   https://github.com/botero
 *  @license  https://github.com/botero/SIMPLE-Scraper-HTML-PHP/blob/master/licence.txt GPL V3 License
 *  @link     https://github.com/botero/SIMPLE-Scraper-HTML-PHP
 *
 */


class Scraper implements ScraperInterface
{
    protected $dom;
    protected $property;
    protected $removeNull = true;
    protected $rules;

    public function __construct()
    {
        libxml_use_internal_errors(true);
    }
    
    protected function getChildrenByTag(DOMElement $element, $tag)
    {
        $result = array();

        foreach ($element->childNodes as $child) {

            if ($child instanceof DOMElement && $child->tagName == $tag) {
                $result[] = $child;
            }
        }
        return $result;
    }
    
    protected function getNodeById($id)
    {
        $node = $this->dom->getElementById($id);

        if (empty($this->rules) && !is_null($node)) {
            return array ( trim($node->nodeValue) );
        }

        return $node;
    }
    
    protected function getNodeValue($node)
    {
        $value = ($this->property) ?
              $node->getAttribute($this->property): trim($node->nodeValue);

        return $value;
    }
    
    protected function parse($nodes, $rules, $result = null)
    {
        $nodes = $this->getChildrenByTag($nodes, $rules[0]);
        array_shift($rules);

        foreach ($nodes as $node) {
            
            $aux = empty($rules) ? 
                    $this->getNodeValue($node) : $this->parse($node, $rules);
          
            if(!is_null($aux) || !$this->removeNull ) { $result[] = $aux; } 
        }
        
        if(is_array($result[0]) && sizeof($result) == 1 && $this->removeNull ) { 
            $result = $result[0]; 
        }
        
        return $result;
    }
    
    protected function setHTML($html)
    {
        $dom = new DOMDocument;
        $dom->loadHTML($html);
        $this->dom = $dom;
    }

    protected function setRules($string)
    {
        if( substr($string, 0, 1) !== '#') {
                throw new Exception ('# selector is required ');
        }
        
        $this->removeNull = substr($string, '-1') == '*'  ? false : true;
        $this->property   = strpos($string, ':')  == true ? true  : false;
        
        $string = substr($string, 1);
        $string = ($this->removeNull) ?  $string : substr($string, 0, -1);
        
        $array = explode(':', $string);
        $rules = explode(' ', current($array));
        
        $this->rules = $rules;
        $this->property = next($array);
    }

    public function execute($rules, $html)
    {
        $this->setHTML($html);
        $this->setRules($rules);
        
        $id = current($this->rules);
        array_shift($this->rules);
        $node = $this->getNodeById($id);

        if (empty($this->rules) || is_null($node)) {
            return $node;
        }

        return  $this->parse($node, $this->rules);
        
    }
}