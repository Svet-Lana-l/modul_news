<?php
//namespace My_MVC;
//require_once (ROOT.DS.'config'.DS.'config.php');

//require_once (ROOT.'/vendor/smarty/smarty/libs/Smarty.class.php');
require_once (ROOT.DS.'vendor'.DS.'autoload.php');
//echo '<pre>';
//print_r(debug_backtrace());
//echo '</pre>';
$smarty = new Smarty();
$smarty->setTemplateDir(ROOT.'/views');

   spl_autoload_register( function ($classname) {
        //echo 456;
       require_once (ROOT.DS.'config'.DS.'config.php');
        $lib_path = ROOT.DS.'lib'.DS.strtolower($classname).'.class.php';
     // echo '<br>'. $lib_path . '1<br>';
        $controller_path = ROOT.DS.'controllers'.DS.str_replace('controller', '', strtolower($classname)).'.controller.php';
      //echo '<br>'.$controller_path.'<br>';
        $model_path = ROOT.DS.'models'.DS.strtolower($classname).'.php';

        if (file_exists($lib_path)) {
            require_once ($lib_path);
           // echo '<br>'. $lib_path . '<br>';
        } elseif (file_exists($controller_path)) {
            require_once ($controller_path);
           //echo '<br>6' . $controller_path.'<br>';
        } elseif (file_exists($model_path)) {
            require_once ($model_path);
        } else {
           //echo '<pre>';
           //print_r(debug_backtrace());
           //  echo '</pre>';
            throw new Exception('Not found class ' . $classname);
        }
    });

    function __($key, $default_value = '') {
       return Lang::get($key, $default_value);
    }