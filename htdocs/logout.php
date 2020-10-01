<html>

    <head>
        <link rel="stylesheet" href="style.css">
        <title>Main Page</title>
    </head>

    <body>
    
        <div id="title">
            <a class="titlename" href="/">Website</a>
            
            <?php 
            //Built in session manager in php which creates session cookies and stores temporary data in memory
            session_start();
            
            echo "<a class='titleitem' href='signup.php'>Signup</a>";
            
            echo "<a class='titleitem' href='login.php'>Login</a>";
            ?>
        </div>
        
        <?php
        session_unset();
        session_destroy();
        
        echo "<div id='mainbox' class='box''>Logged out successfully</div>";
        
        echo "<a href='/'><div class='box'>Continue</div></a>";
        ?>
        
    </body>
</html>