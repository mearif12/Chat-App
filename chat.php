<?php
session_start();
include 'conn.php';

if (!isset($_SESSION['email'])) {
    header("location:login.php");
    exit();
}

$email = $_SESSION['email'];

//Handle new message (AJAX POST)
if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['message'])) {
    $name = $_SESSION['name'];
    $image = $_SESSION['image'];
    $message = $_POST['message'];

    $sql = "INSERT INTO message(name,email,image,message) 
            VALUES('$name','$email','$image','$message')";
    mysqli_query($conn, $sql);
    exit();
}

//Handle fetch messages (AJAX GET)
if (isset($_GET['action']) && $_GET['action'] === "load") {
    $sql = "SELECT *, DATE_FORMAT(time,'%M %e %l:%i %p') as time2 
            FROM message ORDER BY id ASC";
    $query = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_assoc($query)) {
        if ($row['email'] == $email) {
            echo "<div style='text-align:right; margin:10px 0;'>
                    <div style='display:inline-block; background:#0099FF; color:white; 
                                padding:10px; border-radius:15px; max-width:60%;'>
                        <b>{$row['message']}</b><br>
                        <small>{$row['time2']}</small>
                    </div>
                  </div>";
        } else {
            echo "<div style='text-align:left; margin:10px 0;'>
                    <img src='image/{$row['image']}' style='width:30px;height:30px;
                          border-radius:50%;vertical-align:top;margin-right:5px;'>
                    <div style='display:inline-block; background:#E4E6EB;
                                padding:10px; border-radius:15px; max-width:60%;'>
                        <b>{$row['name']}</b><br>
                        {$row['message']}<br>
                        <small>{$row['time2']}</small>
                    </div>
                  </div>";
        }
    }
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Chat App</title>
    <style>
        body { background:#F0F2F5; font-family:sans-serif; }
        #container { width:600px; margin:30px auto; background:white; 
                     box-shadow:0 0 10px gray; padding:10px; border-radius:10px; }
        #chat { height:350px; overflow-y:auto; border:1px solid #ddd; padding:10px; }
        #msgForm { display:flex; margin-top:10px; }
        #message { flex:1; padding:10px; border-radius:20px; border:1px solid #ccc; }
        #sendBtn { background:blue; color:white; border:none;
                   padding:10px 20px; border-radius:20px; cursor:pointer; }
    </style>
</head>
<body>
<div id="container">
    <div>
        <img src="image/<?php echo $_SESSION['image']; ?>" style="width:35px;height:35px;border-radius:50%;">
        <b><?php echo $_SESSION['name']; ?></b>
        <a href="logout.php" style="float:right;">Logout</a>
    </div>
    <hr>
    <div id="chat"></div>

    <form id="msgForm">
        <input type="text" id="message" name="message" placeholder="Write message..." required>
        <button id="sendBtn" type="submit">Send</button>
    </form>
</div>

<script>
async function loadMessages(){
    let res = await fetch("chat.php?action=load");
    let data = await res.text();
    document.getElementById("chat").innerHTML = data;
    let chatBox = document.getElementById("chat");
    chatBox.scrollTop = chatBox.scrollHeight;
}

document.getElementById("msgForm").addEventListener("submit", async function(e){
    e.preventDefault();
    let formData = new FormData(this);
    await fetch("chat.php", { method:"POST", body:formData });
    this.reset();
    loadMessages();
});

setInterval(loadMessages, 2000); // refresh every 2s
loadMessages();
</script>
</body>
</html>
