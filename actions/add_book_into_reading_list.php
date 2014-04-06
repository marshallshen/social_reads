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

    // $delete_stmt = "DELETE FROM BooksInReadingLists WHERE book_id IN (SELECT Id FROM Books WHERE title='".$book_name."') AND reading_list_id IN (SELECT Id FROM ReadingLists WHERE name='".$reading_list_name."' AND user_id=".$user_id.");";

    // $insert_stmt

    oci_close($conn);
    print "<p>Thank you, the book is added to the reading list</p>";
  ?>
  <p><a href="../user.php"> Back to homepage</a></p>
</html>
