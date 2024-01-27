<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">

    <style>
        body {
            background-color: #e6f7ff;
        }

        .login-container {
            max-width: 400px;
            margin: auto;
            margin-top: 100px;
        }

        .login-form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .login-form label {
            font-weight: bold;
        }

        .login-form input {
            margin-bottom: 15px;
        }

        .login-form .radio-group {
            margin-bottom: 15px;
        }

        .login-btn {
            width: 100%;
        }

        .login-link {
            text-align: center;
            margin-top: 10px;
        }

        .login-link a {
            color: blue;
            text-decoration: underline;
            cursor: pointer;
        }
    </style>
</head>

<body>

<div class="container">
    <div class="login-container">
        <div class="login-form">
            <h2 class="text-center">Sign Up</h2>

            <form method="POST" action="">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>

                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>

                <div class="form-group radio-group">
                    <label>Sign Up as:</label>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" name="role" value="admin" required>
                        <label class="form-check-label">Admin</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" name="role" value="customer">
                        <label class="form-check-label">Customer</label>
                    </div>
                </div>

                <button type="submit" class="btn btn-info login-btn">Sign Up</button>
            </form>

            <div class="login-link">
                Already have an account? <a href="Login.php">Login</a>
            </div>

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

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $username = $_POST['username'];
                $password = $_POST['password'];
                $role = $_POST['role'];

                $table = ($role === 'admin') ? 'admins' : 'customers';

                // Insert user credentials into the database
                $sql = "INSERT INTO $table (username, password, role) VALUES ('$username', '$password', '$role')";
                if ($conn->query($sql) === TRUE) {
                    // Redirect to login page after successful signup
                    header("Location: Login.php");
                    exit();
                } else {
                    // Signup failed
                    echo "Signup failed";
                }
            }

            $conn->close();
            ?>

        </div>
    </div>
</div>

</body>

</html>
