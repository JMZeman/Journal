<?php
session_start();
include("common.php");   //db connection functions
include("menubar.php"); // links to home and logout

$link = db_connect();
global $link;
$sql = "SELECT * FROM journalEntry WHERE journalNumber = ?";
$stmt = mysqli_prepare($link, $sql) or die("failed to prepare stm on line 7");
mysqli_stmt_bind_param($stmt, "i", $_GET[journalNumber]) or die("failed to bind param on line 8");
mysqli_stmt_execute($stmt) or die("failed to execulte stmt on line 9");
$result = mysqli_stmt_get_result($stmt) or die("error for query on line 10");
$entry = mysqli_fetch_array($result, MYSQLI_ASSOC);   //get all data for the journal entry
if ($_SESSION['username'] != $entry['journalAuthor']){ //cheack if valid user
    header("location: Login.php");
}
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
                <form id="entryForm" action="" method="post">
                    <input type="hidden" name="number" value="<?php echo $entry['journalNumber']; ?>">      <!-- hidden variable for id of journal entry -->
                    <input type="text" maxlength="60" name="title" value="<?php echo $entry['journalTitle']; ?>">
                    <br>
                    <br>
                    <textarea rows="15" cols="100" name="body" form="entryForm"><?php echo $entry['journalBody']; ?></textarea>
                    <br>
                    <input type="submit" name="submit" form="entryForm" value="update">
            </form>
        </div>
        <script>                                                            //allows for tabs in the text area
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
        $sql = "UPDATE journalEntry SET journalTitle=?, journalBody=? WHERE journalNumber =$_POST[number]";
        $title = $_POST["title"];
        $body = $_POST["body"];
        $date = date("Y-m-d H:i:s");                                                    //get datetime
        if($title === ""){                                                                     //set title to untitled if void
            $title = "untitled";
        }
        echo $body;
        $stmt = mysqli_prepare($link, $sql) or die("failed to prepare stm on line 53");
        mysqli_stmt_bind_param($stmt, "ss", $title, $body) or die("failed to bind param on line 54");
        mysqli_stmt_execute($stmt) or die("failed to execulte stmt on line 55");
        header("Refresh:0");                                                                            //refresh page after update
    }

?>
