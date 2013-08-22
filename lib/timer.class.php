<?php
/**
 * @author  ak
 * @since   22.08.13 16:19
 */

class timer {

    static $time;

    public static function start(){
        $microtime  = microtime();
        $microsecs  = substr($microtime, 2, 8);
        $secs       = substr($microtime, 11);
        self::$time = "$secs.$microsecs";
    }

    public static function end(){
        $microtime = microtime();
        $microsecs = substr($microtime, 2, 8);
        $secs      = substr($microtime, 11);
        $endTime   = "$secs.$microsecs";
        return round(($endTime - self::$time),4);
    }
}