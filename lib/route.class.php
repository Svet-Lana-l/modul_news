<?php

class Route
{

    protected $uri;

    protected $controller;

    protected $action;

    protected $params;

    protected $route;

    /**
     * @return mixed
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * @return mixed
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @return mixed
     */
    public function getMethodPrefix()
    {
        return $this->method_prefix;
    }

    protected $language;

    protected $method_prefix;

    /**
     * @return mixed
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * @return mixed
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * @return mixed
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @return mixed
     */
    public function getParams()
    {
        return $this->params;
    }

   public function __construct($uri)
   {
      $this->uri = urldecode(trim($uri, '/'));


       $routes = Config::get('routes');
       $this->route = Config::get('default_route');
       $this->method_prefix = isset($routes[$this->route]) ? $routes[$this->route] : '';
       $this->language = Config::get('default_language');
       $this->controller = Config::get('default_controller');
       $this->action = Config::get('default_action');

       $uri_parts = explode('?' ,$this->uri);

       $path = $uri_parts[0];

       $parts_path = explode('/', $path);
       // array_shift($parts_path);

       if (count($parts_path)){

           //Get route or language at first element
           if (in_array(strtolower(current($parts_path)), array_keys($routes))){
               $this->route = strtolower(current($parts_path));
               $this->method_prefix = isset($routes[$this->route]) ? $routes[$this->route] : '';
               array_shift($parts_path);

           }elseif (in_array(strtolower(current($parts_path)), Config::get('languages'))) {
               $this->language = strtolower(current($parts_path));
               array_shift($parts_path);
           }
           //Get cotroller - next element
           if (current($parts_path)) {
               $this->controller = strtolower(current($parts_path));
               array_shift($parts_path);
           }
           //Get action - next element
           if (current($parts_path)) {
               $this->action = strtolower(current($parts_path));
               array_shift($parts_path);
           }
           //Get params - next element
           $this->params = $parts_path;
       }

      //echo '<pre>';
       //print_r($parts_path);

   }

   public function redirect($location){
       header("Location: $location");
   }


}