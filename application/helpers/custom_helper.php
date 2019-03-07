<?php


/**
 * Formats $_FILES array that accepts multiple files
 */
function format_multiple_files($files){
    $result = array(); 
    foreach($files as $key1 => $value1) 
        foreach($value1 as $key2 => $value2) 
            $result[$key2][$key1] = $value2; 
    return $result; 
}

/**
 * Formats 01/31/2019 11:00 AM to ISO8601 (for sql saving)
 */
function format_date_and_time_for_sql($datetimestring,$format = "m/d/Y H:i:s"){
    $dt = new DateTimeZone('Asia/Hong_Kong');
    return DateTime::createFromFormat($format , $datetimestring, $dt)->format(DateTime::ISO8601);
}

/**
 * Formats date from db to desired date output format
 * returns a string
 */
function format_datetime_string($datetimestring,$output_format,$current_format = 'Y-m-d H:i:s'){
    return DateTime::createFromFormat($current_format,$datetimestring)->format($output_format);
}


/**
 * sauce https://stackoverflow.com/questions/3109978/display-numbers-with-ordinal-suffix-in-php
 */
function ordinalSuffix( $n )
{
  return date('S',mktime(1,1,1,1,( (($n>=10)+($n>=20)+($n==0))*10 + $n%10) ));
}

function isPageActive($page_name) // client side
{
    $ci =& get_instance();
    if((strtolower($ci->uri->segment(1))) == (strtolower($page_name))){
        return "active";
    }
    return "";
}

function isActive($uri_name){ //back end side
    $ci =& get_instance();

    if(is_array($uri_name)){
       if(in_array($ci->uri->segment(1),$uri_name)){
           return ['active','display: block;'];
       }
       return ["",""];
    }


    if($uri_name == $ci->uri->segment(1)){
        return "active";
    }
}

/** SOURCE: https://snippets.webaware.com.au/snippets/simple-url-cleanser-in-php/
* reduce rich character set string to URL-compatible string
* @param string $text original string
* @return string
*/
function stringForURL($text) {
    // replace accented characters with unaccented characters
    $newText = iconv('UTF-8', 'ASCII//TRANSLIT', $text);
 
    // remove unwanted punctuation, convert some to '-'
    static $punc = array(
        // remove
        "'" => '', '"' => '', '`' => '', '=' => '', '+' => '', '*' => '', '&' => '', '^' => '', '' => '',
        '%' => '', '$' => '', '#' => '', '@' => '', '!' => '', '<' => '', '>' => '', '?' => '',
        // convert to minus
        '[' => '-', ']' => '-', '{' => '-', '}' => '-', '(' => '-', ')' => '-',
        ' ' => '-', ',' => '-', ';' => '-', ':' => '-', '/' => '-', '|' => '-'
    );
    $newText = strtr($newText, $punc);
 
    // clean up multiple '-' characters
    $newText = preg_replace('/-{2,}/', '-', $newText);
 
    // remove trailing '-' character if string not just '-'
    if ($newText != '-')
        $newText = rtrim($newText, '-');
 
    // return a URL-encoded string
    return rawurlencode($newText);
}

function shortVer($string,$num_length)
{
    return strlen($string) > $num_length ? substr($string,0,$num_length)."..." : $string;
}