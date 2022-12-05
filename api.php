<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET,POST,PUT,DELETE");
header("Access-Control-Allow-Headers: *");

$servername = "localhost";
$username = "root";
$password = "Lo5P#Dpn2w42";
$dbname = "api_db";

$method = $_SERVER['REQUEST_METHOD'];
$id = preg_replace('/\/api.php\/comments\//', '', $_SERVER['REQUEST_URI']);

if ($method == 'GET') {

  $conn = mysqli_connect($servername, $username, $password, $dbname);

  $sql = "SELECT * FROM data";
  $result = mysqli_query($conn, $sql);

  $commentsArray = array();
  while ($row = mysqli_fetch_assoc($result)) {

    $commentsArray[] = $row;

  }

  echo json_encode($commentsArray);

  mysqli_close($conn);

} elseif ($method == 'PUT') {
  $data = file_get_contents('php://input');

  $jsonData = json_decode($data);

  $name = $jsonData->name;
  $email = $jsonData->email;
  $body = $jsonData->body;

  $conn = mysqli_connect($servername, $username, $password, $dbname);

  $sql = "UPDATE data SET name='$name', email='$email', body='$body' WHERE id='>

  if (mysqli_query($conn, $sql)) {
    $data = array("id:" => $id, "name:" => $name, "email:" => $email, "body:" =>
    echo json_encode($data);
  } else {
    http_response_code(404);
  }
  mysqli_close($conn);

} elseif ($method == 'POST') {

  $data = file_get_contents('php://input');
  $jsonData = json_decode($data);

  $name = $jsonData->name;
  $email = $jsonData->email;
  $body = $jsonData->body;

  $conn = mysqli_connect($servername, $username, $password, $dbname);
  $sql = "INSERT INTO data (name, email, body) VALUES ('$name','$email','$body'>
  if (mysqli_query($conn, $sql)) {

    $data = array("name" => $name, "email" => $email, "body" => $body, "id" => >

    http_response_code(201);
    echo json_encode($data);

  } else {
    echo "Could not create a new user";
  }
  mysqli_close($conn);

} elseif ($method == 'DELETE') {

  $conn = mysqli_connect($servername, $username, $password, $dbname);

  $sql = "DELETE FROM data WHERE id='$id'";

  if (mysqli_query($conn, $sql)) {
    http_response_code(204);
  } else {
    http_response_code(404);
  }

  mysqli_close($conn);

} else {
  echo json_encode(
    array('message' => 'method unknown')
  );
}

?>