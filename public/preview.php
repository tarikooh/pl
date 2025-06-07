<?php 
require __DIR__ . "/../config/db.php";

$pid = $_GET['pid'] ?? 'unknown';

$sql = "SELECT * FROM products WHERE pid=?;";
$select = mysqli_prepare($conn, $sql);
$select->bind_param("d", $pid);
$select->execute();
$result = $select->get_result();
$row = mysqli_fetch_assoc($result);

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>PL - Your Online Public Listing Website</title>

    <!-- load stylesheets -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400">  <!-- Google web font "Open Sans" -->
    <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">                <!-- Font Awesome -->
    <link rel="stylesheet" href="css/bootstrap.min.css">                                      <!-- Bootstrap style -->
    <link rel="stylesheet" href="css/tooplate-style.css">                                   <!-- Templatemo style -->

</head>

    <body>
        
        <div class="container">
            <header class="tm-site-header">
            <h1 class="tm-site-name">PL</h1>
            <p class="tm-site-description">Your Online Public Listings Website</p>
                
                <nav class="navbar navbar-expand-md tm-main-nav-container">
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#tmMainNav" aria-controls="tmMainNav" aria-expanded="false" aria-label="Toggle navigation">
                            <i class="fa fa-bars"></i>
                    </button>

                    <div class="collapse navbar-collapse tm-main-nav" id="tmMainNav">
                        <ul class="nav nav-fill tm-main-nav-ul">
                            <li class="nav-item"><a class="nav-link" href="index.php    ">Home</a></li>
                            <li class="nav-item"><a class="nav-link" href="addListing.php">Add Listing</a></li>
                            <li class="nav-item"><a class="nav-link" href="team.html">Our Team</a></li>
                            <li class="nav-item"><a class="nav-link" href="contact.html">Contact Us</a></li>
                        </ul>
                    </div>    
                </nav>
                
            </header>
            
            <div class="tm-main-content no-pad-b">
        <?php
            $name = $row['name'];
            $price = $row['price'];
            $sdesc = $row['sdesc'];
            $ldesc = $row['ldesc'];
            $category = $row['category'];
            $image = $row['mimage'];
            $src = "uploads/" . $category . "/" . $image;

            echo <<<HTML
                <section class="row tm-item-preview">
                    <div class="col-md-6 col-sm-12 mb-md-0 mb-5">
                        <img src=$src alt="Image" class="img-fluid tm-img-center-sm img-prev" width=600, height=700 >
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <h2 class="tm-blue-text tm-margin-b-p">$name</h2>
                        <p class="tm-margin-b-p">$sdesc</p>
                        <p class="tm-margin-b-p">$ldesc</p>
                        <p class="tm-margin-b-p"></p>
                        <p class="tm-blue-text tm-margin-b-s">Price: $price</p>
                        <p class="tm-blue-text tm-margin-b-s">Categories: <a href="#" class="tm-blue-text">$category</a></p>
                        <p class="tm-blue-text tm-margin-b">Rating: <img src="img/star.png" alt="Star image"> <img src="img/star.png" alt="Star image"> <img src="img/star.png" alt="Star image"> <img src="img/star.png" alt="Star image"></p>
                        <a href="#" class="tm-btn tm-btn-gray tm-margin-r-20 tm-margin-b-s">Owner Profile</a><a href="profile.php?" class="tm-btn tm-btn-blue">Phone Number</a>
                    </div>
                </section>
                HTML;
        ?>

                <div class="tm-gallery no-pad-b">
                    <div class="row">
                        <figure class="col-lg-3 col-md-4 col-sm-6 col-12 tm-gallery-item mb-5">
                            <a href="preview.php">
                                <div class="tm-gallery-item-overlay">
                                    <img src="img/image-06.jpg" alt="Image" class="img-fluid tm-img-center">
                                </div>
                                <p class="tm-figcaption no-pad-b">Suspendisse suscipit</p>
                            </a>
                        </figure>
                        <figure class="col-lg-3 col-md-4 col-sm-6 col-12 tm-gallery-item mb-5">
                            <a href="preview.php">
                                <div class="tm-gallery-item-overlay">
                                    <img src="img/image-03.jpg" alt="Image" class="img-fluid tm-img-center">
                                </div>
                                <p class="tm-figcaption no-pad-b">Cras non augue</p>
                            </a>
                        </figure>
                        <figure class="col-lg-3 col-md-4 col-sm-6 col-12 tm-gallery-item mb-5">
                            <a href="preview.php">
                                <div class="tm-gallery-item-overlay">
                                    <img src="img/image-08.jpg" alt="Image" class="img-fluid tm-img-center">
                                </div>
                                <p class="tm-figcaption no-pad-b">Vivamus facilisis</p>
                            </a>
                        </figure> 
                        <figure class="col-lg-3 col-md-4 col-sm-6 col-12 tm-gallery-item mb-5">
                            <a href="preview.php">
                                <div class="tm-gallery-item-overlay">
                                    <img src="img/image-05.jpg" alt="Image" class="img-fluid tm-img-center">
                                </div>
                                <p class="tm-figcaption no-pad-b">Quisque velit</p>
                            </a>
                        </figure>
                    </div>   
                </div>                    
                            
            </div>

            <footer>
                Copyright &copy; <span class="tm-current-year">2018</span> Nobody.

                - Designed by <a href="https://www.facebook.com/" target="_parent">The Group</a>
            </footer> 
        </div>
        
        <!-- load JS files -->
        <script src="js/jquery-1.11.3.min.js"></script>         <!-- jQuery (https://jquery.com/download/) -->
        <!-- <script src="js/popper.min.js"></script>                Popper (https://popper.js.org/) -->
        <!-- <script src="js/bootstrap.min.js"></script>             Bootstrap (https://getbootstrap.com/) -->
        <script>     
       
            $(document).ready(function(){
                
                // Update the current year in copyright
                $('.tm-current-year').text(new Date().getFullYear());

            });

        </script>             

</body>
</html>