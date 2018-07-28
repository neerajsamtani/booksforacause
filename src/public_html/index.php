<?php

    include("actions.php");

	// Each page has a standard header and footer. The main content of the page is decided by the value stored in $_GET['page']
	// Users must be logged in ( $_SESSION['id'] > 0 ) to access any of the pages. The default page is recentbooks.php
	// If they are not logged in, they are redirected to the Welcome page

    include("views/header.php");

    if($_GET['page'] == 'yourtweets' && $_SESSION['id'] > 0) {
        
        include("views/yourtweets.php");

    } else if($_GET['page'] == 'publicprofiles' && $_SESSION['id'] > 0) {
        
        include("views/publicprofiles.php");

    } else if($_GET['page'] == 'search' && $_SESSION['id'] > 0) {
        
        include("views/search.php");

    } else if($_GET['page'] == 'messenger' && $_SESSION['id'] > 0) {
        
        include("views/messenger.php");

    } else if($_GET['page'] == 'bookdetails' && $_SESSION['id'] > 0) {
        
        include("views/bookdetails.php");

    } else if($_GET['page'] == 'editbook' && $_SESSION['id'] > 0) {
        
        include("views/editbook.php");

    } else if($_GET['page'] == 'mycart' && $_SESSION['id'] > 0) {
        
        include("views/mycart.php");

    } else if($_GET['page'] == 'yourbooks' && $_SESSION['id'] > 0) {
        
        include("views/yourbooks.php");

    } else if($_GET['page'] == 'contactform' && $_SESSION['id'] > 0) {
        
        include("views/contactform.php");

    } else if($_GET['page'] == 'siteguide' && $_SESSION['id'] > 0) {
        
        include("views/siteguide.php");

    } else if($_GET['page'] == 'addbook' && $_SESSION['id'] > 0) {
        
        include("views/addbook.php");

    } else if($_GET['page'] == 'recentbooks' || $_SESSION['id'] > 0) {
        
        include("views/recentbooks.php");

    } else {
        
        include("views/home.php");
        
    }

    include("views/footer.php");

?>