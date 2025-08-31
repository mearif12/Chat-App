<?php  
session_start();
include 'conn.php';

if (!isset($_SESSION['email'])) {
    header("location:login.php");
    exit();
}

$email = $_SESSION['email'];

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $name    = $_SESSION['name'];
    $image   = $_SESSION['image'];
    $message = $_POST['message'];

    $sql = "INSERT INTO message(name,email,image,message) VALUES('$name','$email','$image','$message')";
    mysqli_query($conn,$sql);
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Chat App</title>
    <style>
        body { background:#F0F2F5; font-family:sans-serif; }
        #container { width:600px; margin:30px auto; background:white; box-shadow:0 0 10px gray; padding:10px; border-radius:10px; }
        #chat { height:350px; overflow-y:auto; border:1px solid #ddd; padding:10px; }
        .msg-self { background:#0099FF; color:white; padding:10px; border-radius:15px; margin:5px 0 5px auto; max-width:60%; }
        .msg-other { background:#E4E6EB; padding:10px; border-radius:15px; margin:5px; max-width:60%; }
        .msg-img { width:35px; height:35px; border-radius:50%; vertical-align:middle; margin-right:10px; }
        #msgForm { display:flex; margin-top:10px; }
        #message { flex:1; padding:10px; border-radius:20px; border:1px solid #ccc; }
        #sendBtn { background:blue; color:white; border:none; padding:10px 20px; border-radius:20px; cursor:pointer; }
    </style>
</head>
<body>
    <div id="container">
        <div>
            <img class="msg-img" src="image/<?php echo $_SESSION['image']; ?>">
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
            let res = await fetch("messages.php");
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

        setInterval(loadMessages, 90000); // refresh every 2s
        loadMessages();


    </script>
</body>
</html>
