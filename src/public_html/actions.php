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
            $query = "SELECT * FROM users WHERE email = '".mysqli_real_escape_string($link, $_POST['email'])."' LIMIT 1";
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

	// Sign up the user after performing relevant validation checks
	if($_GET['action'] == "signup") {
        $error = "";
        if(!$_POST['fname']){
            $error = "A first name is required";
        } else if(!$_POST['lname']){
            $error = "A last name is required";
        } else if(!$_POST['email']) {
            $error = "An email address is required"; 
        } else if(!$_POST['password']){
            $error = "A password is required";
        } else if(!$_POST['confirmPassword']){
            $error = "A confirm password is required";
        } else if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) == false) {
            $error = "Please enter a valid email address";
        } else if($_POST['password'] != $_POST['confirmPassword']){
            $error = "Passwords don't match";
        }
        if($error != "") { 
            echo $error;
            exit();
        }
  		// Check if email address is already in database. If so, display an error message
        if($_POST['loginActive'] == "0") {
            $query = "SELECT * FROM users WHERE email = '".mysqli_real_escape_string($link, $_POST['email'])."' LIMIT 1";
            $result = mysqli_query($link, $query);
            if(mysqli_num_rows($result) > 0) {
                $error = "That email address is already taken.";
            } else {
                $query = "INSERT INTO users (fname, lname, email, password) VALUES ('".mysqli_real_escape_string($link, $_POST['fname'])."' ,'".mysqli_real_escape_string($link, $_POST['lname'])."' , '".mysqli_real_escape_string($link, $_POST['email'])."' , '".mysqli_real_escape_string($link, $_POST['password'])."')";
                if(mysqli_query($link, $query)) {
                    $_SESSION['id'] = mysqli_insert_id($link);
                    $query = "UPDATE users SET password = '".md5(md5($_SESSION['id']).$_POST['password'])."' WHERE id = ".$_SESSION['id']." LIMIT 1";
                    mysqli_query($link, $query);
                    echo 1;
                } else {
                    $error = "Couldn't create user - please try again later";
                }
            }
        }
        if($error != "") {
            echo $error;
            exit();
        }
    }

	// Send message to the user along with a notification
    if($_GET['action'] == 'sendMessage') {
        $query = "INSERT INTO messages (to_id, from_id, message) VALUES (".mysqli_real_escape_string($link, $_POST['sellerId']).", ".mysqli_real_escape_string($link, $_SESSION['id']).", '".mysqli_real_escape_string($link, $_POST['message'])."')"; 
        mysqli_query($link, "INSERT INTO `notifications`(`subject`, `body`, `user_id`, `link`) VALUES ('New Message',' ".getName($_SESSION['id'])." wants to get in touch with you. Click here to view the message.',".mysqli_real_escape_string($link, $_POST['sellerId']).", '?page=messenger&sellerId=".$_SESSION['id']."')");        
        if (mysqli_query($link, $query)){
            echo "1";
        } else {
            echo "2";
        }
    }

	// Retrieve the messages that are relevant to the user from the database
    if($_GET['action'] == 'getMessages') {
            $query = "SELECT * FROM messages WHERE (from_id = ".mysqli_real_escape_string($link, $_SESSION['id'])." AND to_id = ".mysqli_real_escape_string($link, $_POST['sellerId']).") OR (to_id = ".mysqli_real_escape_string($link, $_SESSION['id'])." AND from_id = ".mysqli_real_escape_string($link, $_POST['sellerId']).")";
            $result = mysqli_query($link, $query);
            if(mysqli_num_rows($result) == 0) {
                echo "There are no messages to display";
            } else {
                while($row = mysqli_fetch_assoc($result)) {
                    if($row['from_id'] == $_SESSION['id']){
                        $user = "You";
                    } else {
                        $user = getName($row['from_id']);
                    }
                    echo '<div class="single-message '.(($_SESSION['id']==$row['from_id'])?'right':'left').'">
						<strong>'.$user.': </strong><br /> <p>'.htmlentities($row['message']).'</p>
						<span class = "time" >'.time_since(time() - strtotime($row["time_sent"])).' ago</span>
						</div>
						<div class="clear"></div>
                        						<br />
						';
                    }
            }
        }

	// Retrieve the notifications that are relevant to the user from the database
    if($_GET['action'] == 'fetch') {
        $output = '';
        if(isset($_POST["view"]))
        {
         if($_POST["view"] != '')
         {
          $update_query = "UPDATE notifications SET status=1 WHERE status=0 AND user_id=".$_SESSION['id'];
          mysqli_query($link, $update_query);
         }
         $query = "SELECT * FROM notifications WHERE user_id=".$_SESSION['id']." ORDER BY id DESC LIMIT 100";
         $result = mysqli_query($link, $query);
         if(mysqli_num_rows($result) > 0)
         {
          while($row = mysqli_fetch_array($result))
          {
           $output .= '
           <a class="dropdown-item" href="'.$row["link"].'">
             <strong>'.$row["subject"].'</strong><br />
             <p style="white-space: pre-wrap;"><small><em>'.$row["body"].'</em></small></p>
            </a>
           <div class="dropdown-divider"></div>
           ';
          }
         }
         else
         {
          $output .= '
           <a class="dropdown-item" href="#">
             <p>No Notifications</p>
            </a>
           ';
         }
         $query_1 = "SELECT * FROM notifications WHERE status=0 AND user_id=".$_SESSION['id'];
         $result_1 = mysqli_query($link, $query_1);
         $count = mysqli_num_rows($result_1);
         $data = array(
          'notification'   => $output,
          'unseen_notification' => $count
         );
         echo json_encode($data);
        }
    }

	// When the user marks their book as sold, delete the book from the database 
	// TO DO - I need to update this function to create a log of sold books that the administrator can view
	// TO DO - Delete the image from the database
    if($_GET['action'] == 'sold') {
        $query = "SELECT * FROM books WHERE bookid = ".mysqli_real_escape_string($link, $_POST['bookId'])." LIMIT 1";
            $result = mysqli_query($link, $query);
            if(mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                mysqli_query($link, "DELETE FROM `books` WHERE `books`.`bookid` = ".mysqli_real_escape_string($link, $_POST['bookId']));
                echo "1";
            } else {
                mysqli_query($link, "DELETE FROM `books` WHERE `books`.`bookid` = ".mysqli_real_escape_string($link, $_POST['bookId']));
                echo "2";
            }
    }

	// Add or remove a book from the user's cart
    if($_GET['action'] == 'toggleCart') {
        $query = "SELECT * FROM cart WHERE userid = ".mysqli_real_escape_string($link, $_SESSION['id'])." AND bookid = ".mysqli_real_escape_string($link, $_POST['bookId'])." LIMIT 1";
            $result = mysqli_query($link, $query);
            if(mysqli_num_rows($result) > 0) { 
                $row = mysqli_fetch_assoc($result);
                mysqli_query($link, "DELETE FROM cart WHERE id = ".mysqli_real_escape_string($link, $row['id'])." LIMIT 1");
                echo "1";   
            } else {
                mysqli_query($link, "INSERT INTO cart (userid, bookid) VALUES (".mysqli_real_escape_string($link, $_SESSION['id']).", ".mysqli_real_escape_string($link, $_POST['bookId']).")"); 
                echo "2";     
            }
    }

// Upload a new book to the database. Ensure all the form fields are filled with valid information.
if($_GET['action'] == "postBook") {
    $error = "";
    if(!$_POST['bookname']){
        $error = "A book name is required";
    } else if(!$_POST['author']){
        $error = "An author's name is required";
    } else if(!$_POST['publisher']) {
        $error = "A publisher's name is required";
    } else if(!$_POST['isbn']){
        $error = "An ISBN is required";
    } else if(!$_POST['subject'] || $_POST['subject'] == "Choose..."){
        $error = "A subject is required";
    } else if(!$_POST['grade'] || $_POST['grade'] == "Choose..."){
        $error = "A grade is required";
    } else if(!$_POST['curriculum'] || $_POST['curriculum'] == "Choose..."){
        $error = "A curriculum is required";
    } else if(!$_POST['edition']){
        $error = "A book edition is required. Enter 'none' if unavailable.";
    } else if(!$_POST['bookcondition'] || $_POST['bookcondition'] == "Choose..."){
        $error = "The book condition is required";
    } else if(!$_FILES["file"]){
        $error = "An image is required";
    } else if(!$_POST['tags']){
        $error = "Tags are required";
    } else if(!$_POST['synopsis']){
        $error = "A synopsis is required";
    } else if(is_numeric($_POST['isbn']) == false || strlen($_POST['isbn'])!= 13 || $_POST['isbn'] < 0 || $_POST['isbn'] != round($_POST['isbn'], 0)) {
        $error = "Please enter a valid ISBN Number";
    } else if(is_numeric($_POST['price']) == false || $_POST['price'] < 0 || $_POST['price'] != round($_POST['price'], 0)) {
        $error = "Please enter a numeric value only for price";
    }
	// If there is an error, display the error and stop running the code
    if($error != "") {
        echo $error;
        exit();
    }
	// If an image is uploaded, store it in the database
  	// TO DO - Try to improve this function so that the images can be compressed
    if(isset($_FILES["file"]["type"]))
    {
        $image = mysqli_real_escape_string($link, $_FILES['file']['name']);
        $validextensions = array("jpeg", "jpg", "png");
        $temporary = explode(".", $_FILES["file"]["name"]);
        $file_extension = end($temporary);
        if ((($_FILES["file"]["type"] == "image/png") || ($_FILES["file"]["type"] == "image/jpg") || ($_FILES["file"]["type"] == "image/jpeg")
        ) && ($_FILES["file"]["size"] < 1000000)//Approx. 1 Mb files can be uploaded.
        && in_array($file_extension, $validextensions)) {
            if ($_FILES["file"]["error"] > 0)
            {
                echo "Return Code: " . $_FILES["file"]["error"] . "<br/><br/>";
            }
            else
            {
                if (file_exists("upload/" . $_FILES["file"]["name"])) {
                    echo $_FILES["file"]["name"] . " <span id='invalid'><b>already exists. Change the file name before re-uploading.</b></span> ";
                }
                else
                {
                  // If the image file and book details pass all the error checks, upload the book to the database.
                    $query = "INSERT INTO books (bookname, author, publisher, edition, curriculum, isbn, subject, grade, bookcondition, price, tags, synopsis, approved, image, userid, datetime) VALUES ('".mysqli_real_escape_string($link, $_POST['bookname'])."' ,'".mysqli_real_escape_string($link, $_POST['author'])."' ,'".mysqli_real_escape_string($link, $_POST['publisher'])."' , '".mysqli_real_escape_string($link, $_POST['edition'])."' , '".mysqli_real_escape_string($link, $_POST['curriculum'])."' , '".mysqli_real_escape_string($link, $_POST['isbn'])."' , '".mysqli_real_escape_string($link, $_POST['subject'])."','".mysqli_real_escape_string($link, $_POST['grade'])."','".mysqli_real_escape_string($link, $_POST['bookcondition'])."','".mysqli_real_escape_string($link, $_POST['price'])."','".mysqli_real_escape_string($link, $_POST['tags'])."','".mysqli_real_escape_string($link, $_POST['synopsis'])."','".mysqli_real_escape_string($link, $_POST['approved'])."','".$image."','".mysqli_real_escape_string($link, $_SESSION['id'])."',NOW())";
                    if(mysqli_query($link, $query)) {
                        $sourcePath = $_FILES['file']['tmp_name']; // Storing source path of the file in a variable
                        $targetPath = "upload/".$_FILES['file']['name']; // Target path where file is to be stored
                        move_uploaded_file($sourcePath,$targetPath) ; // Moving Uploaded file
                        echo "<span id='success'>Book Uploaded Successfully! Check the 'My Books' section for approval status or admin comments.</span><br/>";
                        //echo 1;
                    } else {
                        $error = "Couldn't upload book - please try again later";
                    }
                }
            }
        } else if (($_FILES["file"]["size"] > 1000000)) {
            $error = "Image too large";
        }
    }
	// If there is an error, display the error and stop running the code
    if($error != "") {
        echo $error;
        exit();
    }
        
}

// Allow the user to edit the book details when the administrator requests them to do so. Ensure all the form fields are filled with valid information.
if($_GET['action'] == "editBook") {
    $error = "";
    if(!$_POST['bookname']){
        $error = "A book name is required";
    } else if(!$_POST['author']){
        $error = "An author's name is required";
    } else if(!$_POST['publisher']) {
        $error = "A publisher's name is required";
    } else if(!$_POST['isbn']){
        $error = "An ISBN is required";
    } else if(!$_POST['subject'] || $_POST['subject'] == "Choose..."){
        $error = "A subject is required";
    } else if(!$_POST['grade'] || $_POST['grade'] == "Choose..."){
        $error = "A grade is required";
    } else if(!$_POST['curriculum'] || $_POST['curriculum'] == "Choose..."){
        $error = "A curriculum is required";
    } else if(!$_POST['edition']){
        $error = "A book edition is required. Enter 'none' if unavailable.";
    } else if(!$_POST['bookcondition'] || $_POST['bookcondition'] == "Choose..."){
        $error = "The book condition is required";
    } else if(!$_POST['tags']){
        $error = "Tags are required";
    } else if(!$_POST['synopsis']){
        $error = "A synopsis is required";
    } else if(is_numeric($_POST['isbn']) == false || strlen($_POST['isbn'])!= 13 || $_POST['isbn'] < 0 || $_POST['isbn'] != round($_POST['isbn'], 0)) {
        $error = "Please enter a valid ISBN Number";
    } else if(is_numeric($_POST['price']) == false || $_POST['price'] < 0 || $_POST['price'] != round($_POST['price'], 0)) {
        $error = "Please enter a numeric value only for price";
    }
	// If there is an error, display the error and stop running the code
    if($error != "") {
        echo $error;
        exit();
    }
    if($_FILES["file"]["type"] != '')
    {
        $image = mysqli_real_escape_string($link, $_FILES['file']['name']);
        $validextensions = array("jpeg", "jpg", "png");
        $temporary = explode(".", $_FILES["file"]["name"]);
        $file_extension = end($temporary);
        if ((($_FILES["file"]["type"] == "image/png") || ($_FILES["file"]["type"] == "image/jpg") || ($_FILES["file"]["type"] == "image/jpeg")
        ) && ($_FILES["file"]["size"] < 1000000)//Approx. 1 Mb files can be uploaded.
        && in_array($file_extension, $validextensions)) {
            if ($_FILES["file"]["error"] > 0)
            {
                echo "Return Code: " . $_FILES["file"]["error"] . "<br/><br/>";
            }
            else
            {
                if (file_exists("upload/" . $_FILES["file"]["name"])) {
                    echo $_FILES["file"]["name"] . " <span id='invalid'><b>already exists. Change the file name before re-uploading.</b></span> ";
                }
                else
                {
                  // If the image file and book details pass all the error checks, upload the book to the database.
                    $query = "UPDATE books SET bookname='".mysqli_real_escape_string($link, $_POST['bookname'])."', author='".mysqli_real_escape_string($link, $_POST['author'])."', publisher='".mysqli_real_escape_string($link, $_POST['publisher'])."', edition='".mysqli_real_escape_string($link, $_POST['edition'])."', curriculum='".mysqli_real_escape_string($link, $_POST['curriculum'])."', isbn='".mysqli_real_escape_string($link, $_POST['isbn'])."', subject='".mysqli_real_escape_string($link, $_POST['subject'])."', grade='".mysqli_real_escape_string($link, $_POST['grade'])."', bookcondition='".mysqli_real_escape_string($link, $_POST['bookcondition'])."', price='".mysqli_real_escape_string($link, $_POST['price'])."', tags='".mysqli_real_escape_string($link, $_POST['tags'])."', synopsis='".mysqli_real_escape_string($link, $_POST['synopsis'])."', approved='".mysqli_real_escape_string($link, $_POST['approved'])."', image='".$image."', userid='".mysqli_real_escape_string($link, $_SESSION['id'])."' WHERE bookid='".mysqli_real_escape_string($link, $_POST['bookId'])."'";
                    if(mysqli_query($link, $query)) {
                        $sourcePath = $_FILES['file']['tmp_name']; // Storing source path of the file in a variable
                        $targetPath = "upload/".$_FILES['file']['name']; // Target path where file is to be stored
                        move_uploaded_file($sourcePath,$targetPath) ; // Moving Uploaded file
                        echo "<span id='success'>Book details changed successfully.</span><br/>";
                        //echo 1;
                    } else {
                        $error = "Couldn't upload book - please try again later";
                    }
                }
            }
        } else if (($_FILES["file"]["size"] > 1000000)) {
            $error = "Image too large";
        }
    } else {
      // If there is no image type specified, upload the book without an image
        $query = "UPDATE books  SET bookname='".mysqli_real_escape_string($link, $_POST['bookname'])."', author='".mysqli_real_escape_string($link, $_POST['author'])."', publisher='".mysqli_real_escape_string($link, $_POST['publisher'])."', edition='".mysqli_real_escape_string($link, $_POST['edition'])."', curriculum='".mysqli_real_escape_string($link, $_POST['curriculum'])."', isbn='".mysqli_real_escape_string($link, $_POST['isbn'])."', subject='".mysqli_real_escape_string($link, $_POST['subject'])."', grade='".mysqli_real_escape_string($link, $_POST['grade'])."', bookcondition='".mysqli_real_escape_string($link, $_POST['bookcondition'])."', price='".mysqli_real_escape_string($link, $_POST['price'])."', tags='".mysqli_real_escape_string($link, $_POST['tags'])."', synopsis='".mysqli_real_escape_string($link, $_POST['synopsis'])."', approved='".mysqli_real_escape_string($link, $_POST['approved'])."', userid='".mysqli_real_escape_string($link, $_SESSION['id'])."' WHERE bookId='".mysqli_real_escape_string($link, $_POST['bookId'])."'";
        if(mysqli_query($link, $query)) {
            echo "<span id='success'>Book details changed successfully.</span><br/>";
            //echo 1;
        } else {
            $error = "Couldn't update book - please try again later";
        }
    }
	// If there is an error, display the error and stop running the code
    if($error != "") {
        echo $error;
        exit();
    }
        
}

?>