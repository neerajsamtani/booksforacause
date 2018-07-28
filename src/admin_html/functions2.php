<?php

    session_start();

	// Connect to database
    // Database details have been removed for security purposes
    $link = mysqli_connect("databaseName", "username","password", "databaseName");

	// If there is an error, print the error message and stop runnning the code
    if(mysqli_connect_errno()) {
        print_r(mysqli_connect_errno());
        exit();
    }

	// If the user wants to logout, clear the value stored in the session variable
    if($_GET['function'] == "logout") {
        session_unset();
    }

	// Input time in seconds and output time in user friendly format
    function time_since($since) {
        $chunks = array(
            array(60 * 60 * 24 * 365 , 'year'),
            array(60 * 60 * 24 * 30 , 'month'),
            array(60 * 60 * 24 * 7, 'week'),
            array(60 * 60 * 24 , 'day'),
            array(60 * 60 , 'hour'),
            array(60 , 'min'),
            array(1 , 'sec')
        );
        for ($i = 0, $j = count($chunks); $i < $j; $i++) {
            $seconds = $chunks[$i][0];
            $name = $chunks[$i][1];
            if (($count = floor($since / $seconds)) != 0) {
                break;
            }
        }
        $print = ($count == 1) ? '1 '.$name : "$count {$name}s";
        return $print;
    }

	// Display all users
    function displayUsers() {
        global $link;
        $query = "SELECT * FROM users LIMIT 10";
        $result = mysqli_query($link, $query);
        while($row = mysqli_fetch_assoc($result)) {
            echo "<p><a href ='?page=publicprofiles&userid=".$row['id']."'>".$row['email']."</a></p>";
        }
    }

  // One of the most important functions of the website. In depth comments are written in the function.
  // Displays only the books that the user wants to see by altering the WHERE condition of the SQL query
  function displayBooks($type) {
        global $link;
  		// MAIN DIFFERENCE - The administrator views all unapproved books.
        if($type == 'public') {
            $whereClause = "";
        } else if($type == 'unapproved') {
            $whereClause = "WHERE approved = 0"; 
        }
    		// Now that the WHERE clause has been altered, display all books queried
            $query = "SELECT * FROM books ".$whereClause." ORDER BY datetime DESC LIMIT 20";
            $result = mysqli_query($link, $query);
            if(mysqli_num_rows($result) == 0) {
                echo "There are no books to display";
            } else {
                echo "<div class='row'>";
                while($row = mysqli_fetch_assoc($result)) {
                    $userQuery = "SELECT * FROM users WHERE id = ".mysqli_real_escape_string($link, $row['userid'])." LIMIT 1";
                    $userQueryResult = mysqli_query($link, $userQuery);
                    $user = mysqli_fetch_assoc($userQueryResult);
                    $bookid = $row['bookid'];
                    echo "<div class='col-sm-4'>";
                    echo "<div class='card tweet'>";
                    echo "<img class='card-img-top' src='";
                    if($row['image'] != null) {
                        echo "https://swapthisbook.com/upload/".$row['image'];
                    } else {
                        echo "https://swapthisbook.com/unavailable_image.jpg";
                    }
                    echo "'>";
                    echo "<div class='card-body'><h4 class='card-title'><p>".$row['bookname']."</p></h4>";
                    echo "<p class='card-text'>by ".$row['author']."</p>";
                    echo "<p class='card-text'>Subject: ".$row['subject']."</p>";
                    echo "<p class='card-text'> Curriculum: ".$row['curriculum']."</p>";
                    echo "<p class='card-text'>Publisher: ".$row['publisher']."</p>";
                    echo "<p class='card-text'> Edition: ".$row['edition']."</p>";
                    echo "<p class='card-text'>Grade ".$row['grade']."</p>";
                    echo "<p class='card-text'> ".$row['condition']."</p>";
                    echo "<p class='card-text'> ".$row['price']." AED</p>";
                    echo "<p class='card-text'>ISBN: ".$row['isbn']."</p>";
                    echo "<p class='card-text'>search tags: ".$row['tags']."</p>";
                    echo "<p class='card-text'>Additional Information: ".$row['synopsis']."</p>";
                    echo "<p class='card-text'>Admin Comments: ".$row['comments']."</p>";
                    echo "<p><a class='btn btn-primary toggleApprove' data-bookid='".$row['bookid']."' data-userid='".$row['userid']."' data-bookname='".$row['bookname']."'>";
                    $cartQuery = "SELECT * FROM books WHERE approved = 1 AND bookid = ".mysqli_real_escape_string($link, $row['bookid'])." LIMIT 1";
                    $cartQueryResult = mysqli_query($link, $cartQuery);
                    if(mysqli_num_rows($cartQueryResult) > 0) {
                        echo "Unapprove";
                    } else {
                        echo "Approve";
                    }
                    echo "</a></p>";
                    echo "<p><a class='btn btn-danger rejectBook' data-bookid='".$row['bookid']."' data-userid='".$row['userid']."' data-bookname='".$row['bookname']."'>Reject Book</a></p>";            
                    echo '<button class="btn btn-secondary my-2 my-sm-0" data-toggle="modal" data-target="#commentModal" data-bookid="'.$row["bookid"].'" data-bookname="'.$row["bookname"].'" data-userid="'.$row["userid"].'">Add a Comment</button>';
                    echo '    <div class="modal fade" id="commentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="commentModalTitle">Add Comment</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                            <div class="alert alert-danger" id="commentAlert">'.$row['bookid'].'</div>
                          <div class="modal-body">
                            <form>
                                <div class="hiddeninput hiddenbookid"><input type="hidden" name="bookid" id="bookid"></div>
                                <div class="hiddeninput hiddenbookname"><input type="hidden" name="bookname" id="bookname"></div>     
                                <div class="hiddeninput hiddenuserid"><input type="hidden" name="userid" id="userid"></div>     
                              <div class="form-group">
                                <input type="text" class="form-control" id="comment" placeholder="Add comment here">
                              </div>
                            </form>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-primary" id="commentButton">Submit Comment</button>
                          </div>
                        </div>
                      </div>
                    </div>'; 
                    echo "</div>";           
                    echo "</div>";
                    echo "</div>";
                    }
                echo "</div>";
            }
    }

	// Get the book's name from the database
    function getBookName($bookId) {
        global $link;
        $bookQuery = "SELECT * FROM books WHERE id = ".$bookId;
        $bookQueryResult = mysqli_query($link, $bookQuery);  
        $book = mysqli_fetch_assoc($bookQueryResult);
        return $book['bookname'];
    }

	// Find out who the book belongs to
    function getUserId($bookId) {
        global $link;
        $bookQuery = "SELECT * FROM books WHERE id = ".$bookId;
        $bookQueryResult = mysqli_query($link, $bookQuery);     
        $book = mysqli_fetch_assoc($bookQueryResult);
        return $book['userid'];    
    }

	// Display links to all books uploaded on the website
    function displayBookLinks() {
        global $link;
        $query = "SELECT * FROM books";
        $result = mysqli_query($link, $query);
        while($row = mysqli_fetch_assoc($result)) {
            echo "<p><a href ='?page=bookdetails&bookid=".$row['bookid']."'>".$row['bookname']."</a></p>";
        }
    }

?>