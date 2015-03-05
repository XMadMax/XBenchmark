<?php 
/** 
 * Program: XBenchmark 
 * Description: Benchmark trace & log any php 
 * Author: Xavier Perez 
 * Version: 1.0 
 * License: Freeware 
**/ 

/** 
 * INSTALL 
 * 
 * Copy this php anywhere on your system 
 * 
 * ---------------------- 
 * Method 1 (For any PHP) 
 * ---------------------- 
 * Modify your php.ini: 
 * 
 * auto_prepend_file = /absolute/path/to/XBenchmark.php 
 * 
 * ---------------------- 
 * Method 2 (For only a virtual host 
 * ---------------------- 
 * Modify the .htaccess file under your DOCUMENT_ROOT dir, add: 
 * 
 * php_value auto_prepend_file /absolute/path/to/XBenchmark.php 
 * 
 * ---------------------- 
 * Method 3 (For only one PHP) 
 * ---------------------- 
 * Modify your PHP file, put on top: 
 * 
 * include_once "/absolute/path/to/XBenchmark.php"; 
 * 
 * 
 * In any case, verify you have permissions on the XBENCHMARK_LOGS_DIR specified 
 * 
 * After apache restart (only in "Method 1" needed), you will have all logs saved under XBENCHMARK_LOGS_DIR/HOST 
 * 
 */ 

if (!defined('XBENCHMARK_LOGS_DIR')) 
    define('XBENCHMARK_LOGS_DIR',__DIR__.'/log'); 
$MARKER['start'] = microtime(); 

class XBenchmark 
{ 
    public static function log() 
    { 
        global $MARKER; 
        $t1 = $MARKER['start']; 
        $t2 = microtime(); 

        list($sm, $ss) = explode(' ', $t1); 
        list($em, $es) = explode(' ', $t2); 

        $t3 = number_format(($em + $es) - ($sm + $ss), 4); 

        $REMOTE_ADDR = isset($_SERVER['REMOTE_ADDR'])?$_SERVER['REMOTE_ADDR']:'localhost'; 

        if(isset($_SERVER["HTTP_X_FORWARDED_FOR"]) ) 
            $REMOTE_ADDR = $_SERVER["HTTP_X_FORWARDED_FOR"]; 
        elseif (isset($_SERVER["HTTP_CLIENT_IP"]) ) 
            $REMOTE_ADDR= $_SERVER["HTTP_CLIENT_IP"]; 
        
        if(isset($_SERVER["HTTP_HOST"]) ) 
            $HOST = $_SERVER["HTTP_HOST"]; 
        else 
            $HOST = 'localhost'; 
            
        if (isset($_SERVER['REQUEST_URI'])) 
            $URI = $_SERVER['REQUEST_URI']; 
        else 
            $URI = json_encode($argc); 

        if (isset($_REQUEST)) 
            $REQUEST = json_encode($_REQUEST); 
        else 
            $REQUEST = json_encode($argv); 

        $MAX_RAM = (memory_get_peak_usage(true)/1024/1024); 
        
        @mkdir(XBENCHMARK_LOGS_DIR.'/'.$HOST,0777,true); 
        
        if ( $fp = fopen(XBENCHMARK_LOGS_DIR.'/'.$_SERVER['HTTP_HOST'].'/'.date('Y-m-d').'.log', 'a+b')) 
        { 
            if (flock($fp, LOCK_EX)) 
            { 
                fwrite($fp, date('Y-m-d H:i:s')." || RUN_TIME: ".number_format($t3,4)." || MAX_RAM: ".$MAX_RAM." MB || URL: ".$URI." || PARAMS: ".$REQUEST." || IP:".$REMOTE_ADDR."\n"); 
                flock($fp, LOCK_UN); 
            } 
            fclose($fp); 
        } 
    } 
} 

register_shutdown_function(function () { 
    XBenchmark::log(); 
}); 
