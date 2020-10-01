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
        
        <div id='mainbox' class='box'>Topics:</div>
    
        <?php
        //Get all of the topics in the database
        $topics_query = mysqli_query($db, "SELECT topicid, name FROM topics");
        
        //Create a box for all of the topics in the database
        if (mysqli_num_rows($topics_query) > 0) {
            while($row = mysqli_fetch_assoc($topics_query)) {
                echo "<a href='/topic.php?topic=" . $row["topicid"] . "'><div class='box'>". $row["name"] . "</div></a>";
            }
        }
        mysqli_close($db);
        ?>
        
    </body>
</html>