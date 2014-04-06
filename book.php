<html>
  <head><title>Book Page</title></head>
  <h2>Social Reads</h2>
  <?php
    $book_id = $_GET['id'];
    $user_id = $_GET['user_id'];

    echo "I am inside the book page ".$book_id;
    echo "Current user: ".$user_id;

    $query_for_book = "SELECT author, category, isbn FROM Books WHERE id=".$book_id ;

    echo "query for book";
    echo $query_for_book;

    print "<h3>Book Summary</p>";
    // ini_set('display_errors', 'On');
    // $db = "w4111b.cs.columbia.edu:1521/adb";
    // $conn = oci_connect("fs2458", "KbqshQrx", $db);
    // $book_stmt = oci_parse($conn, $query_for_book);
    // oci_execute($book_stmt, OCI_DEFAULT);
    // while ($book_res = oci_fetch_row($book_stmt))
    // {
    //         print "<li> Author: ".$book_res[0]."</li>";
    //         print "<li> Category: ".$book_res[1]."</li>";
    //         print "<li> ISBN: ".$book_res[2]."</li>";
    // }

    // oci_close($conn);
    $query_for_comments = "SELECT C.description, C.rating, U.name FROM Comments C LEFT OUTER JOIN Users U ON (C.user_id = U.id) WHERE U.book_id=".$book_id ;
    echo $query_for_comments;

    print "<h3> Review By Users </h3>";
    // $comments_stmt = oci_parse($conn, $query_for_comments);
    // oci_execute($comment_stmt, OIC_DEFAULT);
    // while($comments_res = oci_fetch_row($comments_stmt))
    // {
    //   print "<p> By ".$comments_res[2]." rated it ".$comments_rest[1]."</p>";
    //   print "<p> ".$comments_res[0]."</p>";
    // }
    // oci_close($conn);
  ?>

  <h3> Add new comments </p>
  <form action="actions/add_comment.php", method="post">
    <p>Rating:
        <select name="rating">
            <option value=1> 1 </option>
            <option value=2> 2 </option>
            <option value=3> 3 </option>
            <option value=4> 4 </option>
            <option value=5> 5 </option>
        </select>
    </p>
    <p>Description: <input type="text" name="description"></p>
    <p>User Id: <input type="number" name="user_id" value="<?php echo $user_id; ?>"></p>
    <p>Book Id: <input type="number" name="book_id" value="<?php echo $book_id; ?>"></p>
    <p><input type="submit"/></p>
  </form>
</html>