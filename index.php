<?php include "server.php" ?>
<html>
    <head>
        <title>To Do List</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="jqueryui/jquery-ui.css">
        <link rel="stylesheet" href="jqueryui/jquery-ui.structure.css">
        <link rel="stylesheet" href="jqueryui/jquery-ui.theme.css">
        <link rel="stylesheet" type="text/css" href="css/index.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    </head>
    <body>
        <div id="heading">
            <h3 id="username"><?php echo htmlspecialchars($_SESSION['username']); ?></h3>
            <button type="button" id="login">Login</button>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
              <button type="submit" id="logout" name="logoutSubmit">Logout</button>
            </form>
            <h1><i class="fas fa-clipboard-list"></i> My Task List</h1>
            <h4>Click on 'ADD' to enter your task</h4>
            <h4>Click 'X' to delete your task</h4>
            <h4>Click any task to edit your task</h4>
            <input id="itemTextBox" type="text" placeholder="Enter Item Here">
            <button id="enterBtn">ADD</button>
        </div>
        <div id="task">
        </div>
<!-- Login Modal Box -->
        <div id="loginModal" class="modal">
          <div class="modalContent">
            <span id="loginHeading">Login</span>
            <button type="button" id="close">x</button>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
              <input id="mobile" class="loginElements" type="text" name="mobile" placeholder="Mobile" required> <br>
              <input id="password" class="loginElements" type="password" name="password" placeholder="Password" required> <br>
              <input id="loginSubmit" class="loginElements" name="loginSubmit" type="submit"> <br>
            </form>
            <a href="signup.php" id="signup">Sign Up</a>
          </div>
        </div>
        <div id="overlay"></div>
<!-- Jquery -->
        <script src="js/jquery-3.4.1.js"></script>
        <script src="jqueryui/jquery-ui.js"></script>
        <script>
            var mydata;
            var i;
            $("document").ready(function(){
                $("#heading i").animate({opacity: "1"},"slow");
                $("#enterBtn").click(function(){
                    mydata = document.getElementById("itemTextBox").value;
                    if(mydata.length>0){
                    $("#task").append('<div class="binding"><i class="fas fa-arrows-alt-v fa-lg drag"></i> <input class="list" type="text" value="'+mydata+'">' + '&nbsp' + '<button class="closing">x</button>' + '&nbsp' + '<input class="check" type="checkbox"></div>');
                    $("#task").sortable();
                    $("#itemTextBox").val("");
                    $.ajax({
                      url: 'task_insert.php',
                      type: 'post',
                      data: {'taskData': mydata},
                      dataType:'json',
                    });
                  }
                });
                $(document).on("click",".closing",function(){
                    $(this).parent().empty();
                    console.log("Closed");
                });
                $(document).on("click",".check",function(){
                  if($(this).prop("checked") == true){
                    $(this).siblings(".list").css({"color":"#3F51B5", "text-decoration":"line-through"}).attr("readonly","readonly");
                    console.log("Checked");
                  }
                  else {
                    $(this).siblings(".list").css({"color":"white", "text-decoration":"none"}).prop("readonly", false);
                    console.log("Unchecked");
                  }
                });
                $("#login").click(function(){
                  $("#loginModal").fadeIn("fast",function(){
                    $(this).css("display","block");
                  });
                  $("#overlay").css("display","block");
                });
                $("#close").click(function(){
                  $("#loginModal").fadeOut("fast",function(){
                    $(this).hide();
                  });
                  $("#overlay").hide();
                });
            });
        </script>
        <?php if(isset($_SESSION['username'])) {
          $username = $_SESSION['username'];
          $sql = "SELECT task FROM tasks join user on(tasks.userid = user.id) WHERE name = '$username'";
          $result = mysqli_query($conn, $sql);
          while ($task = mysqli_fetch_assoc($result)) { ?>
          <script>
            var task = "<?php echo $task['task'] ?>";
            $("#task").append('<div class="binding"><i class="fas fa-arrows-alt-v fa-lg drag"></i> <input class="list" type="text" value="'+task+'">' + '&nbsp' + '<button class="closing">x</button>' + '&nbsp' + '<input class="check" type="checkbox"></div>');
            $("#task").sortable();
          </script>
        <?php } ?>
          <script>
          $("#login").hide();
          $("#logout").show();
          $("#username").show();
          </script>
        <?php } ?>
    </body>
</html>
