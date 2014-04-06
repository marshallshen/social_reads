<html>
   <head><title>User Page</title></head>
   <h2>Social Reads</h2>
    <body>
      <h3> Current ReadingList </h3>
        <?php
                $user_id = $_POST['user_id'];
                print "<h2> User ID: ".$user_id."</h2>";

                ini_set('display_errors', 'On');
                $db = "w4111b.cs.columbia.edu:1521/adb";
                $conn = oci_connect("fs2458", "KbqshQrx", $db);
                $stmt = oci_parse($conn, "SELECT R.name, B.title FROM ReadingLists R LEFT OUTER JOIN BooksInReadingLists BIR ON (R.id = BIR.reading_list_id) LEFT OUTER JOIN Books B ON (BIR.book_id = B.id) WHERE R.user_id=".$user_id);
                oci_execute($stmt, OCI_DEFAULT);
                while ($res = oci_fetch_row($stmt))
                {
                        $reading_list = $res[0];
                        $book_name = $res[1];
                        print "<p> Reading List: ".$reading_list." -".$book_name."</p>";
                }
                oci_close($conn);
        ?>

        <h4>Book to review</h4>
        <p><a href="book.php/?id=1&user_id=<?php echo $user_id;?>">Book 1</a></p>


        <h3> Add books into Reading List </h3>
        <form action="actions/add_book_into_reading_list.php" method="post">
                <p>ReadingList:
                    <select name="reading_list_name">
                        <option value="to_read"> To Read </option>
                        <option value="reading"> Reading </option>
                        <option value="read"> Read </option>
                    </select>
                </p>
                <p>Book Id (must exist in readinglist): <input type="text" name="book_id"></p>
                <input type="hidden" name="user_id" value="<?php echo $user_id;?>">
                <p><input type="submit" /></p>
        </form>


        <h3> Remove books from Reading List </h3>
        <form action="actions/remove_book_from_reading_list.php" method="post">
            <p>ReadingList:
                    <select name="reading_list_name">
                        <option value="to_read"> To Read </option>
                        <option value="reading"> Reading </option>
                        <option value="read"> Read </option>
                    </select>
                </p>
                <p>Book Id (must exist in DB): <input type="text" name="book_id"></p>
                <input type="hidden" name="user_id" value="<?php echo $user_id;?>">
                <p><input type="submit" /></p>
        </form>
     </body>
</html>