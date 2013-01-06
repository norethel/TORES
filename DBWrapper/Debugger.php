<?php

final class DBG
{
    const disabled = 0;
    const enabled = 1;

    private static $level = DBG::disabled;

    public static function setLevel($level)
    {
        self::$level = $level;
    }

    public static function log($class, $function, $text, $vars)
    {
        if (self::$level == DBG::enabled)
        {
            echo '<br>'.$class.'::'.$function.' => '.$text.'<br>';
            print_r($vars);
        }
    }
}

?>