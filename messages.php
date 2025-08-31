<?php
session_start();
include 'conn.php';

if (!isset($_SESSION['email'])) {
    exit("Not logged in");
}

$email = $_SESSION['email'];

$sql = "SELECT * , DATE_FORMAT(time,'%M %e %l:%i %p') as time2 FROM message ORDER BY id ASC";
$query = mysqli_query($conn,$sql);

while($row = mysqli_fetch_assoc($query)){
    if($row['email'] == $email){
        echo "<div style='text-align:right; margin:10px 0;'>
               <div style='display:inline-block; background:#0099FF; color:white; padding:10px; border-radius:15px; max-width:60%;'>
                 <b>{$row['message']}</b><br><br>  
                <small>{$row['time2']}</small>
               </div>
              </div>";
    } else {
        echo "<div style='text-align:left; margin:10px 0;'>
        <img class='msg-img' src='image/{$row['image']}' style='vertical-align:top; margin-right:5px;'>
        <div style='display:inline-block; background:#E4E6EB; padding:10px; border-radius:15px; max-width:60%;'>
            <b>{$row['name']}</b><br>
            {$row['message']}<br>
            <small>{$row['time2']}</small>
        </div>
      </div>";
    }
}
?>

