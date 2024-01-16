<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form </title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="./styles/stle.css">
</head>
<body>
    <img src="<?php echo './assets/sec3-logo-lighter.svg'; ?>" alt="Logo" height="100%" style="margin-right: 30px; margin-left: 10px;" />
      
    <div class="container">
    <?php
    if (isset($_POST["login"])) {
        $email = $_POST["email"];
        $password = $_POST["password"];
        require_once"database.php";
        $sql = "SELECT * FROM users WHERE email = '$email' ";
        $result = mysqli_query($conn, $sql);
        $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
        if ($user) {
            if (password_verify($password, $user["password"])){
                header("Location: index.php"); // saan pupunta kapag naka pag log in na 
                die();

            }else{

                echo"<div class= 'alert alert-danger ' >password doest not match or exist </div>";
            }

        }else{
            echo"<div class= 'alert alert-danger ' >Email doest not match or exist </div>";
        }
    }

    ?>
        <form action="login.php" method="post">
            <div class="form-group">
                <h4>Login</h4>
                <input type="email" placeholder="Enter Email" name="email" class="form-control">     
            </div>
            <div class="form-group">
                 <input type="password" placeholder="Enter Password" name="password" class="form-control">   
            </div>
            <div class="form-btn" style="text-align: center" >
                <input type="submit" value= "LOGIN" name="login" class="btn btn-success">
         </div>
     </form><br/>
     <div style="text-align: center;"><p>Not Registered Yet? <a href="registration.php" style="color:rgb(4,170,109);">Register Here </p></div>
    </div>
</body>
</html>