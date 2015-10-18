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

interface ScraperInterface
{
    public function execute($rules, $html);

}
