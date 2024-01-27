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
    if ($_POST['action'] == 'delete' && isset($_POST['productId'])) {
        // Delete product from the database
        $productId = $_POST['productId'];
        $deleteSql = "DELETE FROM products WHERE id = '$productId'";
        $conn->query($deleteSql);
    }
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
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">

    <style>
        /* Your existing styles */
        .custom-bg { background-color: #e6f7ff; }
        .error-message { color: red; }
        /* New style to initially hide the product entry section */
        #productEntrySection { display: none; }
        #addProductForm {
            margin-bottom: 30px;
        }
    </style>

    <script>
        // JavaScript function to show/hide the "Add Product" form
        function toggleProductEntrySection() {
            var productEntrySection = document.getElementById("productEntrySection");
            var addButton = document.getElementById("addButton");

            if (productEntrySection.style.display === "none") {
                productEntrySection.style.display = "block";
                addButton.style.display = "none"; // Hide the "Add" button
            } else {
                productEntrySection.style.display = "none";
                addButton.style.display = "block"; // Show the "Add" button
            }
        }

        // JavaScript function to close the "Add Product" form
        function cancelAddProduct() {
            toggleProductEntrySection();
        }
    </script>
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

        <table class="table table-striped table-hover custom-bg  mt-4 text-center ">
            <thead class="thead-light">
            <th>Index</th>
            <th>Product Name</th>
            <th>Product Price</th>
            <th>Product Category</th>
            <th>Product Description</th>
            <th>Image</th>
            <th>Delete</th>
            </thead>
            <tbody id="tableBody">
            <?php
            // Loop through the fetched data and display it in the table
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['name'] . "</td>";
                echo "<td>" . $row['price'] . "</td>";
                echo "<td>" . $row['category'] . "</td>";
                echo "<td>" . $row['description'] . "</td>";
                echo "<td><img src='" . $row['image'] . "' alt='Product Image' style='max-width: 100px; max-height: 100px;'></td>";

                echo "<td><button class='btn btn-outline-danger' onclick='deleteProduct({$row['id']})'>Delete</button></td>";
                echo "</tr>";
            }
            ?>
            </tbody>
        </table>

        <button class="btn btn-outline-info" id="addButton" onclick="window.location.href='add_products.php'">Add</button>
    </div>
</div>

<script>
    function deleteProduct(productId) {
        if (confirm("Are you sure you want to delete this product?")) {
            // Create a form dynamically
            var form = document.createElement('form');
            form.method = 'post';
            form.action = '<?php echo $_SERVER['PHP_SELF']; ?>';

            // Create input fields for data
            var actionInput = document.createElement('input');
            actionInput.type = 'hidden';
            actionInput.name = 'action';
            actionInput.value = 'delete';

            var productIdInput = document.createElement('input');
            productIdInput.type = 'hidden';
            productIdInput.name = 'productId';
            productIdInput.value = productId;

            // Append inputs to the form
            form.appendChild(actionInput);
            form.appendChild(productIdInput);

            // Append form to the body and submit it
            document.body.appendChild(form);
            form.submit();
        }
    }

    function searchByName(productName) {
        var input, filter, table, tr, td, i, txtValue;
        filter = productName.trim().toLowerCase();
        table = document.getElementById("tableBody");
        tr = table.getElementsByTagName("tr");

        var anyProductFound = false;

        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[1]; // Index 1 corresponds to the "Product Name" column
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.trim().toLowerCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                    anyProductFound = true;
                } else {
                    tr[i].style.display = "none";
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
