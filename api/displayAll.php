<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Method: GET');
require_once '../components/db_connect.php'; 

if($_SERVER['REQUEST_METHOD'] == "GET"){
  $sql = "SELECT * FROM property";
  $result = mysqli_query($connect, $sql);
  if($result){
    $row = mysqli_fetch_all($result, MYSQLI_ASSOC);
    echo json_encode($row);
  }
  else{
    echo 'error';
  }  
}
mysqli_close($connect);