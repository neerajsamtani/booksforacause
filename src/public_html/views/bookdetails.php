<div class="container mainContainer">

    <div class="row">
  
        <div class="col-12 col-md-8">
            
        <?php 
          
          // Display all information about the book on its own dedicated page
          // This page opens when a user clicks on the title of a book
          
          if ($_GET['bookid']) { ?>
            
                <?php
            
                global $link;

                $query = "SELECT * FROM books WHERE bookid = ".$_GET['bookid']." LIMIT 1";

                $result = mysqli_query($link, $query);

                if(mysqli_num_rows($result) == 0) {

                        echo "The book could not be found";

                    } else {

                    $row = mysqli_fetch_assoc($result);
                                        
                    echo "<div class='row'>";
                    
                    echo "<div class='col-sm-6'>";
                    
                    echo "<div class='card tweet'><img class='card-img-top' src='";
                        
                    if($row['image'] != null) {

                        echo "upload/".$row['image'];

                    } else {
                      
                      	// If no image is available, display the default "unavailable_image" image

                        echo "https://swapthisbook.com/unavailable_image.jpg";

                    }
                    
                    echo "'><div class='card-body'>";
                    
                    $yourBookQuery = "SELECT * FROM books WHERE userid = ".mysqli_real_escape_string($link, $_SESSION['id'])." AND bookid = ".mysqli_real_escape_string($link, $row['bookid'])." LIMIT 1";

                    $yourBookQueryResult = mysqli_query($link, $yourBookQuery);

                    if(mysqli_num_rows($yourBookQueryResult) > 0) {
                        
                        if($row['approved']==0)
                            
                        {
                            echo "<p class='alert alert-danger'>Not Approved Yet.</br></br>";
                          
                          	// If the unapproved book belongs to the signed in user, display the admin comments, an "Approved" message, and an "Edit Book" button
                            
                            $yourBookQuery = "SELECT * FROM books WHERE userid = ".mysqli_real_escape_string($link, $_SESSION['id'])." AND bookid = ".mysqli_real_escape_string($link, $row['bookid'])." AND comments !='' LIMIT 1";

                            $yourBookQueryResult = mysqli_query($link, $yourBookQuery);

                            if(mysqli_num_rows($yourBookQueryResult) > 0) {

                                echo "Admin Comments: <em>".$row['comments']."</em></p>";
                                
                                echo "<p><a class='btn btn-primary editBook' data-bookId='".$row['bookid']."' href ='?page=editbook&bookid=".$row['bookid']."'>Edit Book Details</a></p>";

                            }
                            
                        } else {
                          
                          	// If the approved book belongs to the signed in user, display the admin comments and an "Approved" message
                        
                            echo "<p class='alert alert-success'>Approved <p>";
                                                        
                            echo '<button class="btn btn-success my-2 my-sm-0" data-toggle="modal" data-target="#soldModal" data-bookid="'.$row["bookid"].'">Mark as sold</button>';
                            
                            echo '    <div class="modal fade" id="soldModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="soldModalTitle">Are you sure?</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                      <div class="modal-body">
                                        <form>
                                            <div class="hiddeninput"><input type="hidden" name="bookid" id="bookid"></div>
                                            </form>
                                            <button type="button" class="btn btn-success" id="soldButton">Yes</button>
                                             <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                      </div>
                                    </div>
                                  </div>
                                </div>'; 
                                }
                        
                                                
                    } else {
                      
                      	// If the approved book doesnt belong to the signed in user, display a "Mark as Sold" button and an "Add to Cart" Button
                      	// Only approved books can be viewed by the public
                        
                        echo "<p><a class='btn btn-primary toggleCart' data-bookId='".$row['bookid']."'>";

                        $cartQuery = "SELECT * FROM cart WHERE userid = ".mysqli_real_escape_string($link, $_SESSION['id'])." AND bookid = ".mysqli_real_escape_string($link, $row['bookid'])." LIMIT 1";

                        $cartQueryResult = mysqli_query($link, $cartQuery);
                      
                      	// If the book is in the user's cart, display a "Remove from Cart" button
                      	// Otherwise display an "Add to Cart" button

                        if(mysqli_num_rows($cartQueryResult) > 0) {

                            echo "Remove From Cart";

                        } else {

                            echo "Add To Cart";

                        }

                        echo "</a></p>";
                        
                        echo '<form>
                              <div class="form-group">
                                <input type="hidden" name="page" value="messenger">
                                <input type="hidden" name="sellerId" value="'.$row["userid"].'">
                              </div>
                            <button type="submit" class="btn btn-secondary">Contact Seller</button>
                            </form>';
                                                }
                    
                    echo "</div></div>";
    
                    echo "</div>";
    
                    echo "<div class='col-sm-6'>";    
    
                    echo "<div class='card tweet'>";
                    
                    echo "<div class='card-body'>";
                    
                    echo "<h2 class='card-title'> ".$row['bookname']."</h2>";

                    echo "<p class='card-subtitle text-muted'> by ".$row['author']."</p>";
    
                    echo "<p class='card-text'> ".$row['bookcondition']."</p>";
    
                    echo "<p class='card-text'>Subject: ".$row['subject']."</p>";
    
                    echo "<p class='card-text'> Curriculum: ".$row['curriculum']."</p>";

                    echo "<p class='card-text'>Grade ".$row['grade']."</p>";

                    echo "<p class='card-text'> ".$row['price']." AED</p>";

                    echo "<p class='card-text'>Additional Information: ".$row['synopsis']."</p>";

                    echo "<p class='card-text'> Publisher: ".$row['publisher']."</p>";
    
                    echo "<p class='card-text'> Edition: ".$row['edition']."</p>";

                    echo "<p class='card-text'> ISBN: ".$row['isbn']."</p>";
                    
                    echo "</div></div>";
    
                    echo "</div>";
    
                    echo "</div>";
                }
            
            
            ?>


            
            <?php } else { ?> 
        
                <h2>All Books</h2>
        
                <?php 
                          // If no book id is found, display the titles of all books uploaded
                          
                          displayBookLinks(); ?>
            
            <?php } ?>
      
        </div>
  
        <div class="col-12 col-md-4">
      
            <?php displaySearch(); ?>
        
        </div>

    </div>

</div>