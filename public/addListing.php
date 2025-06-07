<?php
require_once __DIR__ . '/../config/db.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $name = $_POST["name"];
    $price = $_POST["price"];
    $category = $_POST["category"];
    $sdesc = $_POST["sdesc"];
    $ldesc = $_POST["ldesc"];
    $timestamp = time();
    
    $uploadedFiles = [];
    $mainImage = '';
    
    // Process multiple file uploads
    if (!empty($_FILES['images']['name'][0])) {
        $uploadDir = 'uploads/' . $category . "/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        $fileCount = count($_FILES['images']['name']);
        for ($i = 0; $i < $fileCount; $i++) {
            if ($_FILES['images']['error'][$i] === UPLOAD_ERR_OK) {
                $fileTmpPath = $_FILES['images']['tmp_name'][$i];
                $fileType = mime_content_type($fileTmpPath);
                
                if (strpos($fileType, 'image') === 0) {
                    $random = bin2hex(random_bytes(5));
                    $extension = pathinfo($_FILES['images']['name'][$i], PATHINFO_EXTENSION);
                    $fileName = $timestamp . '_' . $random . '.' . $extension;
                    $destination = $uploadDir . $fileName;
                    
                    if (move_uploaded_file($fileTmpPath, $destination)) {
                        $uploadedFiles[] = $fileName;
                        if ($i === 0) {
                            $mainImage = $fileName; // First image is main image
                        }
                    }
                }
            }
        }
    }
    
    $ownerName = "mr.beans";
    
    // Convert array of images to comma-separated string for database
    $imagesString = implode(',', $uploadedFiles);
    
    $sql = "INSERT INTO products(name, price, sdesc, ownerName, category, mimage, aimage) 
            VALUES (?, ?, ?, ?, ?, ?, ?);";
    $insert = mysqli_prepare($conn, $sql);
    $insert->bind_param("sdsssss", $name, $price, $sdesc, $ownerName, $category, $mainImage, $imagesString);
    $insert->execute() or die("Error inserting product");
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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400">
    <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/tooplate-style.css">
    <link rel="stylesheet" href="css/add-listing.css">
    <style>
        .image-preview-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 10px;
        }
        .image-preview {
            position: relative;
            width: 100px;
            height: 100px;
        }
        .image-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .remove-btn {
            position: absolute;
            top: 0;
            right: 0;
            background: red;
            color: white;
            border: none;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            cursor: pointer;
        }
        .file-input-group {
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        #add-more-btn {
            margin-bottom: 20px;
        }
    </style>
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
            </section>

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
                    </select>

                    <label for="sdesc">Short Description</label>
                    <textarea id="sdesc" name="sdesc" rows="3" required></textarea>

                    <label for="ldesc">Detailed Information</label>
                    <textarea id="ldesc" name="ldesc" rows="5"></textarea><br/>

                    <label>Product Images</label>
                    <div id="image-inputs-container">
                        <div class="file-input-group">
                            <input type="file" name="images[]" class="image-input" accept="image/*" required>
                            <button type="button" class="remove-btn" onclick="removeImageInput(this)">×</button>
                        </div>
                    </div>
                    <button type="button" id="add-more-btn" class="btn btn-secondary">Add Another Image</button>

                    <div id="preview-container" class="image-preview-container"></div>

                    <button type="submit" class="btn btn-primary">Add Product</button>
                </form>
            </div>

            <footer>
                Copyright &copy; <span class="tm-current-year">2018</span> Nobody.
                - Designed by <a href="https://www.facebook.com/" target="_parent">The Group</a>
            </footer>
        </div>
    </div>

    <!-- load JS files -->
    <script src="js/jquery-1.11.3.min.js"></script>
    <script>
        $(document).ready(function(){
            $('.tm-current-year').text(new Date().getFullYear());
        });

        // Add more image inputs
        document.getElementById('add-more-btn').addEventListener('click', function() {
            const container = document.getElementById('image-inputs-container');
            const newInputGroup = document.createElement('div');
            newInputGroup.className = 'file-input-group';
            newInputGroup.innerHTML = `
                <input type="file" name="images[]" class="image-input" accept="image/*">
                <button type="button" class="remove-btn" onclick="removeImageInput(this)">×</button>
            `;
            container.appendChild(newInputGroup);
        });

        // Remove image input
        function removeImageInput(button) {
            const inputGroups = document.querySelectorAll('.file-input-group');
            if (inputGroups.length > 1) {
                button.parentElement.remove();
            } else {
                alert('You need at least one image.');
            }
        }

        // Preview images
        document.addEventListener('change', function(e) {
            if (e.target.classList.contains('image-input')) {
                const previewContainer = document.getElementById('preview-container');
                previewContainer.innerHTML = '';
                
                const files = [];
                document.querySelectorAll('.image-input').forEach(input => {
                    if (input.files[0]) {
                        files.push(input.files[0]);
                    }
                });
                
                files.forEach(file => {
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        const previewDiv = document.createElement('div');
                        previewDiv.className = 'image-preview';
                        previewDiv.innerHTML = `
                            <img src="${event.target.result}" alt="Preview">
                        `;
                        previewContainer.appendChild(previewDiv);
                    };
                    reader.readAsDataURL(file);
                });
            }
        });
    </script>
</body>
</html>