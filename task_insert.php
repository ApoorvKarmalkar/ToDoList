<?php
$conn = mysqli_connect('localhost','root','','to_do_list') or die("Connection Failed ".mysqli_connect_error());
session_start();
//Insert tasks in database
if(isset($_SESSION['username'])) {
  $username = $_SESSION['username'];
  $taskData = $_POST['taskData'];
  $getUserID = "select id from user where name = '$username'";
  $result = mysqli_query($conn, $getUserID);
  $id = mysqli_fetch_assoc($result);
  $id = $id['id'];
  $sql = "INSERT INTO `tasks`(`userid`, `task`,`id`) VALUES ('$id','$taskData','')";
  $finalResult = mysqli_query($conn, $sql);
  if(!$finalResult) {
    echo "Error";
  };
}
?>
