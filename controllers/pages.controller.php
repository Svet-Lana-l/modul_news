<?php

class PagesController extends Controller
{
   // protected $news;
    public function __construct( $data = array(), $news = array(), $reklama = array())
    {
        parent::__construct($data, $news, $reklama);
        $this->model = new Page();
    }

    public function index() {
        $this->data['pages'] = $this->model->getList();
        foreach ($this->data['pages'] as $page_tmp){
            $this->news[$page_tmp['id']] = $this->model->getListNews($page_tmp['id']);
        }
        $this->reklama = $this->model->getListReklama();
//        echo '<pre>';
//       // print_r(debug_backtrace());
//        var_dump($this->reklama);
//        echo '</pre>';
    }

    public function view(){

        $param = App::getRouter()->getParams();

        if (isset($param[0])) {
            $alias = strtolower($param[0]);
            $this->data['pages'] = $this->model->getByAlias($alias);
            $this->news[$this->data['pages']['id']] = $this->model->getListNews($this->data['pages']['id']);
             //echo '<pre>';
           // print_r(debug_backtrace());

            // echo '</pre>';

        }


    }
    public function view_news(){

        $param = App::getRouter()->getParams();

        if (isset($param[1])) {
            $alias = strtolower($param[0]);
            $alias_n = strtolower($param[1]);
            $this->data['pages'] = $this->model->getByAlias($alias);
            $this->news[$this->data['pages']['id']][$alias_n] = $this->model->getByNews($this->data['pages']['id'], $alias_n);
           // echo 1;
           // echo '<pre>';
            // print_r(debug_backtrace());
            //var_dump($this->news);
            //echo '</pre>';

        }

    }
    public  function  view_news_teg(){

        $param = App::getRouter()->getParams();

        if (isset($param[0])) {
            $teg = strtolower($param[0]);
            $this->data['pages'] = $this->model->getList();
           // $this->data['pages'] = $this->model->getByAlias($alias);
            $this->news[$teg] = $this->model->getByTeg($teg);
//            echo '<pre>';
//            // print_r(debug_backtrace());
//            var_dump($this->news);
//             echo '</pre>';

        }

    }

    public function admin_index(){
        $this->data['pages'] = $this->model->getList();
    }

    public function admin_news(){
        if (isset($this->param[0])){
            $id = strtolower($this->param[0]);

            $this->data['pages'] = $this->model->getByID($id);

            $this->news[$this->data['pages']['id']] = $this->model->getListNews($this->data['pages']['id']);

        }else {

            Session::setFlash('Wrong page id.');
            Route::redirect('/admin/pages');
        }

    }

    public function admin_add() {
        if ($_POST) {
            $result = $this->model->save($_POST);
            if ($result) {
                Session::setFlash('Page was saved.');
            }else {
                Session::setFlash('Error');
            }
            Route::redirect('/admin/pages');
        }
    }

    public function admin_add_news() {
        if (isset($this->param[0])) {
            $pages_id = strtolower($this->param[0]);
           // echo $pages_id;
        }
        if ($_POST) {
            $result = $this->model->save_news($_POST, $pages_id);
            if ($result) {
                Session::setFlash('News was saved.');
            }else {
                Session::setFlash('Error');
            }
            Route::redirect('/admin/pages/news/'. $pages_id);
        }
        if (isset($this->param[0])){
            $this->data['pages'] = $this->model->getById($this->param[0]);
        }else {

            Session::setFlash('Wrong page id.');
            Route::redirect('/admin/pages');
        }
    }

    public function admin_edit() {

        if ($_POST) {
            $id = isset($_POST['id']) ? $_POST['id'] : null;
            $result = $this->model->save($_POST, $id);
            if ($result) {
                Session::setFlash('Page was saved.');
            }else {
                Session::setFlash('Error');
            }
            Route::redirect('/admin/pages');
        }

        if (isset($this->param[0])){
            $this->data['pages'] = $this->model->getById($this->param[0]);
        }else {

            Session::setFlash('Wrong page id.');
            Route::redirect('/admin/pages');
        }


    }
    public function admin_edit_news() {

        if ($_POST) {
            $id = isset($_POST['id']) ? $_POST['id'] : null;
            $pages_id = isset($_POST['pages_id']) ? $_POST['pages_id'] : null;
           // echo $id;
           // die;
            $result = $this->model->save_news($_POST, $pages_id , $id);
            if ($result) {
                Session::setFlash('Page was saved.');
            }else {
                Session::setFlash('Error');
            }
            Route::redirect('/admin/pages/news/' . $pages_id);
        }
        if (isset($this->param[1])){
            $this->data['pages'] = $this->model->getById($this->param[0]);
            $this->news[$this->data['pages']['id']] = $this->model->getByIdNews($this->param[0], $this->param[1]);
        }else {

            Session::setFlash('Wrong page id.');
            Route::redirect('/admin/pages');
        }
//        if (isset($this->param[0])){
//            $this->data['pages'] = $this->model->getById($this->param[0]);
//        }else {
//
//            Session::setFlash('Wrong page id.');
//            Route::redirect('/admin/pages');
//        }
    }
    public function admin_delete() {
        if (isset($this->param[0])) {
            $result = $this->model->delete($this->param[0]);

            if ($result) {
                Session::setFlash('Page was deleted.');
            }else {
                Session::setFlash('Error');
            }
        }
        Route::redirect('/admin/pages');
    }
    public function admin_delete_news() {
        if (isset($this->param[0])) {

            $result = $this->model->delete_news($this->param[0]);

            if ($result) {
                Session::setFlash('Page was deleted.');
            }else {
                Session::setFlash('Error');
            }
        }
        Route::redirect('/admin/pages/news');
    }
}