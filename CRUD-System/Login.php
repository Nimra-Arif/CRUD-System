<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
    </style>
</head>

<body>

<div class="container">
    <div class="login-container">
        <div class="login-form">
            <h2 class="text-center">Login</h2>

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
                    <label>Login as:</label>
                    <div class="form-check" >
                        <input type="radio" class="form-check-input" name="role" value="admin" required>
                        <label class="form-check-label">Admin</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" name="role" value="customer">
                        <label class="form-check-label">Customer</label>
                    </div>
                </div>

                <button type="submit" class="btn btn-info login-btn">Login</button>
            </form>
            <div class="SignUp-link">
               Don't have an account? <a href="SignUp.php">SignUp</a>
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

                // Validate credentials against the database
                $sql = "SELECT * FROM $table WHERE username='$username' AND password='$password'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Credentials are valid
                    // Redirect to the appropriate dashboard
                    if ($role === 'admin') {
                        header("Location: AdminDashboard.php");
                    } else {

                        header("Location: Dashboard.php");                  }
                    exit();
                } else {
                    // Invalid credentials
                    echo "Login failed";
                }
            }

            $conn->close();
            ?>

        </div>
    </div>
</div>

</body>

</html>
