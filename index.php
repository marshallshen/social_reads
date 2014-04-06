<html>
    <head><title>Social Reads - Index</title> </head>
    <h2>Social Reads</h2>
    <body>
      <h3> Current books </h3>
        <?php
                ini_set('display_errors', 'On');
                $db = "w4111b.cs.columbia.edu:1521/adb";
                $conn = oci_connect("fs2458", "KbqshQrx", $db);
                $stmt = oci_parse($conn, "select title,author,amazon_url from books");
                oci_execute($stmt, OCI_DEFAULT);
                while ($res = oci_fetch_row($stmt))
                {
                        print "<p>".$res[0]." - By ".$res[1]."</p>";
                }
                oci_close($conn);
        ?>

        <h3> New Book </h3>
        <form action="actions/new_book.php" method="post">
            <p>Book name: <input type="text" name="book_name" /></p>
            <p>ISBN: <input type="text" name="isbn"></p>
            <p>Category:
                <select name="category">
                   <option value="">Select..</option>
                   <option value="Fiction"> Fiction </option>
                   <option value="Nonfiction"> Non-Fiction </option>
                   <option value="SocialScience"> Social Science </option>
                   <option value="Technology"> Technology </option>
                </select>
            </p>
            <p>Book author:  <input type="text" name="author" /></p>
            <p>Amazon url: <input type="text" name="amazon_url"></p>
            <p><input type="submit" /></p>
        </form>


        <h3> New Comments </h3>
     </body>
</html>