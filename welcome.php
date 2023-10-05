<?php
session_start();
include "dbconnect1.php";
$flag=true;
if(!isset($_SESSION['logedin']) || $_SESSION['logedin']==false){
  $flag=false;
}
else{
  $username=ucfirst($_SESSION['username']);
  $userId=$_SESSION['userid'];
}


if($_SERVER['REQUEST_METHOD']=='POST'){

  if(isset($_POST['editsrno'])){
    $note_id=$_POST['editsrno'];
    $title=$_POST['newtitle'];
    $desc=$_POST['newdesc'];
    $sql="UPDATE `notes` SET `title`='$title' ,`description`='$desc' WHERE `noteId`='$note_id'";
    $result=mysqli_query($connect,$sql);
    if($result){
      $update=true;        
    }
    else{
      echo mysqli_error($connect);
    }
  }
  else{
    $title=$_POST['title'];
    $desc=$_POST['description'];
    $sql="INSERT INTO `notes` (`userId`,`title`,`description`,`time`) VALUES ('$userId','$title','$desc',current_timestamp())";
    $result=mysqli_query($connect,$sql);
    if(!$result){
      echo mysqli_error($connect);
    }
    $insert=true;
  }
  
}

?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="welcome.css">
  <title>Welcome </title>
</head>
<body>
  <script>
    function hide1(){
          document.querySelector('#modal').style.display='none';
      }
  </script>
  
  <?php

    include 'nav1.php';
  
    if(!$flag){
      echo '        
        <div class="container my-4" >
          <div class="note">
            <form action="/script/todolist.php" method="post">
              <h1>Add a Note to iNote</h1>
              <label for="">Note Title</label>
              <input type="text" name="tit" class="m10 br input">
              <label for="">Note Description</label>
              <textarea name="description" id="" cols="30" rows="5" class="m10 br input"></textarea>              
            </form>           
            <h2 class="red">Please first login, If you want to add note or view notes </h2>
            <a href="login.php" class="goto">Go To Login</a> 
          </div>                      
        </div>            
      ';
      exit;
    }         
  ?>
  
  <div class="container my-4" >
    <div class="alert alert-success" role="alert">
      <h4 class="alert-heading">Welcome -<?php echo $username;?></h4>
      <p>Welcome to iNoteBook. You are logged in using <small><?php echo $_SESSION['email']; ?> </small>email.</p>    
    </div>
  </div>

  <main>
    <div class="note container">
        <form action="/php_project/welcome.php" method="post">
        <h1>Add a Note to iNoteBook</h1>
        <label for="">Note Title</label>
        <input type="text" name="title" class="m10 br input">
        <label for="">Note Description</label>
        <textarea name="description" id="" cols="30" rows="5" class="m10 br input"></textarea>
        <button id="submit" class="br">Add Note</button>
        </form>            
    </div>

    <div id="hr">

    <div class="modal1 br" id="modal">
        <form action="/php_project/welcome.php" method="post">
            <h1>Edit your note</h1>
            <span onclick=hide1() id="span">x</span>
            <label for="">Edit Title</label>
            <input type="text" class="br input"  name="newtitle" id="prevtitle" value="">
            <label for="Description">Edit Description</label>
            <textarea  id="prevdesc" class="br input" name="newdesc" cols="20" rows="3" value=""></textarea>
            <input type="hidden" id="editsrno" name="editsrno">
            <button id="updatebtn">Update Note</button>
        </form>
    </div>
      
    <div class="table" >
      <?PHP
      
        include "dbconnect1.php";
        $sql="SELECT * FROM `notes` WHERE `userId`=$userId";
        $result=mysqli_query($connect,$sql);
        $num=mysqli_num_rows($result);
        if($num===0){
          echo '<h2 class="container"  style="margin-top: -20px;">There is noting to display please add note</h2>';
          exit;
        }
              
        echo'<a href="delete1.php?userId='.$userId.'" class="deleteall ">Delete All Notes</a>';        
        echo '<h2 id="your_note">Your Notes :</h2>';

        echo'
          <table border="3">
            <tr>
                <th class="srno">Sr. No.</th>
                <th class="title">Note Title</th>
                <th class="desc">Note Description</th>
                <th class="time">Date & Time at which note created </th>
                <th class="actioncolumn">Action</th>              
            </tr>
        ';
              
        $i=1;
        while($row=mysqli_fetch_assoc($result)){
          echo '
            <tr>
                <td id="hide">'.$row['noteId'].'</td>
                <td>'.$i.'.</td>
                <td class="title title1" value="">'.$row['title'].'</td>
                <td class="desc">'.$row['description'].'</td>
                <td>'.$row['time'].'</td>
                <td class="actioncolumn">
                    <button id="edit" class="edit1 action">Edit</button>
                    <a id="delete" class="action" href="delete.php?note_id='.$row['noteId'].'" onclick="display()">Delete</a>
                </td>
            </tr>
          ';
          $i=$i+1;
        }
      ?>
              
          </table>

    </div>
  </main>

  <script>      
  
    let buttons=document.getElementsByClassName('edit1');

    Array.from(buttons).forEach(button=>{
        button.addEventListener('click',(e)=>{
            let tr=e.target.parentNode.parentNode;
            title=tr.getElementsByTagName("td")[2].innerText;
            desc=tr.getElementsByTagName("td")[3].innerText;
            osrno=tr.getElementsByTagName("td")[0].innerText;
          
            prevtitle.value=title;
            prevdesc.value=desc;
            editsrno.value=osrno;
            document.querySelector('.modal1').style.display='block';            
        })
    })   

  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>
</html>