<html>
  <?php
    $book_id = $_POST['book_id'];
    $user_id = $_POST['user_id'];
    $rating = $_POST['rating'];
    $description = $_POST['description'];

    // increment the primary key
    $count_stmt = oci_parse($conn, "select COUNT(*) from Comments");
    oci_execute($count_stmt, OCI_DEFAULT);
    while ($res = oci_fetch_row($count_stmt))
    {
            $comment_id = $res[0] + 1;
    }

    $sql = "INSERT INTO Comments VALUES (".$comment_id.", ".$book_id.", ".$user_id.", ".$rating.", '".$description."');"

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

    print "<p>Thank you, the review is added for the book</p>";
  ?>
</html>