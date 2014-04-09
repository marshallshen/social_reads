<html>
  <head>
    <title>Add book to reading list</title>
    <link href="../assets/bootstrap-2-3-2.css" rel="stylesheet">
  </head>
  <?php
    $book_id = $_POST['book_id'];
    $user_id = $_POST['user_id'];
    $rating = $_POST['rating'];
    $description = $_POST['description'];

    ini_set('display_errors', 'On');
    $db = "some_db";
    $conn = oci_connect("username", "password", $db);
    // increment the primary key
    $count_stmt = oci_parse($conn, "select COUNT(*) from Comments");
    oci_execute($count_stmt, OCI_DEFAULT);
    while ($res = oci_fetch_row($count_stmt))
    {
            $comment_id = $res[0] + 2;
    }

    echo "what is comment id";
    echo $comment_id;

    $sql = "INSERT INTO Comments VALUES (".$comment_id.", ".$book_id.", ".$user_id.", ".$rating.", '".$description."')";
    echo $sql;

    $stmt = oci_parse($conn, $sql);
    oci_execute($stmt, OCI_DEFAULT);
    $err = oci_error($stmt);
    if ($err) {
        oci_rollback($conn);
        $err_code = $err['code'];

        if($err_code == 1) {
            $error_msg = "Your User ID is already used. Please try another User ID.<br>\n";
        } else {
            $error_msg = "Some unknown database error occured. Please inform database administator with these error messages.<br>\n"."Error code : ".$err['code']."<br>"."Error message : ".$err['message']."<br>";
        }
    } else {
        oci_commit($conn);
        print "<div class='alert alert-success'><p>Thank you, the book is added to the reading list</p></div>";
    }
    oci_close($conn);
  ?>
  <footer>
    <p><a href="../user.php?id=<?php echo $user_id?>"> Back to homepage</p>
  </footer>
</html>