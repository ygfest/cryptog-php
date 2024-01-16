<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="./styles/stle.css">

</head>
<body>
<img src="<?php echo './assets/sec3-logo-lighter.svg'; ?>" alt="Logo" height="100%" style="margin-right: 30px; margin-left: 10px;" />
<div class="container">
    <?php
    if (isset($_POST["submit"])) {
        $fullname = $_POST["fullname"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $passwordrepeat = $_POST["repeat_password"];
    
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    
        $errors = array();
    
        if (empty($fullname) OR empty($email) OR empty($password) OR empty($passwordrepeat)) {
            array_push($errors, "All fields are required");
        }
    
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            array_push($errors, "Email is not valid");
        }
    
        if (strlen($password) < 8) {
            array_push($errors, "Password must be at least 8 characters long");
        }
    
        if ($password !== $passwordrepeat) {
            array_push($errors, "Passwords do not match");
        }
    
        require_once "database.php";
        $sql = "SELECT * FROM users WHERE email = '$email' ";
        $result = mysqli_query($conn, $sql);
        $rowCount = mysqli_num_rows($result);
    
        if ($rowCount > 0) {
            array_push($errors, "Email already in use");
        }
    
        if (count($errors) > 0) {
            foreach ($errors as $error) {
                echo "<div class='alert alert-danger'>$error</div>";
            }
        } else {
            $sql = "INSERT INTO users (full_name, email, password) VALUES (?, ?, ?)";
            $stmt = mysqli_stmt_init($conn);
            $preparestmt = mysqli_stmt_prepare($stmt, $sql);
    
            if ($preparestmt) {
                mysqli_stmt_bind_param($stmt, "sss", $fullname, $email, $passwordHash);
                mysqli_stmt_execute($stmt);
                echo "<div class='alert alert-success'>You are registered successfully.</div>";
    
                // Redirect to index.php
                header("Location: index.php");
                exit();
            } else {
                die("Something went wrong");
            }
        }
    }
    ?>

        <form action="registration.php" method="post">
            <h4 style="text-align: center">Register</h4>
            <div class="form-group">
                <input type="text" class="form-control" name="fullname" placeholder="Enter your full name">
            </div>
            <div class="form-group">
                <input type="email" class="form-control" name="email" placeholder="Enter your email">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Enter your password">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="repeat_password" placeholder="Repeat password">
            </div>
            <div class="form-btn" style="text-align: center;">
                 <input type="submit" class="btn btn-success" value="Register" name="submit">
            </div>
          </form><br/>
        <div style="text-align: center; "><p>Already Registered? <a href="login.php" style="color:rgb(4,170,109);">Login Here </p></div>
     </div>
</body>
</html>