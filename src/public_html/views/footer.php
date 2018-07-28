<nav class="navbar navbar-light fixed-bottom bg-light footer">
    <div class="container">
        <p>GEMS Modern Academy | Neeraj Samtani</p>
    </div>
</nav>    

<!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>

	<!-- Display the login pop-up window. These windows are known as "modals". -->
    <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="loginModalTitle">Log In</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="alert alert-danger" id="loginAlert"></div>
      <div class="modal-body">
        <form>
            <input type="hidden" name="loginActive" id="loginActive" value="1">
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter email">
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" placeholder="Password">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="loginButton">Log In</button>
      </div>
    </div>
  </div>
</div>

	<!-- Display the sign up pop-up window. These windows are known as "modals". -->
    <div class="modal fade" id="signupModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="signupModalTitle">Sign Up</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="alert alert-danger" id="signupAlert"></div>
      <div class="modal-body">
        <form>
            <input type="hidden" name="loginActive" class="loginActive" value="0">
            <div class="form-row">
                <div class="form-group col-md-6">
                <label for="fname" class="col-form-label">First Name</label>
                <input type="text" class="form-control fname" aria-describedby="firstName" placeholder="First Name">
              </div>
                <div class="form-group col-md-6">
                <label for="lname" class="col-form-label">Last Name</label>
                <input type="text" class="form-control lname" aria-describedby="lastName" placeholder="Last Name">
              </div>
            </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control email" aria-describedby="emailHelp" placeholder="Enter email">
          </div>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="password">Password</label>
                <input type="password" class="form-control password" placeholder="Password">
              </div>
                <div class="form-group col-md-6">
                <label for="confirmPassword">Confirm Password</label>
                <input type="password" class="form-control confirmPassword" placeholder="Confirm password">
              </div>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="signupButton">Sign Up</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
    
  	// Replace the input symbols with the corresponding HTML code so that it displays correctly on screen
    function escapehtml(text) {
      return text
          .replace(/&/g, "&amp;")
          .replace(/</g, "&lt;")
          .replace(/>/g, "&gt;")
          .replace(/"/g, "&quot;")
          .replace(/'/g, "&#039;");
    }
    
  	// Load the users chat messages when the page loads and every 1000 milliconds
    loadChat();
    setInterval(function(){
        loadChat();
    }, 1000);
    
  	// Call the action "login" (from actions.php) if the user clicks the loginButton
    $("#loginButton").click(function(){
        $.ajax({
            type: "POST",
            url: "actions.php?action=login",
            data: "email=" + $("#email").val() + "&password=" +  $("#password").val() + "&loginActive=" + $("#loginActive").val(),
            success: function(result) {
                if(result == "1") {
                    window.location.assign("https://swapthisbook.com/");
                } else {
                    $("#loginAlert").html(result).show();
                }  
            }
        })
    })
    
    // Call the action "signup" (from actions.php) if the user clicks the signupButton
    $("#signupButton").click(function(){
        $.ajax({
            type: "POST",
            url: "actions.php?action=signup",
            data: "fname=" + $(".fname").val() + "&lname=" + $(".lname").val() + "&email=" + $(".email").val() + "&password=" +  $(".password").val() + "&confirmPassword=" + $(".confirmPassword").val() + "&loginActive=" + $(".loginActive").val(),
            success: function(result) {
                if(result == "1") {
                    window.location.assign("https://swapthisbook.com/?page=siteguide");
                } else {
                    $("#signupAlert").html(result).show();
                }
            }
        })
    })
    
    // Call the action "toggleCart" (from actions.php) if the user clicks toggleCart Button
    $(".toggleCart").click(function() {
        var id= $(this).attr("data-bookId");
        $.ajax({
            type: "POST",
            url: "actions.php?action=toggleCart",
            data: "bookId=" + id,
            success: function(result) {
                if(result == "1") {
                    $("a[data-bookId='" + id + "']").html("Add to Cart");
                } else if(result == "2") {
                    $("a[data-bookId='" + id + "']").html("Remove From Cart");
                }
            }
        })
    })
    
    // Call the action "sold" (from actions.php) if the user clicks the soldButton
    $("#soldButton").click(function(){
        $.ajax({
            type: "POST",
            url: "actions.php?action=sold",
            data: "bookId=" + $("#bookid").val(),
            success: function(result) {
                if(result == "1") {
                    window.location.assign("https://swapthisbook.com/?page=yourbooks");
                } else {
                    $("#soldAlert").html(result).show();
                }
            }
        })
    })
    
    $('#soldModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget)
      var id = button.data('bookid')
      var modal = $(this)
      modal.find('.hiddeninput input').val(id)
    })
    
    	// Call the action "postBook" (from actions.php) if the user clicks the postBookButton
        $("#postBookButton").click(function(){
            $.ajax({
            type: "POST",
            url: "actions.php?action=postBook",
            data: "bookname=" + $(".bookname").val() + "&author=" + $(".author").val() + "&publisher=" + $(".publisher").val() + "&edition=" + $(".edition").val() + "&curriculum=" + $(".curriculum").val() + "&isbn=" + $(".isbn").val() + "&subject=" +  $(".subject").val() + "&grade=" +  $(".grade").val() + "&bookcondition=" +  $(".bookcondition").val() + "&price=" + $(".price").val() + "&tags=" + $(".tags").val() + "&synopsis=" + $(".synopsis").val()+ "&approved=" + $(".approved").val()+ "&image=" + $(".image").val(),
            success: function(result) {
                if(result == "1") {
                    window.location.assign("https://swapthisbook.com/");
                } else {
                    $("#bookAlert").html(result).show();
                }
            }
        })
            
        
    })
    
    // Display loading, success, or error messages while uploading the book
    $("#submitBook").on('submit',(function(e) {
    e.preventDefault();
    $("#message").empty();
    $('#loading').show();
    $.ajax({
        url: "actions.php?action=postBook", // Url to which the request is send
        type: "POST",             // Type of request to be send, called as method
        data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
        contentType: false,       // The content type used when sending data to the server.
        cache: false,             // To unable request pages to be cached
        processData:false,        // To send DOMDocument or non processed data file it is set to false
        success: function(data)   // A function to be called if request succeeds
        {
            if ( data == "<span id='success'>Book Uploaded Successfully! Check the 'My Books' section for approval status or admin comments.</span><br/>") {
                $('#loading').hide();
                $("#bookSuccess").html(data).show();
                $("#bookAlert").hide();
            } else {
                $('#loading').hide();
                $("#bookAlert").html(data).show();
                $("#bookSuccess").hide();
            }
        }
    });
    }));
    
  	// Display loading, success, or error messages while editing the book details
    $("#editBook").on('submit',(function(e) {
    e.preventDefault();
    $("#message").empty();
    $('#loading').show();
    $.ajax({
        url: "actions.php?action=editBook", // Url to which the request is send
        type: "POST",             // Type of request to be send, called as method
        data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
        contentType: false,       // The content type used when sending data to the server.
        cache: false,             // To unable request pages to be cached
        processData:false,        // To send DOMDocument or non processed data file it is set to false
        success: function(data)   // A function to be called if request succeeds
        {
            if ( data == "<span id='success'>Book details changed successfully.</span><br/>") {
                $('#loading').hide();
                $("#bookSuccess").html(data).show();
                $("#bookAlert").hide();
            } else {
                $('#loading').hide();
                $("#bookAlert").html(data).show();
                $("#bookSuccess").hide();
            }
        }
    });
    }));
    
  	// Get element by id
    function _(el){
        return document.getElementById(el);
    }
    
  	// Automatically scroll to the latest part of a user's chat
    $(document).ready( function () {
      $(".msg-area").animate({ scrollTop: $('.msg-area').prop("scrollHeight")}, 1000);
    });
    
    function loadChat(){
        $.ajax({
        url: "actions.php?action=getMessages", // Url to which the request is send
        type: "POST",             // Type of request to be send, called as method
        data: "sellerId=" + $(".sellerId").val(), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
        success: function(data)   // A function to be called if request succeeds
        {
            
            $('.msg-area').html(data);
        }
    });
    }; 
    
  	// When the user hits the "Enter" key, send the message
    $('.msginput').keyup(function(e){
        if(e.which == 13){
            $('.msg-form').submit();
        }
    });
    
  	// Send the user's message
    $(".msg-form").on('submit',(function(e) {
    e.preventDefault();
    var message = $('.msginput').val();
    $.ajax({
        url: "actions.php?action=sendMessage", // Url to which the request is send
        type: "POST",             // Type of request to be send, called as method
        data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
        contentType: false,       // The content type used when sending data to the server.
        cache: false,             // To unable request pages to be cached
        processData:false,        // To send DOMDocument or non processed data file it is set to false
        success: function(data)   // A function to be called if request succeeds
        {
            if ( data == 1) {
                loadChat();
                $('.msginput').val('');
            } else {
                $("#messageAlert").show();
                $("#messageSuccess").hide();
            }
        }
    });
    }));
    
    
  	// When the user clicks on the notification bar, clear the notification counter and load unseen notifications
    $(".notification-dropdown").click(function(){
        $('.count').html('');
    load_unseen_notification('yes');
        });
    
 // Call the action "fetch" (from actions.php) whenever load_unseen_notification is called.
 // This counts the number of unseen notifications and displays the number alongside the notification bar
 function load_unseen_notification(view = '')
 {
  $.ajax({
   url:"actions.php?action=fetch",
   method:"POST",
   data:{view:view},
   dataType:"json",
   success:function(data)
   {
    $('.notification-list').html(data.notification);
    if(data.unseen_notification > 0)
    {
     $('.count').html(data.unseen_notification);
    }
   }
  });
 }
    
  	// Load unseen notifications every 5000 milliseconds
    load_unseen_notification();
    setInterval(function(){
        load_unseen_notification();
    }, 5000);
     
     // Check for validity of information entered in form fields
    (function() {
  "use strict";
  window.addEventListener("load", function() {
    var form = document.getElementById("needs-validation");
    form.addEventListener("submit", function(event) {
      if (form.checkValidity() == false) {
        event.preventDefault();
        event.stopPropagation();
      }
      form.classList.add("was-validated");
    }, false);
  }, false);
}());
    
</script>



  </body>
</html>