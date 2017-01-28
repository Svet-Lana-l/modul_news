<?php

class Page extends Model
{
    public function getList($only_publish = false) {
        $sql = 'select * from pages  WHERE 1';

        if ($only_publish) {
            $sql .= 'and is_publish = 1';
        }
//
        return $this->db->query($sql);
    }
    public function getListNews($pages_id){
        $sql = "select * from news  WHERE pages_id = '{$pages_id}' ORDER  BY news.date DESC ";
        return $this->db->query($sql);
    }
    public function getByNews($pages_id, $alias_n){
        $sql = "select * from news  WHERE pages_id = '{$pages_id}' AND alias_n = '{$alias_n}' limit 1";
        return $this->db->query($sql);
    }
    public function getByAlias($alias) {
        $alias = $this->db->escape($alias);
        $sql = "select * from pages WHERE alias = '{$alias}' limit 1";
        $result = $this->db->query($sql);
        return isset($result[0]) ? $result[0] : null;
    }
    public function getByIdNews($pages_id, $id){
        $sql = "select * from news  WHERE pages_id = '{$pages_id}' AND id = '{$id}' limit 1";
        return $this->db->query($sql);
    }

    public function getById($id) {
        $id =(int)$id;
        $sql = "select * from pages WHERE id = '{$id}' limit 1";
        $result = $this->db->query($sql);
        return isset($result[0]) ? $result[0] : null;
    }

    public function getByTeg($teg) {
        $teg = $this->db->escape($teg);
        $sql = "select * from news WHERE locate('{$teg}',teg) > 0 ";
        return $this->db->query($sql);
    }

    public function save($data, $id = null) {
        if (!isset($data['alias']) || !isset($data['title']) || !isset($data['content'])) {
            return false;
        }

        $id = (int)$id;
        $alias = $this ->db->escape($data['alias']);
        $title =$this->db->escape($data['title']);
        $content = $this->db->escape($data['content']);
        $is_published = isset($data['is_published']) ? 1 : 0;

        if (!$id) { //add new record
            $sql = "
            insert into pages
            set alias = '{$alias}',
                title = '{$title}',
                content = '{$content}',
                is_published = '{$is_published}';
            ";
        } else { //update record
            $sql = "
            update pages
            set alias = '{$alias}',
                title = '{$title}',
                content = '{$content}',
                is_published = '{$is_published}'
             where id = '{$id}'
            ";

        }
        return $this->db->query($sql);
    }

    public function delete($id) {
        $id = (int)$id;
        $sql = "delete from pages where id = {$id}";
        return $this->db->query($sql);
    }

    public function delete_news($id) {
        $id = (int)$id;
        $sql = "delete from news where id = {$id}";
        return $this->db->query($sql);
    }

    public function save_news($news, $pages_id, $id = null ) {
        if (!isset($news['alias_n']) || !isset($news['title_n']) || !isset($news['content']) || !isset($news['teg'])) {
            return false;
        }

        $id = (int)$id;
        $pages_id = (int)$pages_id;
        $alias_n = $this ->db->escape($news['alias_n']);
        $title_n =$this->db->escape($news['title_n']);
        $content = $this->db->escape($news['content']);
        $analitic = isset($news['analitic']) ? 1 : 0;
        $teg = $this->db->escape($news['teg']);
        $photo = $this->db->escape($news['photo']);
        $date = isset($news['date']) ? $news['date'] : date("Y-m-d H:i:s");

        if (!$id) { //add new record
            $sql = "
            insert into news
            set pages_id = '{$pages_id}',
                alias_n = '{$alias_n}',
                title_n = '{$title_n}',
                content = '{$content}',
                analitic = '{$analitic}',
                date = '{$date}',
                teg = '{$teg}',
                photo = '{$photo}'              
                ;
            ";
        } else { //update record
            $sql = "
            update news
            set pages_id = '{$pages_id}',
                alias_n = '{$alias_n}',
                title_n = '{$title_n}',
                content = '{$content}',
                analitic = '{$analitic}',
                date = '{$date}',
                teg = '{$teg}',
                photo = '{$photo}'
             where id = '{$id}'
            ";

        }
        return $this->db->query($sql);
    }
}