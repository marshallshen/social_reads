<html>
   <head>
      <title>User Page</title>
      <link href="assets/bootstrap-2-3-2.css" rel="stylesheet">
      <style>
        body {
          padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
        }
      </style>
   </head>
    <body>
      <div class="container">
      <h2>Social Reads</h2>
      <section>
        <h3> News Feed </h3>
        <?php
             $sql = "SELECT U.name, B.title, C.rating, C.description FROM Users U, Comments C, Books B WHERE B.id = C.book_id AND C.user_id = U.id AND C.user_id IN (SELECT F.following_uid FROM Follows F WHERE F.followed_uid = ".$user_id.")";

             $news_feed_stmt = oci_parse($conn, $sql);

             oci_execute($news_feed_stmt, OCI_DEFAULT);
             while ($feed_res = oci_fetch_row($news_feed_stmt))
             {
                $user_name = $feed_res[0];
                $book_name = $feed_res[1];
                $rating = $feed_res[2];
                $description = $feed_res[3];
                print "<div class='well'>";
                print "<p> ".$user_name." rated ".$book_name." ".$rating."</p>";
                print "<blockquote><p>".$description." </p></blockquote>";
                print "</div>";
             }

            oci_close($conn);
        ?>
       </section>

       <section>
       <h3> Current ReadingList </h3>
         <?php
                $user_id = $_POST['user_id'];
                print "<h2> User ID: ".$user_id."</h2>";

                ini_set('display_errors', 'On');
                $db = "w4111c.cs.columbia.edu:1521/adb";
                $conn = oci_connect("fs2458", "KbqshQrx", $db);
                $stmt = oci_parse($conn, "SELECT R.name, B.title, B.id FROM ReadingLists R LEFT OUTER JOIN BooksInReadingLists BIR ON (R.id = BIR.reading_list_id) LEFT OUTER JOIN Books B ON (BIR.book_id = B.id) WHERE R.user_id=".$user_id);
                oci_execute($stmt, OCI_DEFAULT);
                while ($res = oci_fetch_row($stmt))
                {
                        $reading_list = $res[0];
                        $book_name = $res[1];
                        $book_id = $res[2];
                        print "<p> Reading List: ".$reading_list." - "."<a href="."'book.php?id=".$book_id."&user_id=".$user_id."'>".$book_name."</a></p>";
                }
         ?>
       </section>

      <section>
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
      </section>
    </div>
    </body>
</html>