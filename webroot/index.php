<?php
/**
 * Created by PhpStorm.
 * User: Sveta
 * Date: 05.12.2016
 * Time: 13:36
 */
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(dirname(__FILE__)));
define('VIEW_PATH', ROOT.DS.'views');

require_once (ROOT.DS.'lib'.DS.'init.php');


session_start();
//Session::setFlash('Test flash message');

try {

    App::run($_SERVER['REQUEST_URI']);

} catch (Exception $e) {

    echo $e->getMessage();
}
$test = App::$db ->query('SELECT * FROM `pages`');
//echo '<pre>';
//print_r($test);