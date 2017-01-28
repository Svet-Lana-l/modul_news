<?php

class Lang
{
    protected static $data;

    public static function load($lang_code)
    {
        $lang_path = ROOT.DS.'lang'.DS.strtolower($lang_code).'.php';

        if (file_exists($lang_path)) {
            self::$data = include ($lang_path);
            //echo '<pre>';
            //print_r(self::$data);
            // echo '</pre>';

        }else {
            throw new Exception('Lang file not found '.$lang_path);
        }
    }
    public function get($key, $default_value = '') {
        return isset(self::$data[strtolower($key)]) ? self::$data[strtolower($key)] : $default_value;
    }

}
