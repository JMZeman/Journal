<?php
session_start();
include("common.php");   //db connection functions
include("menubar.php"); // links to home and logout
if ($_SESSION['username'] != null){ //cheack if valid user
    header("location: Login.php");
}
$link = db_connect();
global $link;
?>

<!DOCTYPE html>
<html>
    <head>
        <title>journal</title>
        <link href="master.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <br><br><br>
        <div>
            <h1>Journal Entry</h1>
        <br><br><br>
            <form id="entryForm" action="" method="post">
                <h1>Title</h1>
                <input type="text" maxlength="60" name="title">
                <br>
                <br>
                <textarea rows="15" cols="100" name="body" form="entryForm"></textarea>
                <br>
                <input type="submit" name="submit" form="entryForm" value="add to journal">
            </form>
        </div>
            <script>                                                            //allows for tags in text area
            var textareas = document.getElementsByTagName('textarea');
            var count = textareas.length;
            for(var i=0;i<count;i++){
                textareas[i].onkeydown = function(e){
                    if(e.keyCode==9 || e.which==9){
                        e.preventDefault();
                        var s = this.selectionStart;
                        this.value = this.value.substring(0,this.selectionStart) + "\t" + this.value.substring(this.selectionEnd);
                        this.selectionEnd = s+1; 
                    }
                }
            }
        </script>
    </body>
</html>

<?php
    if(isset($_POST["submit"])){
        $title = $_POST["title"];
        $body = $_POST["body"];
        $date = date("Y-m-d H:i:s");
        if($title === ""){                      //checks for title and gives an untitled title if void
            $title = "untitled";
        }
        
        $sql = "INSERT INTO journalEntry (journalDate, journalAuthor, journalBody, journalTitle) VALUES (?, ?, ?, ?)";
                
        $stmt = mysqli_prepare($link, $sql) or die("failed to prepare stm on line 44");
        mysqli_stmt_bind_param($stmt, "ssss", $date, $_SESSION['username'], $body, $title) or die("failed to bind param on line 45");
        mysqli_stmt_execute($stmt) or die("failed to execulte stmt on line 46");
        header ("location: journal.php" . "?user=" . $_SESSION['username']);        //redirect back to homepage which is journal
    }
?>