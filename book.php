<html>
  <head>
    <title>Book Page</title>
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
      <?php
        $book_id = $_GET['id'];
        $user_id = $_GET['user_id'];

        $query_for_book = "SELECT title, author, category, isbn FROM Books WHERE id=".$book_id ;

        print "<h3>Book Summary</p>";

        ini_set('display_errors', 'On');
        $db = "w4111c.cs.columbia.edu:1521/adb";
        $conn = oci_connect("fs2458", "KbqshQrx", $db);

        $book_stmt = oci_parse($conn, $query_for_book);
        oci_execute($book_stmt, OCI_DEFAULT);

        print "<section>";
        print "<div class='hero-unit'>";
        while ($book_res = oci_fetch_row($book_stmt))
        {
                print "<p> Title: ".$book_res[0]."</p>";
                print "<p> Author: ".$book_res[1]."</p>";
                print "<p> Category: ".$book_res[2]."</p>";
                print "<p> ISBN: ".$book_res[3]."</p>";
        }
        print "</div>";

        $query_for_comments = "SELECT C.description, C.rating, U.name FROM Comments C LEFT OUTER JOIN Users U ON (C.user_id = U.id) WHERE C.book_id=".$book_id;
        print "</section>";

        print "<section><h3> Review By Users </h3>";
        $comments_stmt = oci_parse($conn, $query_for_comments);
        oci_execute($comments_stmt, OCI_DEFAULT);

        print "<div class='row-fluid'>";
        while($comments_res = oci_fetch_row($comments_stmt))
        {
          print "<div class='well'>";
          print "<p> ".$comments_res[2]." rated it ".$comments_res[1]."</p>";
          print "<blockquote><p>".$comments_res[0]."</p></blockquote>";
          print "</div>";
        }
        print "</div>";
        print "</section>";
        oci_close($conn);
      ?>

      <section>
      <h3> Add new comments </p>
      <form action="actions/add_comment.php" method="post">
        <p>Rating:
            <select name="rating">
                <option value=1> 1 </option>
                <option value=2> 2 </option>
                <option value=3> 3 </option>
                <option value=4> 4 </option>
                <option value=5> 5 </option>
            </select>
        </p>

        <textarea cols="60" rows="5" name="description"> Enter your comment here..</textarea>
        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
        <input type="hidden" name="book_id" value="<?php echo $book_id; ?>">
        <p><input type="submit"/></p>
      </form>
      </section>
  </div>
  </body>
</html>