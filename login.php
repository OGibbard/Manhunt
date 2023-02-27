<?php
session_start();
session_destroy();
?>
<!DOCTYPE html>

<html>
    <head>
        <Title>
            Login
        </Title>    
    </head>
    <body>
        <p>Login:</p>
        <form action='loginprocess.php' method='POST'>
            <input type='text' name='username' placeholder='Username'><br>
            <input type='password' name='passwd' placeholder='Password'><br>
            <input type="submit" value="Login"> 
        </form>
        <br>
        <a href="signup.php">Click here to sign up.</a>
        <br>
        <br>
    </body>
</html>