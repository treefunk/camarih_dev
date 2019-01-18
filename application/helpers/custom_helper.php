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
function format_date_and_time_for_sql($datetimestring){
    $dt = new DateTimeZone('Asia/Hong_Kong');
    return DateTime::createFromFormat('m/d/Y h:i A' , $datetimestring, $dt)->format(DateTime::ISO8601);
}

/**
 * Formats date from db to desired date output format
 * returns a string
 */
function format_datetime_string($datetimestring,$output_format,$current_format = 'Y-m-d H:i:s'){
    return DateTime::createFromFormat($current_format,$datetimestring)->format($output_format);
}