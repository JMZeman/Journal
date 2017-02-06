<?php
session_start();                //uses for login
include("common.php");
$link = db_connect();
global $link;
?>
<!DOCTYPE html>
<html>
    <head>
        <title>login</title>
        <link href="master.css" rel="stylesheet" type="text/css">
        <style>
            #wrapper {
                padding: 2%;
                margin: auto;
                height: 200px;
                width: 100%;
            }
            #registerWrapper{
                float: left;
               margin-left: 23%;
            }
            #registerWrapper,  #loginWrapper{
            }
        </style>
        
    </head>
    <body>
        <div class="wrapper" id="wrapper">
            <br><br><br><br>
            <div class="wrapper" id="registerWrapper">
            <h1>register</h1>
            <form action="" method="post">                                  <!-- this is for regerstration -->
                Username: <input type="text" name="ruser"><br>
                Password: <input type="password" name="rpassword">
                <br>
                <input type="submit" name="register" value="Register">
            </form>
            </div>
            <div class="wrapper" id="loginWrapper">
            <h1>login</h1>
            <form action="" method="post">                                     <!-- this is for login -->
                Username: <input type="text" name="luser"><br>
                Password: <input type="password" name="lpassword">
                <br>
                <input type="submit" name="login" value="Login">
            </form>
            </div>
        </div>
        
        <?php
        if($_POST['register']){ //register new user function
            $myusername = mysqli_real_escape_string($link,$_POST['ruser']);
            $mypassword = password_hash(mysqli_real_escape_string($link,$_POST['rpassword']), PASSWORD_DEFAULT);            //hash password
            $sql = "SELECT password FROM User WHERE username = ?";
            
            $stmt = mysqli_prepare($link, $sql);
            mysqli_stmt_bind_param($stmt, "s", $myusername) or die("failed to bind param on line 57");
            mysqli_stmt_execute($stmt) or die("failed to execulte stmt on line 58");
            $result = mysqli_stmt_get_result($stmt);
            
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            $count = mysqli_num_rows($result);

            if($count != 0){            //cheacks if another user has the same username

                echo "username is taken please use another";
        
            }
            else{                                                   //otherwise continue
                $sql = "INSERT INTO User (username, password) VALUES (?, ?)";
                
                $stmt = mysqli_prepare($link, $sql);
                mysqli_stmt_bind_param($stmt, "ss", $myusername, $mypassword) or die("failed to bind param on line 74");
                mysqli_stmt_execute($stmt) or die("failed to execulte stmt on line 76");
                $result = mysqli_stmt_get_result($stmt);
                
                echo "succesfully registered, you may login now";
            }    

            
            
        }
        if($_POST['login']){                                                    //for login
            echo "in login<br>";
            $myusername = mysqli_real_escape_string($link,$_POST['luser']);
            $mypassword = mysqli_real_escape_string($link,$_POST['lpassword']); 
            $sql = "SELECT password FROM User WHERE username = '$myusername'";
            if($result = mysqli_query($link, $sql)){
                $hash = mysqli_fetch_array($result, MYSQLI_ASSOC);
                if(password_verify($mypassword, $hash[password])){              //verify that hashes match
                    $_SESSION['username'] = $_POST['luser'];
                    echo $_SESSION['username'];
                    header ("location: journal.php" . "?user=" . $_SESSION['username']);
                }
                    else{
                        echo "your username or password is invalid";
                    }
            }
            
        }
        
        ?>
        
</body>
</html>