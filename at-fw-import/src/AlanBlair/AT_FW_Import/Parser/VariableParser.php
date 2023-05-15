<?php
namespace AlanBlair\AT_FW_Import\Parser;

use Advanced_Themer_Bricks\AT__Helpers;
use AlanBlair\AT_FW_Import\App\AppController;


class VariableParser
{

    private $_url;
    private $_original_css;
    private $_transient_name;

    public function __construct($url)
    {
        $this->_url  = trim($url);
        $this->_transient_name = 'atfwi_url_parse_' .md5($url);
    }

    /**
     * Parse CSS from a URL
     *
     * CSS Markup:
     *  @return array
     * @throws \ErrorException
     *  @at-category: Name
     * followed by CSS vars
     *
     * Output Format
     * [
     *  [
     *      'label' => 'Category Label',
     *      'items => ['var1','var2]
     *  ]
     * ]
     *
     */
    public function  parse()
    {
        /* Debounce multiple calls on a single page load */
        $result = get_transient($this->_transient_name);
        if($result){ return $result; }

        if(empty($this->_url)){ return ;}

        $this->_original_css = AT__Helpers::read_file_contents($this->_url);
        if(false === $this->_original_css){ return; }

        $current_category_array = null;
        $full_array = [];

        $arr = explode("\n", $this->_original_css);
        foreach ($arr as $line){
            $type = null;
            $line = trim($line);

            if(str_contains($line, '@at-category')){
                $type = 'start';
            }elseif (preg_match('/^(--.*):/i', $line)){
                $type = 'var';
            }elseif (str_contains($line, '@at-end')){
                /* If there is already a parsed set, add to the collection */
                if($current_category_array ){
                    $full_array[] = $current_category_array;
                }
                break; /* End processing */
            }

            if(null === $type) { continue; } //Not a line we are interested in

            switch($type){
                case 'start':
                    /* If there is already a parsed set, add to the collection */
                    if($current_category_array ){
                        $full_array[] = $current_category_array;
                    }
                    $category = $this->_extract_category_name($line);
                    $current_category_array = ['label'=>$category, 'items'=>[]];
                    break;

                case 'var':
                    $var = $this->_extract_variable_name($line);
                    $current_category_array['items'][] = $var;
                    break;

                default:
                    break;
            }
        }

        AppController::get_instance()->logger->debug(__METHOD__ . 'Parsed  Variables for ' . $this->_url);

        set_transient($this->_transient_name, $full_array, 5);

        return $full_array;
    }

    private function _extract_category_name($line){
        if(preg_match('/\@at-category\:(.*)/i', $line, $matches)) {
           return trim($matches[1]);
        }
    }

    private function _extract_variable_name($line){
        $line = trim($line);
        if(preg_match('/^(--.*):/i', $line, $matches)) {
           return trim($matches[1],'-');
        }
    }

}