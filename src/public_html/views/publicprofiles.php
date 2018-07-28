<div class="container mainContainer">

    <div class="row">
  
        <div class="col-12 col-md-8">
            
            <?php if ($_GET['userid']) { ?>
            
                <?php displayTweets($_GET['userid']); ?>
            
            <?php } else { ?> 
        
                <h2>Active Users</h2>
          
            <h6>Select a user to start chatting with them</h6>
            <br/>
        
                <?php displayUsers(); } ?>
      
        </div>
  
        <div class="col-6 col-md-4">
      
            <?php displaySearch(); ?>
        
        </div>

    </div>

</div>