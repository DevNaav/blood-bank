<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blood Bank System</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
        integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <title>Document</title>
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
        <form id="registrationForm" action="register.php" method="post">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Enter username">
                <small id="usernameError" class="text-danger d-none">Username is required</small>
            </div>
            <div class="form-group">
                <label for="email">Email address</label>
                <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp"
                       placeholder="Enter email">
                <small id="emailHelp" class="form-text text-muted">
                    We'll never share your email with anyone
                    else.
                </small>
                <small id="emailError" class="text-danger d-none">Email is required</small>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                <small id="passwordHelp" class="form-text text-muted">
                    Password must have at least one uppercase letter,
                    one lowercase letter, one number, and be at least 6 characters long.
                </small>
                <small id="passwordError" class="text-danger d-none">
                    Password is required and must meet the
                    criteria
                </small>
            </div>
            <div class="form-group">
                <label for="bloodGroup">Blood Group</label>
                <select class="form-control" id="bloodGroup" name="bloodGroup">
                    <option disabled selected>Select Blood Group</option>
                    <option>A+</option>
                    <option>A-</option>
                    <option>B+</option>
                    <option>B-</option>
                    <option>AB+</option>
                    <option>AB-</option>
                    <option>O+</option>
                    <option>O-</option>
                </select>
                <small id="bloodGroupError" class="text-danger d-none">Blood Group is required</small>
            </div>
            <button type="submit" class="btn btn-primary" id="registerButton" name="submit" onclick="register.php">Register</button>
            <a href="login.html" class="btn btn-login" role="button">Login</a>
        </form>
    </div>
    <?php
    // Database connection settings
    $host = "localhost";
    $username = "root";
    $password = "";
    $dbname = "UserRegistration";

    // Create connection
    $conn = new mysqli($host, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    }

    // If form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $user = $_POST['username'];
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $bloodGroup = $_POST['bloodGroup'];

    // Validate input
    if (empty($user) || empty($email) || empty($pass) || $bloodGroup === "Select Blood Group") {
    echo "All fields are required!";
    } else {
    // Hash the password (optional for security)
    $hashedPass = password_hash($pass, PASSWORD_DEFAULT);

    // Prepare and bind SQL statement
    $stmt = $conn->prepare("INSERT INTO users (username, email, password, blood_group) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $user, $email, $hashedPass, $bloodGroup);

    // Execute and check result
    if ($stmt->execute()) {
    echo "Registration successful!";
    } else {
    echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
    }
    }

    // Close the connection
    $conn->close();
    ?>


    <script>
        document.getElementById('registrationForm').addEventListener('submit', function (event) {

            event.preventDefault();


            var username = document.getElementById('username').value.trim();
            var email = document.getElementById('email').value.trim();
            var password = document.getElementById('password').value.trim();
            var bloodGroup = document.getElementById('bloodGroup').value.trim();


            document.getElementById('usernameError').classList.toggle('d-none', username !== '');
            document.getElementById('emailError').classList.toggle('d-none', email !== '');
            document.getElementById('passwordError').classList.toggle('d-none', password !== '');
            document.getElementById('bloodGroupError').classList.toggle('d-none', bloodGroup !== 'Select Blood Group');


            if (username === '' || email === '' || password === '' || bloodGroup === 'Select Blood Group') {
                return;
            }

            var uppercaseRegex = /[A-Z]/;
            var lowercaseRegex = /[a-z]/;
            var numberRegex = /[0-9]/;
            var validPassword = uppercaseRegex.test(password) && lowercaseRegex.test(password) && numberRegex.test(password) && password.length >= 6;


            document.getElementById('passwordError').classList.toggle('d-none', validPassword);


            if (!validPassword) {
                return;
            }

            this.submit();
        });
    </script>


</body>

</html>