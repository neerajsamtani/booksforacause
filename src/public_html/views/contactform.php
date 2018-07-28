<?php

    $error = ""; $successMessage = "";

	// Ensure all the form fields are filled and all data is valid

    if ($_POST) {
            
        if (!$_POST["content"]) {
            
            $error .= "The content field is required.<br>";
            
        }
        
        if (!$_POST["subject"]) {
            
            $error .= "The subject is required.<br>";
            
        }    
        
        if ($error != "") {
            
            $error = '<div class="alert alert-danger" role="alert"><p>There were error(s) in your form:</p>' . $error . '</div>';
            
        } else {
          
          	// If there are no errors, send the email to developer@swapthisbook.com
            
            $emailTo = "developer@swapthisbook.com";
            
            $subject = mysqli_real_escape_string($link, $_POST['subject']);
            
            $content = mysqli_real_escape_string($link, $_POST['content']);
            
            $emailFrom = getEmail($_SESSION['id']);
            
            $headers = "From: ".$emailFrom;
            
            if (mail($emailTo, $subject, $content, $headers)) {
                
                $successMessage = '<div class="alert alert-success" role="alert">Your message was sent, we\'ll get back to you ASAP!</div>';
                
                
            } else {
                
                $error = '<div class="alert alert-danger" role="alert"><p><strong>Your message couldn\'t be sent - please try again later</div>';
                
                
            }
            
        }
        
        
        
    }

?>
      
<!-- HTML of "Contact the Developer" page -->
<div class="container mainContainer">
    <div class="row">
    <div class="col-12 col-md-2"></div>
    <div class="col-12 col-md-8">
      
    <h1>Contact us</h1>
    <h6 class="text-muted">If you've faced any issues with the website, this is where you can let us know.</h6>
      <br>
      <h6 class="text-muted">Kindly note that the developer has no control over which books are available on the website.</h6>
      <h6 class="text-muted">If a book you're looking for is currently unavailable, you will have to check back later.</h6>
        <br>
      
      <div id="error"><? echo $error.$successMessage; ?></div>
      
      <form method="post">
  <fieldset class="form-group">
    <label for="subject">Subject</label>
    <input type="text" class="form-control" id="subject" name="subject" >
  </fieldset>
  <fieldset class="form-group">
    <label for="exampleTextarea">What would you like to ask us?</label>
    <textarea class="form-control" id="content" name="content" rows="3"></textarea>
  </fieldset>
          <p><small class="text-muted">Expect a response by email within 3 days.</small></p>
  <button type="submit" id="submit" class="btn btn-primary">Submit</button>
</form>
          
        </div> </div> </div>

    <!-- jQuery first, then Bootstrap JS. -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.2/js/bootstrap.min.js" integrity="sha384-vZ2WRJMwsjRMW/8U7i6PWi6AlO1L79snBrmgiDpgIWJ82z8eA5lenwvxbMV1PAh7" crossorigin="anonymous"></script>
          
          
    <script type="text/javascript">
      
      	  // Ensure all the form fields are filled and all data is valid
          
          $("form").submit(function(e) {
              
              var error = "";
              
              if ($("#subject").val() == "") {
                  
                  error += "The subject field is required.<br>"
                  
              }
              
              if ($("#content").val() == "") {
                  
                  error += "The content field is required.<br>"
                  
              }
              
              if (error != "") {
                  
                 $("#error").html('<div class="alert alert-danger" role="alert"><p><strong>There were error(s) in your form:</strong></p>' + error + '</div>');
                  
                  return false;
                  
              } else {
                  
                  return true;
                  
              }
          })
          
    </script>