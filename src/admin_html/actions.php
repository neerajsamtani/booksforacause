<?php

    include("functions2.php");

    global $link;

	// Login the user after performing relevant validation checks
    if($_GET['action'] == "login") {
        $error = "";
        // Ensure all form fields are filled and details are valid
        if(!$_POST['email']) {
            $error = "An email address is required";
        } else if(!$_POST['password']){
            $error = "A password is required";
        } else if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) == false) {
            $error = "Please enter a valid email address";
        }
        if($error != "") {
            echo $error;
            exit();
        }
        // If all details are valid, check the database for the username and password
      	// All passwords are hashed using md5 algorithm and the user id as a salt. Compare a hash of entered password to check if the user has entered the correct password
        if($_POST['loginActive'] == "1") {
            $query = "SELECT * FROM admins WHERE email = '".mysqli_real_escape_string($link, $_POST['email'])."' LIMIT 1";
            $result = mysqli_query($link, $query);
            $row = mysqli_fetch_assoc($result);
                if ($row['password'] == md5(md5($row['id']).$_POST['password'])) {
                    echo 1;
                    $_SESSION['id'] = $row['id'];
                } else {
                    $error = "Could not find that username/password combination. Please try again.";
                }
        }
        if($error != "") {
            echo $error;
            exit();
        }
    }

//--------------------------------ADMIN ONLY FUNCTIONS-----------------------------------------------//


	// Reject a user's book
    if($_GET['action'] == 'rejectBook') {
        $query = "SELECT * FROM books WHERE approved = 1 AND bookid = ".mysqli_real_escape_string($link, $_POST['bookId'])." LIMIT 1";
            $result = mysqli_query($link, $query);
            if(mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                mysqli_query($link, "INSERT INTO `notifications`(`subject`, `body`, `user_id`, `link`) VALUES ('Book Rejected','".mysqli_real_escape_string($link, $_POST['bookname'])." has been rejected by the administrator and deleted from our database.',".mysqli_real_escape_string($link, $_POST['userid']).", '#')");        
                mysqli_query($link, "DELETE FROM `books` WHERE `books`.`bookid` = ".mysqli_real_escape_string($link, $_POST['bookId']));
                echo "1";
            } else {
                mysqli_query($link, "INSERT INTO `notifications`(`subject`, `body`, `user_id`, `link`) VALUES ('Book Rejected','".mysqli_real_escape_string($link, $_POST['bookname'])." has been rejected by the administrator and deleted from our database.',".mysqli_real_escape_string($link, $_POST['userid']).", '#')"); 
                mysqli_query($link, "DELETE FROM `books` WHERE `books`.`bookid` = ".mysqli_real_escape_string($link, $_POST['bookId']));
                echo "2";
            }
    }

	// Approve a user's book. 
	// The Admin has the option to un-approve a book (in case they approve it by accident) as long as they don't refresh the page.
	// Once the page is refreshed, the admin can no longer view the book
    if($_GET['action'] == 'toggleApprove') {
            $query = "SELECT * FROM books WHERE approved = 1 AND bookid = ".mysqli_real_escape_string($link, $_POST['bookId'])." LIMIT 1";
            $result = mysqli_query($link, $query);
            if(mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                mysqli_query($link, "UPDATE `books` SET `approved` = '0' WHERE `books`.`bookid` = ".mysqli_real_escape_string($link, $_POST['bookId']));
                mysqli_query($link, "INSERT INTO `notifications`(`subject`, `body`, `user_id`, `link`) VALUES ('Book Unapproved','".mysqli_real_escape_string($link, $_POST['bookname'])." has been unapproved',".mysqli_real_escape_string($link, $_POST['userid']).", '?page=bookdetails&bookid=".$_POST['bookId']."')");        
                echo "1";
            } else {
                mysqli_query($link, "UPDATE `books` SET `approved` = '1' WHERE `books`.`bookid` = ".mysqli_real_escape_string($link, $_POST['bookId']));
                mysqli_query($link, "INSERT INTO `notifications`(`subject`, `body`, `user_id`, `link`) VALUES ('Book Approved','".mysqli_real_escape_string($link, $_POST['bookname'])." has been approved. It can now be seen by other users.',".mysqli_real_escape_string($link, $_POST['userid']).", '?page=bookdetails&bookid=".$_POST['bookId']."')");        
                echo "2";
            }
    }

	// Comment on a user's book
    if($_GET['action'] == 'comment') {
        $error = "";   
        $query = "SELECT * FROM books WHERE bookid = ".mysqli_real_escape_string($link, $_POST['bookId'])." LIMIT 1";
            $result = mysqli_query($link, $query);
            if(mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                mysqli_query($link, "UPDATE `books` SET `comments` = '".mysqli_real_escape_string($link, $_POST['comment'])."' WHERE `books`.`bookid` = ".mysqli_real_escape_string($link, $_POST['bookId']));
                mysqli_query($link, "INSERT INTO `notifications`(`subject`, `body`, `user_id`, `link`) VALUES ('Admin comment','".mysqli_real_escape_string($link, $_POST['bookName'])." has been commented on. Click here to view to comments',".mysqli_real_escape_string($link, $_POST['userId']).", '?page=bookdetails&bookid=".$_POST['bookId']."')");
                echo "1";
            } else {
                $error = "An error has occurred. Please notify the developer in the 'Contact Us' section.";
            }
        if($error != "") {
            echo $error;
            exit();
        }
    }

?>