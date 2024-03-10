<?php
    session_start();
    if(isset($_SESSION["users"])) {
        header("Location: dashboard.php");
        exit; // Make sure to exit after redirection to prevent further execution
    }

    if(isset($_POST["login"])){
        $email = $_POST["email"];
        $password = $_POST["password"];
        $errors = array();
        if (empty($email) || empty($password)) {
            array_push($errors, "Both email and password are required");
        }
        if (count($errors) > 0) {
            foreach($errors as $error) {
                echo "<div class='alert alert-danger'>$error</div>";
            }
        } else {
            // Proceed with login authentication
            require_once "regisdatabase.php";
            $sql = "SELECT * FROM registration WHERE email = ?";
            $stmt = mysqli_stmt_init($conn);
            if (mysqli_stmt_prepare($stmt, $sql)) {
                mysqli_stmt_bind_param($stmt, "s", $email);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                if ($row = mysqli_fetch_assoc($result)) {
                    if (password_verify($password, $row['password'])) {
                        // Password is correct, login successful
                        $_SESSION["users"] = $email; // Set session variable upon successful login
                        header("Location: dashboard.php");// Redirect to index.php
                        exit; // Make sure to exit after redirection to prevent further execution
                    } else {
                        // Password is incorrect
                        echo "<div class='alert alert-danger'>Incorrect password</div>";
                    }
                } else {
                    // Username not found
                    echo "<div class='alert alert-danger'>Email not found</div>";
                }
            } else {
                // SQL statement preparation failed
                echo "<div class='alert alert-danger'>Something went wrong</div>";
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="regislog.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link href="https://fonts.cdnfonts.com/css/8bit-wonder" rel="stylesheet">
</head>
<body>
    <div class="glyph">Login</div>
    <div class="container">
    <form action="index.php" method="post">
        <div class="form-group mb-3">
            <label for="email" class="form-label">Email &emsp; &nbsp; &emsp; &nbsp; &emsp; &nbsp;</label>
            <input type="text" class="form-control" name="email">
        </div>
        <div class="form-group mb-3">
            <label for="password" class="form-label">Password &emsp; &nbsp; &emsp; &nbsp;</label>
            <input type="password" class="form-control" name="password">
        </div>
        <div class="to-register">
            <p>Don't have an account? <a id="register-link" href="registration.php">Register</a></p>
        </div>
        <div class="form-btn">
            <input type="submit" id="login" name="login" value="Login" style="    
                font-family: 'Rubik Mono One', monospace;
                border-radius: 100px;
                border: none;
                background: linear-gradient(silver, black, red);
                color: white;
                cursor: pointer;
                height: 40px;
                width: 230px;">
        </div>
    </form>
    </div>
</body>
</html>