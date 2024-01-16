<?php
session_start(); // Start the session if not started already

if (isset($_POST["logout"])) {
    session_destroy();
    
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/NavBar.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Caesar Cipher</title>
</head>
<body>
<nav class="navbar bg-body-tertiary" style="height: 80px; position: fixed; left: 0; top: 0; right: 0; z-index: 1; background-color: white; border-bottom: 5px solid rgb(25,135,84);">
    <div class="container-fluid">
        <a class="navbar-brand brand-text" href="/">
            <img src="<?php echo './assets/sec3-logo.svg'; ?>" alt="Logo" height="100%" class="d-inline-block align-text-center" style="margin-right: 30px; margin-left: 10px;" />
            AIAS | Cryptography
        </a>
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <form method="post">
            <button type="submit" class="btn btn-secondary me-md-2" name="logout" >Logout</button>
            </form>
        </div>
    </div>
</nav>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
