<?php
        // ini_set('display_errors', 'On');
        // $db = "w4111b.cs.columbia.edu:1521/adb";
        // $conn = oci_connect("fs2458", "KbqshQrx", $db);
        // $count_stmt = oci_parse($conn, "select COUNT(*) from books");
        // oci_execute($count_stmt, OCI_DEFAULT);
        // while ($res = oci_fetch_row($count_stmt))
        // {
        //         $book_id = $res[0] + 1;
        // }

        // $insert_stmt = "INSERT INTO Books VALUES (".$book_id.",'".$_POST['book_name']."','".$_POST['isbn']."','".$_POST['amazon_url']."','".$_POST['author']."','".$_POST['category']."',CURRENT_TIMESTAMP,NULL);";

        // $stid = oci_parse($conn, $insert_stmt);
        // oci_execute($stid);
        // oci_commit($conn);
        // oci_close($conn);

        print "<p>Thank you, the book is added</p>";
        print "<p><a href='index.php'> Back to homepage</a></p>";
?>