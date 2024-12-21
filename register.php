<?php
// Define variables and initialize with empty values
$username = $email = $password = $bloodGroup = "";
$usernameErr = $emailErr = $passwordErr = $bloodGroupErr = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate Username
    if (empty($_POST["username"])) {
        $usernameErr = "Username is required";
    } else {
        $username = $_POST["username"];
    }

    // Validate Email
    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } else {
        $email = $_POST["email"];
    }

    // Validate Password
    if (empty($_POST["password"])) {
        $passwordErr = "Password is required";
    } else {
        $password = $_POST["password"];
        // Password validation (must have at least one uppercase, one lowercase, and one number)
        if (!preg_match("/[A-Z]/", $password) || !preg_match("/[a-z]/", $password) || !preg_match("/[0-9]/", $password) || strlen($password) < 6) {
            $passwordErr = "Password must have at least one uppercase letter, one lowercase letter, one number, and be at least 6 characters long.";
        }
    }

    // Validate Blood Group
    if (empty($_POST["bloodGroup"]) || $_POST["bloodGroup"] == "Select Blood Group") {
        $bloodGroupErr = "Blood Group is required";
    } else {
        $bloodGroup = $_POST["bloodGroup"];
    }

    // If there are no errors, insert data into the database
    if (empty($usernameErr) && empty($emailErr) && empty($passwordErr) && empty($bloodGroupErr)) {
        // Database connection (Make sure to change the database connection details)
        $servername = "localhost";
        $username_db = "root";
        $password_db = "";
        $dbname = "blood_bank";

        // Create connection
        $conn = new mysqli($servername, $username_db, $password_db, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Insert data into the database
        $sql = "INSERT INTO users (username, email, password, blood_group) VALUES ('$username', '$email', '$password', '$bloodGroup')";

        if ($conn->query($sql) === TRUE) {
            echo "Registration successful!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        // Close connection
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blood Bank System</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
        integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            max-width: 500px;
            margin-top: 50px;
            border-radius: 10px;
            box-shadow: 0 0 100px rgba(0, 0, 0, 0.301);
            padding: 30px;
            background-color: #fff;
        }

        h2 {
            color: #dc3545;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        select.form-control {
            border: 1px solid #ced4da;
            border-radius: 5px;
            padding: 5px;
            width: 100%;
        }

        .btn-primary {
            background-color: #dc3545;
            border: none;
            width: 100%;
            padding: 12px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .btn-primary:hover {
            background-color: #c82333;
        }

        .btn-login {
            background-color: #007bff;
            border: none;
            width: 100%;
            padding: 12px;
            font-weight: bold;
        }

        .btn-login:hover {
            background-color: #0056b3;
        }

        .text-muted {
            font-size: 14px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Registration</h2>
        <form id="registrationForm" action="" method="post">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Enter username"
                    value="<?php echo $username; ?>">
                <small id="usernameError" class="text-danger"><?php echo $usernameErr; ?></small>
            </div>
            <div class="form-group">
                <label for="email">Email address</label>
                <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp"
                    placeholder="Enter email" value="<?php echo $email; ?>">
                <small id="emailHelp" class="form-text text-muted">
                    We'll never share your email with anyone else.
                </small>
                <small id="emailError" class="text-danger"><?php echo $emailErr; ?></small>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Password"
                    value="<?php echo $password; ?>">
                <small id="passwordHelp" class="form-text text-muted">
                    Password must have at least one uppercase letter, one lowercase letter, one number, and be at least 6 characters long.
                </small>
                <small id="passwordError" class="text-danger"><?php echo $passwordErr; ?></small>
            </div>
            <div class="form-group">
                <label for="bloodGroup">Blood Group</label>
                <select class="form-control" id="bloodGroup" name="bloodGroup">
                    <option disabled selected>Select Blood Group</option>
                    <option value="A+" <?php echo $bloodGroup == "A+" ? 'selected' : ''; ?>>A+</option>
                    <option value="A-" <?php echo $bloodGroup == "A-" ? 'selected' : ''; ?>>A-</option>
                    <option value="B+" <?php echo $bloodGroup == "B+" ? 'selected' : ''; ?>>B+</option>
                    <option value="B-" <?php echo $bloodGroup == "B-" ? 'selected' : ''; ?>>B-</option>
                    <option value="AB+" <?php echo $bloodGroup == "AB+" ? 'selected' : ''; ?>>AB+</option>
                    <option value="AB-" <?php echo $bloodGroup == "AB-" ? 'selected' : ''; ?>>AB-</option>
                    <option value="O+" <?php echo $bloodGroup == "O+" ? 'selected' : ''; ?>>O+</option>
                    <option value="O-" <?php echo $bloodGroup == "O-" ? 'selected' : ''; ?>>O-</option>
                </select>
                <small id="bloodGroupError" class="text-danger"><?php echo $bloodGroupErr; ?></small>
            </div>
            <button type="submit" class="btn btn-primary" id="registerButton" name="submit">Register</button>
            <a href="login.html" class="btn btn-login" role="button">Login</a>
        </form>
    </div>
</body>

</html>
