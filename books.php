<html>
  <head>
    <title>Browse Books</title>
    <link href="assets/bootstrap-2-3-2.css" rel="stylesheet">
  </head>
  <body>
    <?php
      $user_id = $_REQUEST['id'];
      print "<h2> User ID: ".$user_id."</h2>";

      ini_set('display_errors', 'On');
      $db = "some_db";
      $conn = oci_connect("username", "password", $db);

      $stmt = oci_parse($conn, "SELECT id, title FROM Books");
      oci_execute($stmt, OCI_DEFAULT);
      while ($res = oci_fetch_row($stmt))
      {
        $book_id = $res[0];
        $title = $res[1];
        print "<div class='well'>";
        print "<p><a href='book.php?id=".$book_id."&user_id=".$user_id."'>".$title."</a></p>";
        print "</div>";
      }
      oci_close($conn);

    ?>
  <p><a href="../social_reads/user.php?id=<?php echo $user_id?>"> Back to homepage</p>
  </body>
</html>
