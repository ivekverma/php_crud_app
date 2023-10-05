<?PHP

include "dbconnect1.php";
$userId=$_GET['userId']+0;

$sql="DELETE FROM `notes` WHERE `userId`='$userId'";
$result=mysqli_query($connect,$sql);

header("location:welcome.php");

?>