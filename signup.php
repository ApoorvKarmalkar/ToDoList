<?php include "server.php" ?>
<html>
<head>
  <title>Sign Up</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css">
  <style>
  body {
    background-image: url("img/signupbackground.jpeg");
    background-attachment: fixed;
    background-size: cover;
  }
  .container {
    padding-top: 5%;
  }
  h1 {
    text-align: center;
    font-family: Verdana;
    font-weight: bold;
    margin-bottom: 5%;
  }
  #regBtn {
    margin-top: 5%;
  }
  #errorAlert {
    display: none;
  }
  </style>
</head>
<body>
  <script src="js/jquery-3.4.1.js"></script>
  <script src="bootstrap/js/bootstrap.js"></script>
<!-- Sign Up Modal Box -->
  <div class="container">
    <h1 id="regHeading">Sign Up</h1>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
      <div class="form-group">
        <label for="regName">Name</label>
        <input id="regName" class="form-control loginElements" type="text" name="fullname" required>
      </div>
      <div class="form-group">
        <label for="regMobile">Mobile</label>
        <input id="regMobile" class="form-control loginElements" type="text" maxlength="10" pattern="[7|8|9]\d{9}" name="mobile" required>
      </div>
      <div class="form-group">
        <label for="regEmail">Email</label>
        <input id="regEmail" class="form-control loginElements" type="email" name="email">
      </div>
      <div class="form-group">
        <label for="regPassword">Password</label>
        <input id="regPassword" class="form-control loginElements" type="password" maxlength="16" name="password_1" required>
      </div>
      <div class="form-group">
        <label for="regCnfPassword">Confirm Password</label>
        <input id="regCnfPassword" class="form-control loginElements" type="password" name="password_2" required>
      </div>
      <div class="text-center">
        <button type="submit" class="btn btn-default" id="regBtn" name="regSubmit">Submit</button>
      </div>
    </form>
    <div id="errorAlert" class="alert alert-danger" role="alert">
    <?php
    if (!empty($alreadyExistsError)) { ?>
      <script>
        $("#errorAlert").show();
      </script>
    <?php
      echo "$alreadyExistsError";
      header("refresh:2,url=signup.php");
    }
    elseif(!empty($regSuccessMsg)) { ?>
      <script>
        $("#errorAlert").removeClass("alert-danger").addClass("alert-success").show();
      </script>
    <?php
      echo "$regSuccessMsg";
      header("refresh:5,url=index.php");
    } ?>
    </div>
  </div>
  <script>
    $("document").ready(function(){
      $("form").submit(function(){
        var pwd = $("#regPassword").val();
        var cnfpwd = $("#regCnfPassword").val();
        if(pwd != cnfpwd) {
          $("#errorAlert").show();
          $("#errorAlert").fadeOut(5000);
          $("#errorAlert").empty();
          $("#errorAlert").append('<p> Password and Confirm Password do not match! </p>');
          console.log("Not Submitted");
          return false;
        }
      });
    });
  </script>
</body>
</html>
