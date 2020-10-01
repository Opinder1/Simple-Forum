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
                
                echo '<a class="titleitem" href="logout.php">Logout</a>';
            } else {
                echo '<a class="titleitem" href="signup.php">Signup</a>';
            
                echo '<a class="titleitem" href="login.php">Login</a>';
            }
            ?>
        </div>
        
        <?php
        function validate($data) {
            //Make sure no code or invalid characters are in the string variable
            return htmlspecialchars(stripslashes($data));
        }
        
        //If the user has just attempted to post a comment
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $content = validate($_POST["content"]);
            
            //Create the comment
            mysqli_query($db, "INSERT INTO comments (posterid, chatid, content) VALUES ('" . $_SESSION["userid"] . "', '" . $_GET["chat"] . "', '" . $content . "')");
            
        }
        
        if (array_key_exists("chat", $_GET)) {
            //Retrive the chat to make sure it exists and get its name
            $chats_query = mysqli_query($db, "SELECT chatid, name FROM chats WHERE chatid = " . $_GET["chat"]);
            
            $row_c = mysqli_fetch_assoc($chats_query);
        
            if (mysqli_num_rows($chats_query) > 0) {
            
                echo "<div id='mainbox' class='box''>" . $row_c["name"] . ":</div>";
                
                //Retrive all comments posted in the current chat
                $comment_query = mysqli_query($db, "SELECT * FROM comments JOIN users ON comments.posterid = users.userid AND comments.chatid = '" . $row_c["chatid"] . "'");
                
                while($row = mysqli_fetch_assoc($comment_query)) {
                    echo "<div class='box'>" . $row["username"] . ": " . $row["content"] . "</div>";
                }
                
                //Only give the option to post comments if the user is logged in
                if (array_key_exists("username", $_SESSION)) {
                    echo "
                        <form action='/chat.php?chat=" . $_GET["chat"] . "' method='post' id='chat'>
                            <input name='content' type='text' class='box' style='background-color:#dddddd'><br>
                        </form>
                        
                    <button type='submit' form='chat' value='Send' class='button' style='background-color:#dddddd'>Send</button>";
                }
                
            } else {
                echo "<div id='mainbox' class='box'>Error:</div>";
                echo "<div class='box'>Chat not found</div>";
            }
            
            echo "";
            
        } else {
            echo "<div id='mainbox' class='box'>Error:</div>";
            echo "<div class='box'>Chat not found</div>";
        }
        
        ?>
        
    </body>
</html>