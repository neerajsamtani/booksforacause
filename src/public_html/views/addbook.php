<div class="container mainContainer">

    <div class="row">
    <div class="col-12 col-md-2"></div>
  	<div class="col-12 col-md-8">
    
    <!-- HTML form to add a new book to the website -->
        
    <h2>Add a book</h2>
        
      <form method="post" enctype="multipart/form-data" id="submitBook">
          
            <input type="hidden" name="size" value="1000000">
            <input type="hidden" name="approved" id="approved" value="0">
            <div class="form-row">
                <div class="form-group col-md-6">
                <label for="bookname" class="col-form-label">Book Name</label>
                <input type="text" class="form-control bookname" name="bookname" required>                
              </div>
                <div class="form-group col-md-6">
                <label for="author" class="col-form-label">Author</label>
                <input type="text" class="form-control author" aria-describedby="author" name="author" required>
              </div>
            </div>
          
                    <div class="form-row">
                <div class="form-group col-md-6">
                <label class="mr-sm-2" for="inlineFormCustomSelect">Subject</label>
                  <select class="form-control subject" id="inlineFormCustomSelect" name="subject">
                    <option selected>Choose...</option>
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
                <div class="form-group col-md-6">
                    <label class="mr-sm-2" for="inlineFormCustomSelect">Grade</label>
                  <select class="form-control subject" id="inlineFormCustomSelect" name="grade">
                    <option selected>Choose...</option>
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
                <label class="mr-sm-2" for="inlineFormCustomSelect">Curriculum</label>
                  <select class="form-control curriculum" id="inlineFormCustomSelect" name="curriculum">
                    <option selected>Choose...</option>
                    <option value="AP">AP</option>
                    <option value="IB">IB</option>
                    <option value="ICSE">ICSE</option>
                    <option value="ISC">ISC</option>
                    <option value="MYP">MYP</option>
                    <option value="Standardized Test">Standardized Test</option>
                    <option value="Other">Other</option>
                  </select>
                  </div>
                <div class="form-group col-md-6">
                    <label for="edition">Edition</label>
                <input type="text" class="form-control edition" aria-describedby="edition" name="edition" placeholder="Book edition or Year of publication" required>
              </div>
            </div>
          
          <div class="form-row">
                <div class="form-group col-md-6">
                <label for="publisher">Publisher</label>
                <input type="text" class="form-control publisher" aria-describedby="publisher" name="publisher" required>
              </div>
                <div class="form-group col-md-6">
                <label for="isbn">ISBN Number</label>
                <input type="text" class="form-control isbn" aria-describedby="isbn" placeholder="The 13 digit number above the barcode" name="isbn" required>
                <small id="tagsHelpBlock" class="form-text text-muted">
                  If unavailable, enter thirteen 0's.
                </small>
              </div>
            </div>  
          
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="mr-sm-2" for="inlineFormCustomSelect">Book Condition</label>
                  <select class="form-control bookcondition" id="inlineFormCustomSelect" name="bookcondition">
                    <option selected>Choose...</option>
                    <option value="Used a lot">Used a lot</option>
                    <option value="Slightly Used">Slightly Used</option>
                    <option value="Almost New">Almost New</option>
                    <option value="Brand New">Brand New</option>
                  </select>
              </div>
                <div class="form-group col-md-6">
                <label for="image">Upload a picture </label>
                  <label class="custom-file">
                      <input type="file" name="file" id="file" class="custom-file-input file" required>
                      <span class="custom-file-control"></span>
                    </label>
              </div>
            </div>
          
          
          
          
            <div class="form-row">
                <div class="form-group col-md-6">
                <label for="price" class="col-form-label">Price in AED</label>
                <input type="text" class="form-control price" aria-describedby="price" name="price" required>
                <small id="tagsHelpBlock" class="form-text text-muted">
                  Should be between 5 and 50 AED
                </small>
              </div>
                <div class="form-group col-md-6">
                <label for="tags">Tags to help users search for your book</label>
                    <input type="text" class="form-control tags" aria-describedby="tags" name="tags" required>
                    <small id="tagsHelpBlock" class="form-text text-muted">
                      Enter no more than five tags and separate each with a space.
                    </small>
              </div>
            </div>
                
          
          <div class="form-group">
            <label for="synopsis">Synopsis/Additional Comments</label>
            <textarea class="form-control synopsis" id="synopsis" rows="3" name="synopsis" required></textarea>
          </div>
          
          <div class="container">
            <div id = "bookSuccess" class = "alert alert-success">Your book was uploaded successfully</div>
            <div id = "tweetFail" class = "alert alert-danger"></div>
            <div class="alert alert-danger" id="bookAlert"></div>
            <div class="alert alert-primary" role="alert" id="loading">
              Uploading your book. This might take a while... (Don't refresh the page)
            </div>
          </div>
          <input type="submit" value="Upload" class="submit btn btn-primary" id="xpostBookButton" />
        </form>
      
        <div id="message"></div>
        </div>
        
</div>
</div>