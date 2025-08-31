<?php 
include 'conn.php';

if (isset($_POST['registration'])) {
    $name     = $_POST['name'];
    $email    = $_POST['email'];
    $password = $_POST['password'];

    $image    = $_FILES['image']['name'];
    $tmp      = $_FILES['image']['tmp_name'];
    $path     = "image/".$image;

    

    move_uploaded_file($tmp, $path);

    $sql = "INSERT INTO user(name,email,password,image) VALUES('$name','$email','$password','$image')";
    $query = mysqli_query($conn, $sql);

    if ($query) {
        echo "<script>alert('Registration Successful!'); window.location='login.php';</script>";
    } else {
        echo "<script>alert('Error while registering');</script>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <style>
        #container { border:1px solid black; width:300px; padding:30px; margin:100px auto; }
        input { width:250px; height:35px; margin-bottom:10px; padding:5px; }
    </style>
</head>
<body>
    <div id="container">
        <form action="" method="POST" enctype="multipart/form-data">
            <input type="text" name="name" placeholder="Enter Name" required><br>
            <input type="email" name="email" placeholder="Enter Email" required><br>
            <input type="password" name="password" placeholder="Enter Password" required><br>
            <input type="file" name="image" required><br>
            <input type="submit" name="registration" value="Register">
            <p>Already have an account? <a href="login.php">Login</a></p>
        </form>
    </div>
</body>
</html>
