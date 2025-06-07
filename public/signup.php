<?php
require_once __DIR__ . '/../config/db.php';


?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>PL - Your Online Public Listing Website</title>

    <!-- load stylesheets -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400"> 
    <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">                
    <link rel="stylesheet" href="css/bootstrap.min.css">                                      
    <link rel="stylesheet" href="css/tooplate-style.css">                                   
    <link rel="stylesheet" href="css/login-page.css">                                   


	 </head>

  <body>

    <div class="container">
      <header class="tm-site-header">
        <h1 class="tm-site-name">PL</h1>
        <p class="tm-site-description">Your Online Public Listings Website</p><br/><br/>

        <nav class="navbar navbar-expand-md tm-main-nav-container">
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#tmMainNav" aria-controls="tmMainNav" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fa fa-bars"></i>
          </button>

          <div class="collapse navbar-collapse tm-main-nav" id="tmMainNav">
            <ul class="nav nav-fill tm-main-nav-ul">
              <li class="nav-item"><a class="nav-link active" href="index.php">Home</a></li>
              <li class="nav-item"><a class="nav-link" href="contact.html">Contact Us</a></li>
            </ul>
          </div>
        </nav>

      </header>

      <div class="tm-main-content">
        <div class="login-container">
            <form class="login-form">
            <h2>Sign Up</h2>
            <input type="text" placeholder="Full Name" required />
            <input type="tel" placeholder="Phone Number" required />
            <input type="text" placeholder="Username" required />
            <input type="password" placeholder="Password" required />
            <button type="submit">Create Account</button>
            <p class="signup-link">Already have an account? <a href="login.php">Login</a></p>
            </form>
        </div>
      </div>

      <footer>
          Copyright &copy; <span class="tm-current-year">2018</span> Nobody.

          - Designed by <a href="https://www.facebook.com/" target="_parent">The Group</a>
      </footer>
      
    </div>

    <!-- load JS files -->
    <script src="js/jquery-1.11.3.min.js"></script>         <!-- jQuery (https://jquery.com/download/) -->
    <!--
        <script src="js/popper.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        -->
        <script>

          $(document).ready(function(){

              // Update the current year in copyright
              $('.tm-current-year').text(new Date().getFullYear());

          });

        </script>

  </body>
</html>
