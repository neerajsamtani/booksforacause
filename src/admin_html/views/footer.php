<nav class="navbar fixed-bottom navbar-light bg-light footer">
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
            <button type="button" class="btn btn-secondary" id="forgotPassword">Forgot Password</button>
            <button type="button" class="btn btn-primary" id="loginButton">Log In</button>
          </div>
        </div>
      </div>
    </div>


<script type="text/javascript">
    
  	// Call the action "login" (from actions.php) if the user clicks the loginButton
    $("#loginButton").click(function(){
        $.ajax({
            type: "POST",
            url: "actions.php?action=login",
            data: "email=" + $("#email").val() + "&password=" +  $("#password").val() + "&loginActive=" + $("#loginActive").val(),
            success: function(result) {
                if(result == "1") {
                    window.location.assign("https://admin.swapthisbook.com/");
                } else {
                    $("#loginAlert").html(result).show();
                }
            }
        })
    })
    
    // Call the action "comment" (from actions.php) if the user clicks the commentButton. This opens a comment modal.
    $("#commentButton").click(function(){
        $.ajax({
            type: "POST",
            url: "actions.php?action=comment",
            data: "bookId=" + $("#bookid").val() + "&bookName=" +  $("#bookname").val() + "&userId=" +  $("#userid").val() + "&comment=" +  $("#comment").val(),
            success: function(result) {
                if(result == "1") {
                    //window.location.assign("https://admin.swapthisbook.com/");
                    $('#commentModal').modal('hide');
                    //change result
                } else {
                    $("#commentAlert").html(result).show();
                }
            }
        })
    })
    // Once the comment modal is open, send data to it.
    $('#commentModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget) // Button that triggered the modal
      var bookid = button.data('bookid')
      var bookname = button.data('bookname')
      var userid = button.data('userid')
      // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
      // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
      var modal = $(this)
      modal.find('.modal-title').text('Add a comment')
      //modal.find('#bookid input').text(' ' + id)
      modal.find('.hiddenbookid input').val(bookid)
      modal.find('.hiddenbookname input').val(bookname)
      modal.find('.hiddenuserid input').val(userid)
    })
    
    // Call the action "rejectBook" (from actions.php) if the user clicks the rejectBook button
    $(".rejectBook").click(function() {
        var id= $(this).attr("data-bookId");
        var bookname= $(this).attr("data-bookname");
        var userid= $(this).attr("data-userid");
        $.ajax({
            type: "POST",
            url: "actions.php?action=rejectBook",
            data: "bookId=" + id + "&bookname=" + bookname + "&userid=" + userid,
            success: function(result) {
                if(result == "1") {
                    $("a[data-bookId='" + id + "']").filter(".rejectBook").html("Deleted");
                } else if(result == "2") {
                    $("a[data-bookId='" + id + "']").filter(".rejectBook").html("Deleted");
                }
            }
        })
    })
    
    // Call the action "toggleApprove" (from actions.php) if the user clicks the toggleApprove button
    $(".toggleApprove").click(function() {
        var id= $(this).attr("data-bookId");
        var bookname= $(this).attr("data-bookname");
        var userid= $(this).attr("data-userid");
        $.ajax({
            type: "POST",
            url: "actions.php?action=toggleApprove",
            data: "bookId=" + id + "&bookname=" + bookname + "&userid=" + userid,
            success: function(result) {
                if(result == "1") {
                    $("a[data-bookId='" + id + "']").filter(".toggleApprove").html("Approve");
                } else if(result == "2") {
                    $("a[data-bookId='" + id + "']").filter(".toggleApprove").html("Unapprove");
                }
            }
        })
    })
    
    // Get element by id
    function _(el){
        return document.getElementById(el);
    }
    
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