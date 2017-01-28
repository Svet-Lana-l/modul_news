<?php

class DB
{
    protected $connection;

    public function __construct($host, $user, $password, $db_mame)
    {
        $this->connection = new mysqli($host, $user, $password, $db_mame);
        $this->query('SET NAMES UTF8');

        if (mysqli_connect_error()) {
            throw new Exception('Could not conection with DB');
        }
    }

    public function query($sql) {
        if (!$this->connection){
            return false;
        }

        $resalt = $this->connection->query($sql);
//        echo '<pre>';
//       var_dump($resalt);
//        echo '</pre>';

        if (mysqli_error($this->connection)) {
            throw new Exception(mysqli_error($this->connection));
        }

        if (is_bool($resalt)){
            return $resalt;
        }
        $data = array();

        while($row = mysqli_fetch_assoc($resalt)) {
            $data[] = $row;
        }
//        echo '<pre>';
//  var_dump($data);
//       echo '</pre>';

        return $data;
    }

    public function escape($str){
        return mysqli_escape_string($this->connection, $str);
    }

    // Last insert number
    public function insertId(){
        return mysqli_insert_id($this->connection);
    }
}