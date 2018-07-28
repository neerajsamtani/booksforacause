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

	// Display the search bar using HTML
    function displaySearch() {
        echo '<form>
  				<div class="form-group">
    				<input type="hidden" name="page" value="search">
    				<input type="text" name="q" class="form-control" id="search" placeholder="Custom Search">
    				</br>
      				<div class="form-row">
                		<div class="form-group col-md-6">
                  			<select class="form-control subject" id="inlineFormCustomSelect" name="subject" placeholder="Custom Search">
                              <option selected value="">Subject</option>
                              <option value="Art">Art</option>
                              <option value="Biology">Biology</option>
                              <option value="Business Management">Business Management</option>
                              <option value="Chemistry">Chemistry</option>
                              <option value="Commerce">Commerce</option>
                              <option value="Computer Science">Computer Science</option>
                              <option value="Economics">Economics</option>
                              <option value="English">English</option>
                              <option value="Environmental Science">Environmental Science</option>
                              <option value="Exam Guide">Exam Guide</option>
                              <option value="Foreign Language">Second Language</option>
                              <option value="Geography">Geography</option>
                              <option value="History">History</option>
                              <option value="Mathematics">Mathematics</option>
                              <option value="Music">Music</option>
                              <option value="Physics">Physics</option>
                              <option value="SAT">SAT Guide</option>
                              <option value="Other">Other</option>
                  			</select>
                  		</div>
                		</br>
                		<div class="form-group col-md-6">
                          <select class="form-control subject" id="inlineFormCustomSelect" name="grade">
                            <option selected value="">Grade</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                            <option value="Other">Other</option>
                          </select>
              			</div>
              		</div>
              		<div class="form-row">
                		<div class="form-group col-md-6">
                  			<select class="form-control curriculum" id="inlineFormCustomSelect" name="curriculum">
                              <option selected value="">Curriculum</option>
                              <option value="AP">AP</option>
                              <option value="IB">IB</option>
                              <option value="ICSE">ICSE</option>
                              <option value="ISC">ISC</option>
                              <option value="MYP">MYP</option>
                              <option value="Standardized Test">Standardized Test</option>
                              <option value="Other">Other</option>
                            </select>
                  		</div>
                  	</div>
  				</div>
                <button type="submit" class="btn btn-primary">Search Books</button>
				</form>';
    }

    // Get the user's name from the database
	function getName($userId) {
        global $link;
        $userQuery = "SELECT * FROM users WHERE id = ".$userId;
        $userQueryResult = mysqli_query($link, $userQuery);     
        $user = mysqli_fetch_assoc($userQueryResult);
        return $user['fname']." ".$user['lname'];
    }

	// Get the user's email id from the database
    function getEmail($userId) {
        global $link;
        $userQuery = "SELECT * FROM users WHERE id = ".$userId;
        $userQueryResult = mysqli_query($link, $userQuery);       
        $user = mysqli_fetch_assoc($userQueryResult);
        return $user['email'];
    }

	// Find out who the book belongs to
    function getUserId($bookId) {
        global $link;
        $userQuery = "SELECT * FROM books WHERE bookid = ".$bookId;
        $userQueryResult = mysqli_query($link, $userQuery);          
        $user = mysqli_fetch_assoc($userQueryResult);
        return $user['userid'];
    }

	// Display all users except the current user
    function displayUsers() {
        global $link;
        $query = "SELECT * FROM users where id !=".$_SESSION['id'];
        $result = mysqli_query($link, $query);  
        while($row = mysqli_fetch_assoc($result)) {
        	echo "<p><a href ='?page=messenger&sellerId=".$row['id']."'>".getName($row['id'])."</a></p>";   
        }
    }

	// One of the most important functions of the website. In depth comments are written in the function.
	// Displays only the books that the user wants to see by altering the WHERE condition of the SQL query
	function displayBooks($type) {
        global $link;
        if($type == 'public') {
       		// All books displayed to the user have to be approved by the administrator
        	$whereClause = "WHERE approved = 1";            
        } else if($type == 'myCart') {
        	// Select all books from the user's cart
            $query = "SELECT * FROM cart WHERE userid = ".mysqli_real_escape_string($link, $_SESSION['id']);
            $result = mysqli_query($link, $query);
            $whereClause = "";
            while ($row = mysqli_fetch_assoc($result)) {
                if($whereClause == "") {
                    $whereClause = "WHERE" ;
                } else {
                    $whereClause.= " OR ";
                }
                $whereClause.= " bookid = ".$row['bookid'];
            }
            // If there were no books returned from the query, display no books (userid = 0 has no books)
            if($whereClause == "") {
                $whereClause = "WHERE userid = 0";
            }
            $whereClause.= " AND approved = 1 ";
        } else if($type == 'yourbooks') {
          	// Select all books that the user has uploaded themself
            $whereClause = "WHERE userid =".mysqli_real_escape_string($link, $_SESSION['id']); 
        } else if($type == 'admin') {
          	// Select all unapproved books. This option is only available to the administrator
            $whereClause = "WHERE approved = 0";
        } else if($type == 'search') {
          	// Select all books relevant to the search by combining what the user has entered into the search bar and the filters they have selected from the dropdown menu
            echo "<p>Showing search results for '".mysqli_real_escape_string($link, $_GET['q'])." ".mysqli_real_escape_string($link, $_GET['subject'])." ".mysqli_real_escape_string($link, $_GET['curriculum'])." ".mysqli_real_escape_string($link, $_GET['grade'])." ' :</p>";
            $search = mysqli_real_escape_string($link, $_GET['q'])." ".mysqli_real_escape_string($link, $_GET['subject'])." ".mysqli_real_escape_string($link, $_GET['curriculum'])." ".mysqli_real_escape_string($link, $_GET['grade']);
            $searchTerm = explode(" ",mysqli_real_escape_string($link, $search));
            $x = 0;
            $construct = "";
            foreach($searchTerm as $term){
                $x++;
                if($x==1){
                    $construct.="(bookname LIKE '%".$term."%' OR author LIKE '%".$term."%' OR subject LIKE '%".$term."%' OR grade LIKE '%".$term."%' OR curriculum LIKE '%".$term."%' OR publisher LIKE '%".$term."%' OR isbn LIKE '%".$term."%' OR tags LIKE '%".$term."%' OR synopsis LIKE '%".$term."%')";
                } else {
                    $construct.="AND (bookname LIKE '%".$term."%' OR author LIKE '%".$term."%' OR subject LIKE '%".$term."%' OR grade LIKE '%".$term."%' OR curriculum LIKE '%".$term."%' OR publisher LIKE '%".$term."%' OR isbn LIKE '%".$term."%' OR tags LIKE '%".$term."%' OR synopsis LIKE '%".$term."%')";
                }
            }
            if((mysqli_real_escape_string($link, $_GET['curriculum'])) != ""){
                $construct.= "AND curriculum LIKE '%".mysqli_real_escape_string($link, $_GET["curriculum"])."%'";
            }
            if((mysqli_real_escape_string($link, $_GET['grade'])) != ""){
                $construct.= "AND grade LIKE '%".mysqli_real_escape_string($link, $_GET["grade"])."%'";
            }
            if((mysqli_real_escape_string($link, $_GET['subject'])) != ""){
                $construct.= "AND subject LIKE '%".mysqli_real_escape_string($link, $_GET["subject"])."%'";
            }
            $whereClause = "WHERE ".$construct." AND approved = 1";
        }
      	// Now that the WHERE clause has been altered, display all books queried
        $query = "SELECT * FROM books ".$whereClause." ORDER BY datetime DESC LIMIT 30";
        $result = mysqli_query($link, $query);
        if(mysqli_num_rows($result) == 0) {
            echo "There are no books to display";
        } else {
            echo "<div class='row'>";
            while($row = mysqli_fetch_assoc($result)) {
                $userQuery = "SELECT * FROM users WHERE id = ".mysqli_real_escape_string($link, $row['userid'])." LIMIT 1";
                $userQueryResult = mysqli_query($link, $userQuery);
                $user = mysqli_fetch_assoc($userQueryResult);
                echo "<div class='col-sm-4'>";
                echo "<div class='card tweet'><img class='card-img-top' src='";
                if($row['image'] != null) {
                    echo "upload/".$row['image']; 
                } else {
                    echo "https://swapthisbook.com/unavailable_image.jpg";
                }
                echo "'><div class='card-body'><h4 class='card-title'><p><a href ='?page=bookdetails&bookid=".$row['bookid']."'>".$row['bookname']."</a></p></h4>";
                echo "<p class='card-text'> ".$row['subject']."</p>";
              	echo "<p class='card-text'> Grade: ".$row['grade']."</p>";
                echo "<p class='card-text'> ".$row['price']." AED</p>";
                if($row['userid'] != $_SESSION['id']) {
                    echo "<p><a class='btn btn-primary toggleCart' data-bookId='".$row['bookid']."'>";
                    $cartQuery = "SELECT * FROM cart WHERE userid = ".mysqli_real_escape_string($link, $_SESSION['id'])." AND bookid = ".mysqli_real_escape_string($link, $row['bookid'])." LIMIT 1";
                    $cartQueryResult = mysqli_query($link, $cartQuery);
                    if(mysqli_num_rows($cartQueryResult) > 0) {
                        echo "Remove From Cart";
                    } else {
                        echo "Add To Cart";
                    }
                    echo "</a>";
                }
                echo "</div></div></div>";
            }
            echo "</div>";
    	}
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