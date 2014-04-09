<html>
  <head>
    <title>Add book to reading list</title>
    <link href="../assets/bootstrap-2-3-2.css" rel="stylesheet">
  </head>
  <?php
    ini_set('display_errors', 'On');
    $db = "some_db";
    $conn = oci_connect("username", "password", $db);

    $reading_list_name = $_POST['reading_list_name'];
    $book_id = $_POST['book_id'];
    $user_id = $_POST['user_id'];

    $reading_list_stmt = oci_parse($conn, "SELECT Id FROM ReadingLists WHERE user_id=".$user_id." AND name='".$reading_list_name."'");
    oci_execute($reading_list_stmt, OCI_DEFAULT);
    while ($reading_list_res = oci_fetch_row($reading_list_stmt))
    {
        $reading_list_id = $reading_list_res[0];
    }

    $sql = "INSERT INTO BooksInReadingLists VALUES(".$book_id.", ".$reading_list_id.")";

    $stmt = oci_parse($conn, $sql);
    oci_execute($stmt, OCI_DEFAULT);
    $err = oci_error($stmt);
    if ($err) {
        oci_rollback($conn);
        $err_code = $err['code'];

        if($err_code == 1) {
            $error_msg = "Your User ID is already used. Please try another User ID.<br>\n";
            print "<div class='alert alert-error'>".$error_msg."</div>";
        } else {
            $error_msg = "Some unknown database error occured. Please inform database administator with these error messages.<br>\n"."Error code : ".$err['code']."<br>"."Error message : ".$err['message']."<br>";
            print "<div class='alert alert-error'>".$error_msg."</div>";
        }
    } else {
        oci_commit($conn);
        print "<div class='alert alert-success'><p>Thank you, the book is added to the reading list</p></div>";
    }

    oci_close($conn);

  ?>
  <footer>
    <p><a href="../user.php?id=<?php echo $user_id?>"> Back to homepage</p
  </footer>
</html>
