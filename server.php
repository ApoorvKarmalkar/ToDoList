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
      $hash = password_hash($password, PASSWORD_DEFAULT);
      $userRegQuery = "INSERT INTO `user`(`id`, `name`, `mobile`, `email`, `password`) VALUES ('','$name','$mobile','$email','$hash')";
      if (mysqli_query($conn, $userRegQuery)) {
        $regSuccessMsg = "Registered Successfully. You will be redirected to home page in 5 seconds.";
      }
    }
  }
  //Login
  if(isset($_POST['loginSubmit'])) {
    $mobile = mysqli_real_escape_string($conn, $_POST['mobile']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $query = "select name,password from user where mobile='$mobile'";
    $result = mysqli_query($conn, $query);
    $username = mysqli_fetch_assoc($result);
    if(mysqli_num_rows($result)) {
      if(password_verify($password, $username['password'])) {
      $_SESSION['username'] = $username['name'];
      header("Location: index.php");
      }
      else {
        echo "Invalid Password";
      }
    }
    else {
      echo "Invalid Credentials";
    }
  }
  //Logout
  if(isset($_POST['logoutSubmit'])) {
    session_destroy();
    header("Location: index.php");
  }
?>
