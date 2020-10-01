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
        
        <div id='mainbox' class='box''>Login:</div>
        
        <?php 
        function validate($data) {
            //Make sure no code or invalid characters are in the string variable
            return htmlspecialchars(stripslashes($data));
        }
        
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            //This data is stored in the http header for better security
            $email = validate($_POST["email"]);
            $password = validate($_POST["password"]);
            
            //Retrive any account with the specified email to check if the account exists and the password is correct
            $email_query = mysqli_query($db, "SELECT userid, email, username, password FROM users WHERE email = \"" . $email . "\"");
            
            //Make sure the account exists
            if (mysqli_num_rows($email_query) > 0) {
                $row = mysqli_fetch_assoc($email_query);
                
                //Make sure the password is correct
                if($password == $row["password"]) {
                    session_start();
                    $_SESSION["username"] = $row["username"];
                    $_SESSION["userid"] = $row["userid"];
                
                    mysqli_close($db);
                    header("Location: /");
                    exit();
                    
                } else {
                    echo "<div class='box'>Password Incorrect</div>";
                }
                
            } else {
                echo "<div class='box'>Account not found</div>";
            }
            mysqli_close($db);
            
        }
        ?>
        
        <div class="box">
            <form action="/login.php" method="post" id="login">
                Email:<br>
                <input name="email" type="text"><br>
                Password:<br>
                <input name="password" type="text"><br>
            </form>
        </div>
        
        <button type="submit" form="login" value="Login" class="button">Login</button>
        
    </body>
</html>