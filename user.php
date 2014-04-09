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
      <a href="login.php" class="btn btn-primary">Logout</a>
      <section>
        <h3> News Feed </h3>
        <?php
             $user_id = $_REQUEST['id'];
             print "<h2> User ID: ".$user_id."</h2>";

             ini_set('display_errors', 'On');
             $db = "some_db";
             $conn = oci_connect("username", "password", $db);

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
                print "<p><strong> ".$user_name."</strong> reviewd ".$book_name."<p>";
                print "<p> Rating <span class='badge badge-success'>".$rating."</span></p>";
                print "<blockquote><p>".$description." </p></blockquote>";
                print "</div>";
             }
        ?>
       </section>

       <section>
       <nav>
         <a href="books.php?id=<?php echo $user_id?>">Browse Books</a>
         <a href="#addBooks" role="button" class="btn" data-toggle="modal">Add books into Reading List</a>
         <a href="#removeBooks" role="button" class="btn" data-toggle="modal">Remove books from Reading List</a>
       </nav>
       <h3> My reading lists </h3>
         <?php
                $stmt = oci_parse($conn, "SELECT R.name, B.title, B.id FROM ReadingLists R LEFT OUTER JOIN BooksInReadingLists BIR ON (R.id = BIR.reading_list_id) LEFT OUTER JOIN Books B ON (BIR.book_id = B.id) WHERE R.user_id=".$user_id);
                oci_execute($stmt, OCI_DEFAULT);
                while ($res = oci_fetch_row($stmt))
                {
                        print "<div class='well well-large'>";
                        $reading_list = $res[0];
                        $book_name = $res[1];
                        $book_id = $res[2];
                        print "<p><strong>".$reading_list."</strong>: "."<a href="."'book.php?id=".$book_id."&user_id=".$user_id."'>".$book_name."</a></p>";
                        print "</div>";
                }
                oci_close($conn);
         ?>
       </section>

       <br/><br/>
       <div id="addBooks" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
         <div class="modal-header">
           <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
           <h3 id="myModalLabel">Add books into Reading List</h3>
         </div>
         <div class="modal-body">
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
         </div>
       </div>

       <div id="removeBooks" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
         <div class="modal-header">
           <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
           <h3 id="myModalLabel">Add books into Reading List</h3>
         </div>
         <div class="modal-body">
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
         </div>
       </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    <script src="assets/bootstrap.min.js"></script>
    </body>
</html>