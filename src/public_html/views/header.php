<!DOCTYPE html>
<html lang="en">
  
  <head>
    
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>Buy and Sell Textbooks</title>
        <meta name="description" content="Connect with nearby students to buy and sell used books and save money for the next school year.">
        <meta name="keywords" content="Trade,Exchange,Textbook,Buy,
        Book,Sell,Dubai,Sale,School,Cheap,Upload,GMA,Online,Nearby">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
      <link rel="stylesheet" href="https://swapthisbook.com/styles.css">
      <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
  </head>
  <body>
    
    
  <!-- This code decides the content of the navigation bar at the top -->    
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
        
  <a class="navbar-brand" href="https://swapthisbook.com/">Swap This Book</a>
        
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    
    <span class="navbar-toggler-icon"></span>
    
  </button>
          
            <div class="collapse navbar-collapse" id="navbarSupportedContent">

                
        <?php // If the user is logged in, display the following in the navigation bar
              if ($_SESSION['id']){ ?>      
                
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                <a class="nav-link" href="?page=recentbooks">Recent Books</a>
              </li>
                    <li class="nav-item">
                <a class="nav-link" href="?page=addbook">Add a book</a>
              </li>
                <li class="nav-item">
                <a class="nav-link" href="?page=yourbooks">My Books</a>
              </li>
                <li class="nav-item">
                <a class="nav-link" href="?page=mycart">My Cart</a>
              </li>
                <li class="nav-item">
                <a class="nav-link" href="?page=publicprofiles">Connect with Students</a>
              </li>                    
                <li class="nav-item">
                <a class="nav-link" href="?page=contactform">Contact the Developer</a>
              </li>
                <li class="nav-item">
                <a class="nav-link" href="?page=siteguide">Site Guide</a>
              </li>
            </ul>
            <div class="form-inline my-2 my-lg-0">                

                
                <a class="btn dropdown">
                    <div class="btn-group">
                      <button type="button" class="btn btn-primary dropdown-toggle notification-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <span class="badge badge-light count"></span>
                           Notifications
                      </button>
                      <div class="dropdown-menu scrollable-menu notification-list">
                      </div>
                    </div>
                </a>                
                
                <a class="btn btn-outline-success my-2 my-sm-0" href="?function=logout">Logout</a>
            
        <?php // If the user is not logged in, display a login button only on the naviagtion bar
             } else { ?>   
                
            <ul class="navbar-nav mr-auto"></ul>
              
            <div class="form-inline my-2 my-lg-0">

            <button class="btn btn-primary my-2 my-sm-0" data-toggle="modal" data-target="#loginModal">Log In</button>
                
        
        <?php } ?>
        
        
  </div>
  </div>
</nav>