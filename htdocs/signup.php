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
        
        <div id='mainbox' class='box''>Signup:</div>
        
        <?php 
        function validate($data) {
            //Make sure no code or invalid characters are in the string variable
            return htmlspecialchars(stripslashes($data));
        }
        
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            //This data is stored in the http header for better security
            $email = validate($_POST["email"]);
            $username = validate($_POST["username"]);
            $password = validate($_POST["password"]);
            
            //Here I am selecting all user accounts with the email equal to the variable. This is to check if the email is already in use in the database. 
            $email_query = mysqli_query($db, "SELECT userid, email, username FROM users WHERE email = \"" . $email . "\"");
            
            if (mysqli_num_rows($email_query) > 0) {
                echo "<div class='box'>Email already in use</div>";
                mysqli_close($db);
                
            } else {
                //Insert the account into the database
                mysqli_query($db, "INSERT INTO users (email, username, password) VALUES (\"" . $email . "\", \"" . $username . "\", \"" . $password . "\")");
                
                session_start();
                $_SESSION["username"] = $username;
                
                //Get the user id that was generated to be saved in the session data
                $email_query = mysqli_query($db, "SELECT userid FROM users WHERE email = \"" . $email . "\"");
                $row = mysqli_fetch_assoc($email_query);
                $_SESSION["userid"] = $row["userid"];
                
                mysqli_close($db);
                //php redirection to the homepage if login is successful
                header("Location: /");
                exit();
            }
            
        }
        ?>
        
        <div class="box">
            <form action="/signup.php" method="post" id="signup">
                Email:<br>
                <input name="email" type="text"><br>
                Username:<br>
                <input name="username" type="text"><br>
                Password:<br>
                <input name="password" type="text"><br>
            </form>
        </div>
            
        <button type="submit" form="signup" value="Signup" class="button">Signup</button>
        
    </body>
</html>