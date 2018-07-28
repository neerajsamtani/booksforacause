<div class="container mainContainer">
	
    <div class="row">
      
  		<div class="col-12 col-md-8">
        
        	<h2>Message <?php echo getName($_GET['sellerId']); ?></h2>
      
        	<div id="whitebg"></div>
        
          	<div class="msg-container">
            
            	<div class="msg-area" id="msg-area"></div>

            	<form method="POST" class="msg-form">
                
                  <textarea name="message" class="textarea msginput" name="msginput" id="msginput" placeholder="Enter your message here ... (Press enter to send message)"></textarea>
                  <input type="hidden" class="sellerId" id="sellerId" name="sellerId" value="<?php echo $_GET['sellerId']; ?>">
                
            	</form>
            
            	<div class="container">
            
                  	<div id = "messageSuccess" class = "alert alert-success">Your message was sent</div>
            
                  	<div class="alert alert-danger" id="messageAlert">There was an error. Please try again later.</div>
          
              	</div>
        
        	</div>
      
	</div>

</div>