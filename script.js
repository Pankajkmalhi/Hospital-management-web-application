$(document).ready(function() {
    // Code to be executed when the document is ready
    
    // Example code for JQuery
    $("button").click(function() {
    $("p").toggle();
    });
    
    // Example code for Ajax
    $("#form").submit(function(event) {
    event.preventDefault();
    
    $.ajax({
    url: "submit.php",
    method: "POST",
    data: $(this).serialize(),
    success: function(response) {
    $("#result").html(response);
    }
    });
    });
    });
    
    // Example code for a custom function
    function validateForm() {
    var name = document.forms["myForm"]["name"].value;
    var email = document.forms["myForm"]["email"].value;
    
    if (name == "") {
    alert("Name must be filled out");
    return false;
    }
    
    if (email == "") {
    alert("Email must be filled out");
    return false;
    }
    }
    