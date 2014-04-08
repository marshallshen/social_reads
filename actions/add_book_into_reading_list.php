<html>
  <?php
    ini_set('display_errors', 'On');
    $db = "w4111b.cs.columbia.edu:1521/adb";
    $conn = oci_connect("fs2458", "KbqshQrx", $db);

    $reading_list_name =  $_POST['reading_list_name'];
    $book_id =  $_POST['book_id'];
    $user_id =  $_POST['user_id'];

    echo $reading_list_name;
    echo $book_id;
    echo $user_id;

    // $sql = "DELETE FROM BooksInReadingLists WHERE book_id IN (SELECT Id FROM Books WHERE title='".$book_name."') AND reading_list_id IN (SELECT Id FROM ReadingLists WHERE name='".$reading_list_name."' AND user_id=".$user_id.");";

    // $insert_stmt
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
    }

    oci_close($conn);
    print "<p>Thank you, the book is added to the reading list</p>";
  ?>
  <p><a href="../user.php"> Back to homepage</a></p>
</html>
