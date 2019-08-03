<?php
  session_start();
  $conn = mysqli_connect('localhost','root','','to_do_list') or die("Connection Failed ".mysqli_connect_error());
  if(isset($_POST['regSubmit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['fullname']);
    $mobile = mysqli_real_escape_string($conn, $_POST['mobile']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password_1']);
    //Checking if same mobile exists in db
    $query = "select * from user where mobile = '$mobile'";
    $result = mysqli_query($conn, $query);
    if(mysqli_num_rows($result)>0) {
    $alreadyExistsError  = "The mobile number is already registered.";
    }
    //Registering a user
    else {
      $password = md5($password);
      $userRegQuery = "INSERT INTO `user`(`id`, `name`, `mobile`, `email`, `password`) VALUES ('','$name','$mobile','$email','$password')";
      if (mysqli_query($conn, $userRegQuery)) {
        $regSuccessMsg = "Registered Successfully. You will be redirected to home page in 5 seconds.";
      }
    }
  }
?>
