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
        $db = "some_db";
        $conn = oci_connect("username", "password", $db);

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

      <a href="#myModal" role="button" class="btn" data-toggle="modal">Add a new comment</a>
      <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h3 id="myModalLabel">Add a comment</h3>
        </div>
        <div class="modal-body">
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
            <textarea cols="100" rows="10" name="description"> Enter your comment here..</textarea>
            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
            <input type="hidden" name="book_id" value="<?php echo $book_id; ?>">
            <p><input type="submit"/></p>
          </form>
        </div>
      </div>

      <p><a href="../social_reads/user.php?id=<?php echo $user_id?>"> Back to homepage</p>
  </div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
  <script src="assets/bootstrap.min.js"></script>
  </body>
</html>