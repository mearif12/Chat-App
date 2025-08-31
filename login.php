<?php 
session_start();
include 'conn.php';

if (isset($_POST['login'])) {
    $email    = $_POST['email'];
    $password = $_POST['password'];

    $sql   = "SELECT * FROM user WHERE email='$email' AND password='$password'";
    $query = mysqli_query($conn, $sql);
    $data  = mysqli_fetch_array($query);

    if ($data) {
        $_SESSION['name']  = $data['name'];
        $_SESSION['email'] = $data['email'];
        $_SESSION['image'] = $data['image'];
        header("Location: chat.php");
        exit();
    } else {
        echo "<script>alert('Invalid email or password');</script>";
    }
}

if (isset($_SESSION['email'])) {
    header("Location: chat.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        #container { border:1px solid black; width:300px; padding:30px; margin:100px auto; }
        input { width:250px; height:35px; margin-bottom:10px; padding:5px; }
    </style>
</head>
<body>
    <div id="container">
        <form action="" method="POST">
            <input type="email" name="email" placeholder="Enter Email" required><br>
            <input type="password" name="password" placeholder="Enter Password" required><br>
            <input type="submit" name="login" value="Login">
            <p>No account? <a href="registration.php">Sign Up</a></p>
        </form>
    </div>
</body>
</html>
