<?PHP

include "dbconnect1.php";
$noteId=$_GET['note_id']+0;

$sql="DELETE FROM `notes` WHERE `noteId`='$noteId'";
$result=mysqli_query($connect,$sql);

header("location:welcome.php");

?>