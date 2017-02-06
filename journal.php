<?php
session_start();
include("common.php");
include("menubar.php");
if ($_GET['user'] !== $_SESSION['username']){ //cheack if valid user
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
            <h1>Journal Entries</h1>
            <table>
                <tr>
                    <th>Title</th>
                    <th>Date Created</th>
                </tr>
                <?php
                    $sql = "SELECT journalNumber, journalTitle, journalDate from journalEntry WHERE journalAuthor = ? ORDER BY journalDate desc";
                
                    $stmt = mysqli_prepare($link, $sql) or die("failed to prepare stm on line 26");
                    mysqli_stmt_bind_param($stmt, "s", $_SESSION['username']) or die("failed to bind param on line 27");
                    mysqli_stmt_execute($stmt) or die("failed to execulte stmt on line 28");
                    $result = mysqli_stmt_get_result($stmt);
                    foreach($result as $row){                                                                         //print out table with every journal entry's title and actions ordered by date
                        echo "<tr>";
                        echo "<td>$row[journalTitle]</td>";
                        echo "<td>$row[journalDate]</td>";
                        echo "<td><form method='GET' action='entryView.php'><input type='hidden' name='journalNumber'value='$row[journalNumber]'><input type='submit' name='submit' value='View Entry'></form></td>";
                        echo "<td><form method='POST'><input type='hidden' name='journalNumber' value='$row[journalNumber]'><input type='submit' name='delete' value='delete'></form>";
                        echo "</tr>";
                    }
                ?>
            </table>
        <br><br><br>
            <input type="button" onclick="location.href='journalEntry.php';" value="Create a new journal Entry" />
        </div>
    </body>
</html>

<?php
    if(isset($_POST["delete"])){                        //deletes selected journal entry
        $sql = "DELETE FROM journalEntry WHERE journalNumber = " . $_POST['journalNumber'];
        mysqli_query($link, $sql);
        header("Refresh:0");
    }

?>