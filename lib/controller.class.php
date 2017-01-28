<?php

class Controller
{
    protected $data;

    protected $news;

    protected $reklama;

    protected $model;

    protected $param;

    /**
     * @return mixed
     */
    public function getData()
    {

        return $this->data;


    }
    /**
     * @return mixed
     */
    public function getNews()
    {
        return $this->news;
    }

    /**
     * @return mixed
     */
    public function getReklama()
    {
        return $this->reklama;
    }

    /**
     * @return mixed
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @return mixed
     */
    public function getParams()
    {
        return $this->param;
    }

    public function __construct($data = array(), $news = array(), $reklama = array())
    {
        $this->data = $data;
        $this->data = $news;
        $this->reklama = $reklama;

        $this->param = App::getRouter()->getParams();
    }

}