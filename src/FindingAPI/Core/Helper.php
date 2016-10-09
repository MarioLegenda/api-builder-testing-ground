<?php

namespace FindingAPI\Core;

use Carbon\Carbon;

class Helper
{
    public static function compareFloatNumbers($float1, $float2, $operator='=')
    {
        // Check numbers to 5 digits of precision  
        $epsilon = 0.00001;

        $float1 = (float)$float1;
        $float2 = (float)$float2;

        switch ($operator)
        {
            // equal  
            case "=":
            case "eq":
            {
                if (abs($float1 - $float2) < $epsilon) {
                    return true;
                }
                break;
            }
            // less than  
            case "<":
            case "lt":
            {
                if (abs($float1 - $float2) < $epsilon) {
                    return false;
                }
                else
                {
                    if ($float1 < $float2) {
                        return true;
                    }
                }
                break;
            }
            // less than or equal  
            case "<=":
            case "lte":
            {
                if (self::compareFloatNumbers($float1, $float2, '<') || self::compareFloatNumbers($float1, $float2, '=')) {
                    return true;
                }
                break;
            }
            // greater than  
            case ">":
            case "gt":
            {
                if (abs($float1 - $float2) < $epsilon) {
                    return false;
                }
                else
                {
                    if ($float1 > $float2) {
                        return true;
                    }
                }
                break;
            }
            // greater than or equal  
            case ">=":
            case "gte":
            {
                if (self::compareFloatNumbers($float1, $float2, '>') || self::compareFloatNumbers($float1, $float2, '=')) {
                    return true;
                }
                break;
            }
            case "<>":
            case "!=":
            case "ne":
            {
                if (abs($float1 - $float2) > $epsilon) {
                    return true;
                }
                break;
            }
            default:
            {
                die("Unknown operator '".$operator."' in compareFloatNumbers()");
            }
        }

        return false;
    }
    /**
     * @param \DateTime $dateTime
     */
    public static function convertToGMT(\DateTime $dateTime)
    {
        return gmdate('Y-m-d\TH:i:s.', $dateTime->getTimestamp()).substr($dateTime->getTimestamp(), 0, 3).'Z';
        $dateTime = Carbon::parse('2019-01-01 19:09:02');

        $currentTime = explode(" ", microtime());
        $currentTime = $currentTime[1];
        $futureTime = $dateTime->getTimestamp(); // insert your date here
        $microtime = ($futureTime - $currentTime) / 1000;
        var_dump($microtime);
        var_dump(microtime(true));
        var_dump(microtime());
        die();
        $tMicro = sprintf("%03d", ($microtime - floor($microtime)) * 1000);


        return $gmtDate;
    }

    public static function udate($format, $timestamp=null) {
        $dateTime = new \DateTime('1.1.2019 13:23:48');


        var_dump($timeRemaining);
        die();

        // treba mi gmdate

        if (!isset($timestamp)) $timestamp = microtime();
        // microtime(true)
        if (count($t = explode(" ", $timestamp)) == 1) {
            list($timestamp, $usec) = explode(".", $timestamp);
            $usec = "." . $usec;
        }
        // microtime (much more precise)
        else {
            $usec = $t[0];
            $timestamp = $t[1];
        }
        // 7 decimal places for "u" is maximum
        $date = new \DateTime(date('Y-m-d H:i:s' . substr(sprintf('%.7f', $usec), 1), $timestamp));
        return $date->format($format);
    }
}