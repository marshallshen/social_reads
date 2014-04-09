<html>
  <head>
    <title>Log in</title>
    <link href="assets/bootstrap-2-3-2.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #f5f5f5;
        background-image: url("assets/books.jpg");
      }

      .form-signin {
        max-width: 300px;
        padding: 19px 29px 29px;
        margin: 0 auto 20px;
        background-color: #fff;
        border: 1px solid #e5e5e5;
        -webkit-border-radius: 5px;
           -moz-border-radius: 5px;
                border-radius: 5px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
           -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                box-shadow: 0 1px 2px rgba(0,0,0,.05);
      }
      .form-signin .form-signin-heading,
      .form-signin .checkbox {
        margin-bottom: 10px;
      }
      .form-signin input[type="text"],
      .form-signin input[type="password"] {
        font-size: 16px;
        height: auto;
        margin-bottom: 15px;
        padding: 7px 9px;
      }
    </style>
  </head>
  <body>
    <div class="container">
      <h2><span style="color:white">Welcome to Social Reads</span></h2>
      <h3><span style="color:white">A social Network for readers</span></h3>
      <?php
        $user_id = $_POST['id'];
        $password = $_POST['password'];

        if(!is_null($user_id)){
          ini_set('display_errors', 'On');
          $db = "some_db";
          $conn = oci_connect("username", "password", $db);

          $sql = "SELECT COUNT(*) FROM Users WHERE id=".$user_id." AND password='".$password."'";

          $stmt = oci_parse($conn, $sql);
          oci_execute($stmt, OCI_DEFAULT);
          while ($res = oci_fetch_row($stmt))
          {
            $count = $res[0];
          }

          if($count > 0){
            oci_close($conn);
            header('Location: user.php?id='.$user_id);
          } else {
            oci_close($conn);
            print "<div class='alert alert-error'> Login invalid </div>";
          }
        }
      ?>
      <form class="form-signin" action="login.php" method="post">
        <h2 class="form-signin-heading">Please sign in</h2>
        <input type="text" class="input-block-level" placeholder="User Id" name="id">
        <input type="password" class="input-block-level" placeholder="Password" name="password">
        <label class="checkbox">
          <input type="checkbox" value="remember-me"> Remember me
        </label>
        <button class="btn btn-large btn-primary" type="submit">Sign in</button>
      </form>
    </div> <!-- /container -->

  </body>
</html>