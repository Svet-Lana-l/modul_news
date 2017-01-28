<?php

class View
{
    protected $data;

    protected $path;

    protected $news;

    public static function getDefaultViewPach(){
        $router = App::getRouter();
        if (!$router){
            return false;
        }
        $controller_dir = $router->getController();
        $template_name = $router->getMethodPrefix(). $router->getAction(). '.html';
       // $template_name = $router->getMethodPrefix(). $router->getAction(). '.tpl';
//echo $template_name;
        return VIEW_PATH.DS.$controller_dir.DS.$template_name;

    }

    public function __construct($data = array(), $path = null, $news = array())
    {

        if (!$path){
            $path = self::getDefaultViewPach();
        }
        // echo '<pre>';
        // print_r(debug_backtrace());
       // echo '<br>777'. $path;
      //   echo '</pre>';
        if (!file_exists($path)) {
            throw new Exception('Template does not exist'.$path);
        }
       // print_r($data);
        $this->data = $data;
        $this->path = $path;
       $this->news = $news;
//        echo '<pre>';
//        var_dump($news);
//        echo '</pre>';
    }

    public function render() {
        $data = $this->data;
        $news =$this->news;
//        echo '<pre>';
//        var_dump($news);
//        echo '</pre>';

        ob_start();
        include ($this->path);
        $content = ob_get_clean();
//print_r($content);
        return $content;

    }

}