<?php
session_start();
include 'dbconfig.php';

class db extends dbconnect 
{
    private $conn; 
    public function __construct() 
    { 
       $dbcon = new parent(); 
       $this->conn = $dbcon->connect();
    }

    public function select($table,$page=null,$offset=null,$limit=null, $sort=null,$column=null)
    {
      if ($_SESSION['user']=='admin') $admin = true;
      if ($admin){
        $sql = "SELECT count(id) FROM $table";
      }
      else {
        $sql = "SELECT count(id) FROM $table WHERE status=1";
      }
      $result = mysqli_query($this->conn, $sql);
      $row = mysqli_fetch_array($result);
      $total_rows = $row[0];
      if ($sort==null) $sort = "DESC";
      if ($total_rows > $limit) 
      {
          $number_of_pages = ceil($total_rows / $limit);
      } 
      else 
      {
        $page = 1;
        $number_of_pages = 1;
      }
      if ($column==null)
        if  ($admin) {
          $sql = "SELECT * FROM $table ORDER BY id DESC LIMIT $offset, $limit";
        }
        else {
          $sql = "SELECT * FROM $table WHERE status=1 ORDER BY id DESC LIMIT $offset, $limit";
        }
      else {
        if ($admin){
          $sql = "SELECT * FROM $table ORDER BY $column $sort LIMIT $offset, $limit";
        }
        else {
          $sql = "SELECT * FROM $table WHERE status=1 ORDER BY $column $sort LIMIT $offset, $limit";
        }
      }

      $result = mysqli_query($this->conn, $sql) or die(mysqli_error($this->conn));
      $res = array('page' => $page, 'number_of_pages' => $number_of_pages, 'result' => $result);

      return $res;
    }

    public function get($table, $id)
    {
      $sql = "SELECT * FROM  ".$table. ' WHERE id='.($id);
      $select = mysqli_query($this->conn, $sql) or die(mysqli_error($this->conn));

      return $select;
    }

    public function add($table, $data)
    {
      $username = $this->escape_string($data['username']);
      $email = $this->escape_string($data['email']);
      $task = $this->escape_string($data['task_description']);

      $str = "username='".$username;
      $str.= "', email='".$email;
      $str.= "', task_description='".$task."'";
      
      $sql='INSERT '.$table.' SET '.$str;
      $result = mysqli_query($this->conn, $sql) or die(mysqli_error($this->conn));

      return $result;
    }

    public function update($table, $data, $id)
    {
      
      $username = $this->escape_string($data['username']);
      $email = $this->escape_string($data['email']);
      $task = $this->escape_string($data['task_description']);
      $edited = $this->escape_string($data['edited']);

      $str = "username='".$username;
      $str.= "', email='".$email;
      $str.= "', task_description='".$task;
      $str.= "', edited='".$edited."'";
      
      $sql='UPDATE '.$table.' SET '.$str." WHERE id=".$id;
      $result = mysqli_query($this->conn, $sql) or die(mysqli_error($this->conn));

      return $result;
    }

    public function update_status($table, $data)
    {
      $str = "status='".$this->escape_string($data['status'])."'";
      
      $sql='UPDATE '.$table.' SET '.$str." WHERE id=".$this->escape_string($data['id']);
      $result = mysqli_query($this->conn, $sql) or die(mysqli_error($this->conn));

      if ($result) $_SESSION['success'] = "Статус успешно отредактировано!";
      else $_SESSION['error'] = "Произошла ошибка.";

      return $result;

    }

    private function escape_string($str){
      return mysqli_real_escape_string($this->conn, $str);
    }
}

?>