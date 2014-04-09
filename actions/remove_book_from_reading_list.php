<html>
  <head>
   <title>Add book to reading list</title>
     <link href="../assets/bootstrap-2-3-2.css" rel="stylesheet">
  </head>
  <?php
    ini_set('display_errors', 'On');
    $db = "w4111c.cs.columbia.edu:1521/adb";
    $conn = oci_connect("fs2458", "KbqshQrx", $db);

    $reading_list_name =  $_POST['reading_list_name'];
    $book_id =  $_POST['book_id'];
    $user_id =  $_POST['user_id'];

    $sql = "DELETE FROM BooksInReadingLists WHERE book_id=".$book_id." AND reading_list_id IN (SELECT Id FROM ReadingLists WHERE name='".$reading_list_name."' AND user_id=".$user_id.")";

    echo $sql;

    $stmt = oci_parse($conn, $sql);
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
        print "<div class='alert alert-success'><p>Thank you, the book is rmoved from your reading lists</p></div>";
    }

    oci_close($conn);
  ?>
  <footer>
    <p><a href="../user.php?id=<?php echo $user_id?>"> Back to homepage</p
  </footer>

</html>