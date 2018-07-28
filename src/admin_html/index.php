<?php

    include("actions.php");

	// Each page has a standard header and footer. The main content of the page is decided by the value stored in $_GET['page']
	// Admin must be logged in ( $_SESSION['id'] > 0 ) to access any of the pages. The default page is home.php
	// If they are not logged in, they are redirected to the Welcome page

    include("views/header.php");

    if($_GET['page'] == 'contactform' && $_SESSION['id'] > 0) {
        
        include("views/contactform.php");

    } else if($_GET['page'] == 'recentbooks' || $_SESSION['id'] > 0) {
        
        include("views/recentbooks.php");

    } else {
        
        include("views/home.php");
        
    }

    include("views/footer.php");

?>