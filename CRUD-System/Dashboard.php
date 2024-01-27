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

// Fetch product data from the database
$sql = "SELECT * FROM products";
$result = $conn->query($sql);

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">

    <style>
        /* Your existing styles */
        .custom-bg { background-color: #e6f7ff; }
        .error-message { color: red; }
        /* New style for cards */
        .product-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            margin-Left: 5px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: 20px;
            max-width: 350px;
            overflow: hidden;
        }
        .product-card-image {
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 340px;
            max-height: 200px;
        }
    </style>
</head>

<body>

<div class="container py-5">
    <div id="productListSection">
        <div
                style="align-items: center;
        justify-content: space-between;
        display: flex;
"
        >
            <h2>Products</h2>
            <button class="btn btn-outline-warning" id="logoutButton" onclick="window.location.href='SignUp.php'">Logout</button>
        </div>
        <input type="text" class="form-control w-100 m-auto" placeholder="Search By Name" onkeyup="searchByName(this.value)" id="searchInput">
        <p id="noProductFoundText" style="display:none;">No product found.</p>

        <div class="row">
            <?php
            // Loop through the fetched data and display it as cards
            while ($row = $result->fetch_assoc()) {
                echo '<div class="col-md-4">';
                echo '<div class="product-card">';
                echo '<h4>' . $row['name'] . '</h4>';
                echo '<img src="' . $row['image'] . '" alt="Product Image" class="img-fluid product-card-image">';
                echo '<p><strong>Price:</strong> ' . $row['price'] . '</p>';
                echo '<p><strong>Category:</strong> ' . $row['category'] . '</p>';
                echo '<p><strong>Description:</strong> ' . $row['description'] . '</p>';
                echo '</div>';
                echo '</div>';
            }
            ?>
        </div>
    </div>
</div>

<script>
    function searchByName(productName) {
        var input, filter, cards, card, h4, i, txtValue;
        filter = productName.trim().toLowerCase();
        cards = document.getElementsByClassName("product-card");

        var anyProductFound = false;

        for (i = 0; i < cards.length; i++) {
            h4 = cards[i].getElementsByTagName("h4")[0];
            if (h4) {
                txtValue = h4.textContent || h4.innerText;
                if (txtValue.trim().toLowerCase().indexOf(filter) > -1) {
                    cards[i].style.display = "";
                    anyProductFound = true;
                } else {
                    cards[i].style.display = "none";
                }
            }
        }

        // Show/hide "No product found" text based on search results
        var noProductFoundText = document.getElementById("noProductFoundText");

        if (anyProductFound) {
            noProductFoundText.style.display = "none";
        } else {
            noProductFoundText.style.display = "block";
        }
    }
</script>

</body>

</html>

