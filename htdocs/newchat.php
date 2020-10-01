<html>

    <head>
        <link rel="stylesheet" href="style.css">
        <title>Main Page</title>
    </head>

    <body>
    
        <div id="title">
            <a class="titlename" href="/">Website</a>
            
            <?php 
            $db = mysqli_connect("localhost", "root", "", "main");
            
            //Built in session manager in php which creates session cookies and stores temporary data in memory
            session_start();
            
            //Display correct infomation based on if the user is logged in or not
            if (array_key_exists("username", $_SESSION)) {
                echo "<span class='titleitem' style='color:blue'>Welcome " . $_SESSION["username"] . "</span>";
                
                echo "<a class='titleitem' href='logout.php'>Logout</a>";
            } else {
                echo "<a class='titleitem' href='signup.php'>Signup</a>";
            
                echo "<a class='titleitem' href='login.php'>Login</a>";
            }
            ?>
        </div>
        
        <?php
        function validate($data) {
            //Make sure no code or invalid characters are in the string variable
            return htmlspecialchars(stripslashes($data));
        }
        
        //Check if the user is entering this page after creating a new chat
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = validate($_POST["name"]);
            
            //Retrive the name and topicid of the chat to make sure it does not already exist
            $name_query = mysqli_query($db, "SELECT chatid, topicid, name FROM chats WHERE name = '" . $name . "' AND topicid = '" . $_GET["topic"] . "'");
            
            if (mysqli_num_rows($name_query) > 0) {
                echo "<div class='box'>Name already in use</div>";
                
            } else {
                //Create the chat
                mysqli_query($db, "INSERT INTO chats (creatorid, topicid, name) VALUES (\"" . $_SESSION["userid"] . "\", \"" . $_GET["topic"] . "\", \"" . $name . "\")");
                
                mysqli_close($db);
                //Redirect to the topics chat list once a chat is created
                header("Location: /topic.php?topic=" . $_GET["topic"]);
                exit();
            }
            
        }
        
        //Make sure the user is logged in when creating a new chat
        if (array_key_exists("username", $_SESSION)) {
            //Get the current topic name from the topic id
            $topics_query = mysqli_query($db, "SELECT topicid, name FROM topics WHERE topicid = " . $_GET["topic"]);
            
            $row = mysqli_fetch_assoc($topics_query);
            
            echo "<div id='mainbox' class='box'>" . $row["name"] . " new chat:</div>";

            echo "<div class='box'>
                <form action='/newchat.php?topic=" . $_GET["topic"] . "' method='post' id='newchat'>
                    Name:<br>
                    <input name='name' type='text'><br>
                </form>
            </div>
                
            <button type='submit' form='newchat' value='Confirm' class='button'>Confirm</button>";
            
        } else {
            echo "<div id='mainbox' class='box'>Error:</div>";
            echo "<div class='box'>Not logged in</div>";
        }
        
        mysqli_close($db);
        ?>
        
    </body>
</html>