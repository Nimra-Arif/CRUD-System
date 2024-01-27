<?php
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "productlookup";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'])) {
    if ($_POST['action'] == 'add') {
        // Get other product details from the form
        $productName = $_POST['productName'];
        $productPrice = $_POST['productPrice'];
        $productCategory = $_POST['productCategory'];
        $productDescription = $_POST['productDescription'];

        // Handle the image file
        $targetDir = "images/"; // Specify your target directory
        $targetFile = $targetDir . basename($_FILES["productImage"]["name"]);
        move_uploaded_file($_FILES["productImage"]["tmp_name"], $targetFile);
        $productImage = $targetFile;

        // Insert the data into the database
        $sql = "INSERT INTO products (name, price, category, description, image) VALUES ('$productName', '$productPrice', '$productCategory', '$productDescription', '$productImage')";
        if ($conn->query($sql) === TRUE) {
            // Redirect to prevent form resubmission
            header("Location: AdminDashboard.php");
            exit();
        }
    }
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">

    <style>
        /* Your existing styles */
        .custom-bg { background-color: #e6f7ff; }
        .error-message { color: red; }
    </style>

    <script>
        // JavaScript function to close the "Add Product" form
        function cancelAddProduct() {
            // Redirect back to the Admin Dashboard
            window.location.href = 'AdminDashboard.php';
        }
    </script>
</head>

<body>

<div class="container py-5">
    <div id="productEntrySection">
        <h2>Add Product</h2>
        <form id="addProductForm" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="productName">Product Name:</label>
                <input type="text" class="form-control" name="productName" id="productName" required>
            </div>

            <div class="form-group">
                <label for="productPrice">Product Price:</label>
                <input type="number" class="form-control" name="productPrice" id="productPrice" required>
            </div>

            <div class="form-group">
                <label for="productCategory">Product Category:</label>
                <select class="form-control" name="productCategory" id="productCategory" required>
                    <option value="Electronics">Electronics</option>
                    <option value="Clothes">Clothes</option>
                    <option value="Grocery">Grocery</option>
                </select>
            </div>

            <div class="form-group">
                <label for="productDescription">Product Description:</label>
                <textarea type="text" class="form-control" name="productDescription" id="productDescription" required></textarea>
            </div>

            <div class="form-group">
                <label for="productImage">Product Image:</label>
                <input type="file" class="form-control-file" name="productImage" id="productImage" required>
            </div>

            <input type="hidden" name="action" value="add">
            <button class="btn btn-outline-info" type="submit">Add Product</button>
            <button class="btn btn-outline-secondary" type="button" onclick="cancelAddProduct()">Cancel</button>
        </form>
    </div>
</div>

</body>

</html>
