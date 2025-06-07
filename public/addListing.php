<?php
require_once __DIR__ . '/../config/db.php';


if($_SERVER["REQUEST_METHOD"] == "POST"){
  $name = $_POST["name"];
  $price = $_POST["price"];
  $category = $_POST["category"];
  $sdesc = $_POST["sdesc"];
  $ldesc = $_POST["ldesc"];
  $timestamp = time();
  

  if (isset($_FILES['images']) && $_FILES['images']['error'] === UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['images']['tmp_name'];
    $fileSize = $_FILES['images']['size'];
    $fileName = basename($_FILES['images']['name']);
    $fileType = mime_content_type($fileTmpPath);
    $random = bin2hex(random_bytes(5)); // 10-character random string
    $extension = pathinfo($fileName, PATHINFO_EXTENSION);
    $fileName = $timestamp . '_' . $random . '.' . $extension;

    // Check if the uploaded file is an image
    if (strpos($fileType, 'image') === 0) {
        $uploadDir = 'uploads/' . $category . "/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $destination = $uploadDir . $fileName;

        if (move_uploaded_file($fileTmpPath, $destination)) {
            echo "Image uploaded successfully: <a href=\"$destination\">View</a>";
        } else {
            echo "Error moving the uploaded file.";
        }
    } else {
        echo "Uploaded file is not an image.";
    }
  } else {
      echo "No file uploaded or an error occurred.";
  }

  $ownerName = "mr.beans";




  $sql = "INSERT INTO products(name, price, sdesc, ownerName, category, mimage, aimage) 
          VALUES (?, ?, ?, ?, ?, ?, ?);";
  $insert = mysqli_prepare($conn, $sql);
  $insert->bind_param("sdsssss", $name, $price, $sdesc, $ownerName, $category, $fileName, $fileName);
  $insert->execute() or die("Can't insert into this shit");
  }


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
    <link rel="stylesheet" href="css/add-listing.css">

	 </head>

  <body>

    <div class="container">
      <header class="tm-site-header">
        <h1 class="tm-site-name">Shelf</h1>
        <p class="tm-site-description">Your Online Bookstore</p>

        <nav class="navbar navbar-expand-md tm-main-nav-container">
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#tmMainNav" aria-controls="tmMainNav" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fa fa-bars"></i>
          </button>

          <div class="collapse navbar-collapse tm-main-nav" id="tmMainNav">
            <ul class="nav nav-fill tm-main-nav-ul">
              <li class="nav-item"><a class="nav-link active" href="index.php">Home</a></li>
              <!-- <li class="nav-item"><a class="nav-link" href="#">Catalogs</a></li>
              <li class="nav-item"><a class="nav-link" href="#">Awards</a></li>
              <li class="nav-item"><a class="nav-link" href="team.html">Our Team</a></li> -->
              <li class="nav-item"><a class="nav-link" href="contact.html">Contact Us</a></li>
            </ul>
          </div>
        </nav>

      </header>

      <div class="tm-main-content">
        <section class="tm-margin-b-l">
          <header>
            <h2 class="tm-main-title">Add New Product</h2>
          </header>
      </div>

      <div>
        <form action="addListing.php" method="POST" enctype="multipart/form-data">
          <label for="name">Product Name</label>
          <input type="text" id="name" name="name" required />

          <label for="price">Price ($)</label>
          <input type="number" step="0.01" id="price" name="price" required />

          <label for="category">Category</label>
          <select id="category" name="category" required>
            <option value="" disabled selected>Select a category</option>
            <option value="electronics">Electronics</option>
            <option value="books">Books</option>
            <option value="clothing">Clothing</option>
            <option value="home">Home</option>
            <!-- Add more categories as needed -->
          </select>

          <label for="sdesc">Short Description</label>
          <textarea id="sdesc" name="sdesc" rows="3" required></textarea>

          <label for="ldesc">Detailed Information</label>
          <textarea id="ldesc" name="ldesc" rows="5"></textarea><br/>
          <label for="image">Product Images</label>
          <input type="file" id="image" name="images"><br><br>
         <img id="preview" style="max-width: 300px; margin-top: 10px;" />

          <button type="submit">Add Product</button>
        </form>
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

          const imageInput = document.getElementById("imageInput")
const preview = document.getElementById("preview")

imageInput.addEventListener('change', function(){
  const file = this.files[0];
  if(file){
    const objectUrl = URL.createObjectURL(file)
    preview.src = objectUrl;
  }
})
        </script>

  </body>
</html>
