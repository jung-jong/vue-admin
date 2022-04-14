<?php
header('Access-Control-Allow-Origin:*');
header("Access-Control-Allow-Credentials", "true");
header('Access-Control-Allow-Headers", "Access-Control-Allow-Headers, Origin,Accept, X-Requested-With, Content-Type, Access-Control-Request-Method, Access-Control-Request-Headers');
header('Access-Control-Allow-Methods:GET,POST,PUT,DELETE,OPTIONS');

Class Model{
  
private $host = "localhost:3307";
private $user = "root";
private $password="wjdwhdgus1";
private $dbname="test";
private $connection;

  public function __construct()
  {
   try {
     $this->connection = new mysqli($this->host, $this->user, $this->password, $this->dbname);
   } catch (Exception $e) {
     echo "접속실패" .$e->getMessage();
   }
  }

  public function fetchAll(){
    $data = [];

    $query = "SELECT * FROM tb_project";

    if($sql = $this->connection->query($query)){
      while($rows = mysqli_fetch_assoc($sql)){
        $data[] = $rows;
      }
    }
    return $data;
  }

  public function delete($id){
    $query = "DELETE FROM tb_project WHERE SEQ_ID = '".$id."'";

    if ($sql = $this->connection->query($query)) {
      return true;
    } else{
      return;
    }
  }

}
?>