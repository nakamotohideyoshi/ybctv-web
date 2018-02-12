<?php /* Template Name: Email Approve Page */ ?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Last Word Emails</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <style>
    .navbar h1 {
      color: #ffffff;
      margin-left: 10px;
    }
    #wpadminbar, #catapult-cookie-bar { display: none !important; }
  </style>
  <script>
  $(document).ready(function () {
      $.ajax({
        url:'/wp-json/email-builder/v1/email?emailId='+ getParameterByName('emailId') + '&prefix='+ getParameterByName('prefix') + '&cache=' + (new Date().getTime()),
        complete: function (response) {
        console.dir(response);
            $('#emails').html(response.responseJSON.Content)
                        .find('a').attr('target', '_blank');
        },
        error: function () {
            $('#emails').html('There was an error!');
        },
    });
  
  function getParameterByName(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}
  });
  </script>
<body>
 <nav class="navbar navbar-inverse">
   <h1>Last Word Emails</h1>
 </nav>
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <div id="emails">
      </div>
    </div> 
  </div>
</body>
</html>