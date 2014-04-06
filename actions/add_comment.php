<html>
  <?php
    $book_id = $_POST['book_id'];
    $user_id = $_POST['user_id'];

    echo "processing comments for book with id".$book_id." from user with id".$user_id;

    print "<p>Thank you, the review is added for the book</p>";
  ?>
</html>