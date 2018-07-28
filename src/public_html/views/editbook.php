<div class="container mainContainer">
    
    <div class="row">
        
      <div class="col-12 col-md-2"></div>
  
      <div class="col-12 col-md-8">
      
      <?php 
        
      // This function is similar to the addBook function
      // First retrieve the book data from the SQL database and fill the form fields
      // If the user changes any of the book details, update the information in the database
      
      if ($_GET['bookid']) {
    
        global $link;

        $query = "SELECT * FROM books WHERE bookid = ".$_GET['bookid']." LIMIT 1";

        $result = mysqli_query($link, $query);

        if(mysqli_num_rows($result) == 0) {

            echo "The book could not be found";

        } elseif (getUserId($_GET['bookid']) == $_SESSION['id']) {

            $row = mysqli_fetch_assoc($result); 
            
            if($row['approved'] == '1')
            {
                exit("This book has already been approved");
            }

        echo '<h2>Edit book details</h2>
        
      <form method="post" enctype="multipart/form-data" id="editBook">
          
            <input type="hidden" name="size" value="1000000">
            <input type="hidden" name="approved" id="approved" value="0">
          <input type="hidden" name="bookId" id="bookId" value="'.$row['bookid'].'">
            <div class="form-row">
                <div class="form-group col-md-6">
                <label for="bookname" class="col-form-label">Book Name</label>
                <input type="text" class="form-control bookname" name="bookname" value="'.$row['bookname'].'" required>                
              </div>
                <div class="form-group col-md-6">
                <label for="author" class="col-form-label">Author</label>
                <input type="text" class="form-control author" aria-describedby="author" name="author" value="'.$row['author'].'" required>
              </div>
            </div>
          
                    <div class="form-row">
                <div class="form-group col-md-6">
                <label class="mr-sm-2" for="inlineFormCustomSelect">Subject</label>
                  <select class="form-control subject" id="inlineFormCustomSelect" name="subject">
                    
                    <option value="" ';
                    echo $row['subject'] == 'Choose...' ? ' selected="selected"' : '';
                    echo '>Choose...</option>
                    
                    <option value="Art" ';
                    echo $row['subject'] == 'Art' ? ' selected="selected"' : '';
                    echo '>Art</option>
                    
                    <option value="Biology" ';
                    echo $row['subject'] == 'Biology' ? ' selected="selected"' : '';
                    echo '>Biology</option>
                    
                    <option value="Business Management" ';
                    echo $row['subject'] == 'Business Management' ? ' selected="selected"' : '';
                    echo '>Business Management</option>
                    
                    <option value="Chemistry" ';
                    echo $row['subject'] == 'Chemistry' ? ' selected="selected"' : '';
                    echo '>Chemistry</option>
                    
                    <option value="Commerce" ';
                    echo $row['subject'] == 'Commerce' ? ' selected="selected"' : '';
                    echo '>Commerce</option>
                                        
                    <option value="Computer Science" ';
                    echo $row['subject'] == 'Computer Science' ? ' selected="selected"' : '';
                    echo '>Computer Science</option>
                    
                    <option value="Economics" ';
                    echo $row['subject'] == 'Economics' ? ' selected="selected"' : '';
                    echo '>Economics</option>
                    
                    <option value="English" ';
                    echo $row['subject'] == 'English' ? ' selected="selected"' : '';
                    echo '>English</option>
                    
                    <option value="Environmental Science" ';
                    echo $row['subject'] == 'Environmental Science' ? ' selected="selected"' : '';
                    echo '>Environmental Science</option>
                    
                    <option value="Exam Guide" ';
                    echo $row['subject'] == 'Exam Guide' ? ' selected="selected"' : '';
                    echo '>Exam Guide</option>
                    
                    <option value="Foreign Language" ';
                    echo $row['subject'] == 'Foreign Language' ? ' selected="selected"' : '';
                    echo '>Foreign Language</option>
                    
                    <option value="Geography" ';
                    echo $row['subject'] == 'Geography' ? ' selected="selected"' : '';
                    echo '>Geography</option>
                    
                    <option value="History" ';
                    echo $row['subject'] == 'History' ? ' selected="selected"' : '';
                    echo '>History</option>
                    
                    <option value="Mathematics" ';
                    echo $row['subject'] == 'Mathematics' ? ' selected="selected"' : '';
                    echo '>Mathematics</option>
                    
                    <option value="Music" ';
                    echo $row['subject'] == 'Music' ? ' selected="selected"' : '';
                    echo '>Music</option>
                    
                    <option value="Physics" ';
                    echo $row['subject'] == 'Physics' ? ' selected="selected"' : '';
                    echo '>Physics</option>
                    
                    <option value="SAT" ';
                    echo $row['subject'] == 'SAT' ? ' selected="selected"' : '';
                    echo '>SAT</option>
                    
                    <option value="Other" ';
                    echo $row['subject'] == 'Other' ? ' selected="selected"' : '';
                    echo '>Other</option>

                  </select>
                  </div>
                <div class="form-group col-md-6">
                    <label class="mr-sm-2" for="inlineFormCustomSelect">Grade</label>
                  <select class="form-control subject" id="inlineFormCustomSelect" name="grade">
                    <option value="Choose..." ';
                    echo $row['grade'] == 'Choose...' ? ' selected="selected"' : '';
                    echo '>Choose...</option>
                    
                    <option value="1" ';
                    echo $row['grade'] == '1' ? ' selected="selected"' : '';
                    echo '>1</option>
                    
                    <option value="2" ';
                    echo $row['grade'] == '2' ? ' selected="selected"' : '';
                    echo '>2</option>
                    
                    <option value="3" ';
                    echo $row['grade'] == '3' ? ' selected="selected"' : '';
                    echo '>3</option>
                    
                    <option value="4" ';
                    echo $row['grade'] == '4' ? ' selected="selected"' : '';
                    echo '>4</option>
                    
                    <option value="5" ';
                    echo $row['grade'] == '5' ? ' selected="selected"' : '';
                    echo '>5</option>
                    
                    <option value="6" ';
                    echo $row['grade'] == '6' ? ' selected="selected"' : '';
                    echo '>6</option>
                    
                    <option value="7" ';
                    echo $row['grade'] == '7' ? ' selected="selected"' : '';
                    echo '>7</option>
                    
                    <option value="8" ';
                    echo $row['grade'] == '8' ? ' selected="selected"' : '';
                    echo '>8</option>
                    
                    <option value="9" ';
                    echo $row['grade'] == '9' ? ' selected="selected"' : '';
                    echo '>9</option>
                    
                    <option value="10" ';
                    echo $row['grade'] == '10' ? ' selected="selected"' : '';
                    echo '>10</option>
                    
                    <option value="11" ';
                    echo $row['grade'] == '11' ? ' selected="selected"' : '';
                    echo '>11</option>
                    
                    <option value="12" ';
                    echo $row['grade'] == '12' ? ' selected="selected"' : '';
                    echo '>12</option>
                    
                    <option value="Other" ';
                    echo $row['grade'] == 'Other' ? ' selected="selected"' : '';
                    echo '>Other</option>

                  </select>
              </div>
            </div>
          
                              <div class="form-row">
                <div class="form-group col-md-6">
                <label class="mr-sm-2" for="inlineFormCustomSelect">Curriculum</label>
                  <select class="form-control curriculum" id="inlineFormCustomSelect" name="curriculum">
                  
                    <option value="Choose..." ';
                    echo $row['curriculum'] == 'Choose...' ? ' selected="selected"' : '';
                    echo '>Choose...</option>
                    
                    <option value="AP" ';
                    echo $row['curriculum'] == 'AP' ? ' selected="selected"' : '';
                    echo '>AP</option>
                    
                    <option value="IB" ';
                    echo $row['curriculum'] == 'IB' ? ' selected="selected"' : '';
                    echo '>IB</option>
                    
                    <option value="ICSE" ';
                    echo $row['curriculum'] == 'ICSE' ? ' selected="selected"' : '';
                    echo '>ICSE</option>
                    
                    <option value="ISC" ';
                    echo $row['curriculum'] == 'ISC' ? ' selected="selected"' : '';
                    echo '>ISC</option>
                    
                    <option value="MYP" ';
                    echo $row['curriculum'] == 'MYP' ? ' selected="selected"' : '';
                    echo '>MYP</option>
                    
                    <option value="Standardized Test" ';
                    echo $row['curriculum'] == 'Standardized Test' ? ' selected="selected"' : '';
                    echo '>Standardized Test</option>
                    
                    <option value="Other" ';
                    echo $row['curriculum'] == 'Other' ? ' selected="selected"' : '';
                    echo '>Other</option>

                  </select>
                  </div>
                <div class="form-group col-md-6">
                    <label for="edition">Edition</label>
                <input type="text" class="form-control edition" aria-describedby="edition" name="edition" placeholder="Book edition or Year of publication" value="'.$row['edition'].'" required>
              </div>
            </div>
          
          <div class="form-row">
                <div class="form-group col-md-6">
                <label for="publisher">Publisher</label>
                <input type="text" class="form-control publisher" aria-describedby="publisher" name="publisher" value="'.$row['publisher'].'" required>
              </div>
                <div class="form-group col-md-6">
                <label for="isbn">ISBN Number</label>
                <input type="text" class="form-control isbn" aria-describedby="isbn" placeholder="The 13 digit number above the barcode" name="isbn" value="'.$row['isbn'].'" required>
              </div>
            </div>  
          
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="mr-sm-2" for="inlineFormCustomSelect">Book Condition</label>
                  <select class="form-control bookcondition" id="inlineFormCustomSelect" name="bookcondition">
            
                    <option value="Choose..." ';
                    echo $row['bookcondition'] == 'Choose...' ? ' selected="selected"' : '';
                    echo '>Choose...</option>
                    
                    <option value="Used a lot" ';
                    echo $row['bookcondition'] == 'Used a lot' ? ' selected="selected"' : '';
                    echo '>Used a lot</option>
                    
                    <option value="Slightly Used" ';
                    echo $row['bookcondition'] == 'Slightly Used' ? ' selected="selected"' : '';
                    echo '>Slightly Used</option>
                    
                    <option value="Almost New" ';
                    echo $row['bookcondition'] == 'Almost New' ? ' selected="selected"' : '';
                    echo '>Almost New</option>
                    
                    <option value="Brand New" ';
                    echo $row['bookcondition'] == 'Brand New' ? ' selected="selected"' : '';
                    echo '>Brand New</option>

                  </select>
              </div>
                <div class="form-group col-md-6">
                <label for="image">Upload a picture </label>
                  <label class="custom-file">
                      <input type="file" name="file" id="file" class="custom-file-input file">
                      <span class="custom-file-control"></span>
                    </label>
              </div>
            </div>
          
          
          
          
            <div class="form-row">
                <div class="form-group col-md-6">
                <label for="price" class="col-form-label">Price in AED</label>
                <input type="text" class="form-control price" aria-describedby="price" name="price" value="'.$row['price'].'" required>
                <small id="tagsHelpBlock" class="form-text text-muted">
                  We urge you to keep to book free of cost (0 AED)
                </small>
              </div>
                <div class="form-group col-md-6">
                <label for="tags">Tags to help users search for your book</label>
                    <input type="text" class="form-control tags" aria-describedby="tags" name="tags" value="'.$row['tags'].'" required>
                    <small id="tagsHelpBlock" class="form-text text-muted">
                      Enter no more than five tags and separate each with a space.
                    </small>
              </div>
            </div>
                
          
          <div class="form-group">
            <label for="synopsis">Synopsis/Additional Comments</label>
            <textarea class="form-control synopsis" id="synopsis" rows="3" name="synopsis" required>'.$row['synopsis'].'</textarea>
          </div>
          
          <div class="container">
            <div id = "bookSuccess" class = "alert alert-success">The details were changed successfully.</div>
            <div class="alert alert-danger" id="bookAlert"></div>
            <div class="alert alert-primary" role="alert" id="loading">
              Editing the book details. This might take a while... (Do not refresh the page)
            </div>
          </div>
          <!--- <button type="button" class="btn btn-primary" id="postBookButton">Submit</button> --->
          <input type="submit" value="Make Changes" class="edit btn btn-primary" id="xeditBookButton" />
        </form>
      
        <div id="message"></div>
        </div>
        
</div>
</div>';

            } else {
            
          		// If a book id is not found, display all book titles
          
                echo '<h2>All Books</h2>';
        
                displayBookLinks();  
      
            }
          
      } else { 
        
        		// If a book id is not found, display all book titles
        
                echo '<h2>All Books</h2>';
        
                displayBookLinks();
            
               } ?>
        </div>
    </div>
</div>
      ?>